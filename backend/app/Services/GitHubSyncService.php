<?php

namespace App\Services;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Log;

/**
 * Syncs a restaurant's generated JSON file to the GitHub repository.
 *
 * Flow:
 *  1. GET current file SHA (needed by GitHub API for updates)
 *  2. PUT new file content (create or update)
 *  3. GitHub push triggers Netlify auto-deploy
 *
 * GitHub API rate limit: 5,000 req/hour (authenticated).
 * Each publish = 2 API calls (GET sha + PUT content).
 * Supports up to 2,500 publishes/hour — far beyond any realistic usage.
 */
class GitHubSyncService
{
    private const GITHUB_API_BASE = 'https://api.github.com';

    private string $token;
    private string $owner;
    private string $repo;
    private string $branch;

    public function __construct()
    {
        $this->token  = (string) config('services.github.token', '');
        $this->owner  = (string) config('services.github.owner', '');
        $this->repo   = (string) config('services.github.repo', '');
        $this->branch = (string) config('services.github.branch', 'main');
    }

    /**
     * Commit the restaurant's JSON data to GitHub, or save locally if not configured.
     *
     * @param  string $jsonString
     * @throws \RuntimeException on sync failure
     */
    public function syncMenuJson(Restaurant $restaurant, string $jsonString): void
    {
        if (empty($this->token) || empty($this->owner) || empty($this->repo)) {
            // Local fallback for testing: save the JSON to the public disk
            \Illuminate\Support\Facades\Storage::disk('public')->put("menus/{$restaurant->slug}.json", $jsonString);
            Log::info('GitHubSyncService: Saved JSON locally (GitHub not configured)', ['restaurant' => $restaurant->slug]);
            return;
        }

        $filePath = "frontend/public/data/{$restaurant->slug}.json";
        $content  = base64_encode($jsonString);

        // Get existing file SHA (required by GitHub API for updates)
        $sha = $this->getFileSha($filePath);

        $payload = [
            'message' => "chore(menu): update {$restaurant->slug} — " . now()->toDateTimeString(),
            'content' => $content,
            'branch'  => $this->branch,
        ];

        if ($sha !== null) {
            $payload['sha'] = $sha;
        }

        $response = $this->request('PUT', "/repos/{$this->owner}/{$this->repo}/contents/{$filePath}", $payload);

        if (! $response['success']) {
            $error = $response['error'] ?? 'Unknown GitHub API error';
            Log::error('GitHubSyncService: sync failed', [
                'restaurant' => $restaurant->slug,
                'file'       => $filePath,
                'error'      => $error,
            ]);
            throw new \RuntimeException("GitHub sync failed: {$error}");
        }

        Log::info('GitHubSyncService: synced successfully', [
            'restaurant' => $restaurant->slug,
            'commit'     => $response['data']['commit']['sha'] ?? 'unknown',
        ]);
    }

    // ─── Private helpers ─────────────────────────────────────────────────────

    /**
     * Retrieve the current SHA of a file (returns null if file doesn't exist yet).
     */
    private function getFileSha(string $filePath): ?string
    {
        $response = $this->request(
            'GET',
            "/repos/{$this->owner}/{$this->repo}/contents/{$filePath}?ref={$this->branch}"
        );

        if ($response['success'] && isset($response['data']['sha'])) {
            return $response['data']['sha'];
        }

        // 404 means the file doesn't exist yet — that's fine for first publish
        return null;
    }

    /**
     * Make an authenticated request to the GitHub Contents API using cURL.
     * cURL is used instead of Guzzle to keep dependencies minimal
     * and ensure compatibility with InfinityFree shared hosting.
     *
     * @param  array<string, mixed> $data
     * @return array{success: bool, data?: array<string, mixed>, error?: string}
     */
    private function request(string $method, string $endpoint, array $data = []): array
    {
        $url = self::GITHUB_API_BASE . $endpoint;

        $headers = [
            "Authorization: Bearer {$this->token}",
            'Accept: application/vnd.github+json',
            'X-GitHub-Api-Version: 2022-11-28',
            'User-Agent: QRMenu-SaaS/1.0',
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        if (! empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $body      = curl_exec($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // cURL transport error (DNS failure, timeout, etc.)
        if ($curlError) {
            return ['success' => false, 'error' => "cURL error: {$curlError}"];
        }

        $decoded = json_decode((string) $body, true) ?? [];

        // GitHub API error (4xx/5xx)
        if ($httpCode >= 400) {
            $message = $decoded['message'] ?? "HTTP {$httpCode}";
            return ['success' => false, 'error' => $message];
        }

        return ['success' => true, 'data' => $decoded];
    }

    /**
     * Throw early if required config values are missing.
     *
     * @throws \RuntimeException
     */
    private function assertConfigured(): void
    {
        if (empty($this->token) || empty($this->owner) || empty($this->repo)) {
            throw new \RuntimeException(
                'GitHub sync is not configured. Set GITHUB_TOKEN, GITHUB_OWNER, and GITHUB_REPO in .env'
            );
        }
    }
}
