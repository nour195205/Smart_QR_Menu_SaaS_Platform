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
        $this->branch = (string) config('services.github.branch', 'main');
        
        $owner = (string) config('services.github.owner', '');
        $repo  = (string) config('services.github.repo', '');
        
        // Handle case where user puts 'owner/repo' inside GITHUB_REPO directly
        if (str_contains($repo, '/')) {
            $parts = explode('/', $repo);
            $this->owner = $parts[0];
            $this->repo = $parts[1];
        } else {
            $this->owner = $owner;
            $this->repo = $repo;
        }
    }

    /**
     * Commit the restaurant's JSON data to GitHub, or save locally if not configured.
     *
     * @param  string $jsonString
     * @throws \RuntimeException on sync failure
     */
    public function syncMenuJson(Restaurant $restaurant, string $jsonString): void
    {
        Log::info('GitHubSyncService: Starting sync process for restaurant', ['slug' => $restaurant->slug]);

        // ALWAYS save locally for the local React app to read during development/testing
        $localPath = "menus/{$restaurant->slug}.json";
        \Illuminate\Support\Facades\Storage::disk('public')->put($localPath, $jsonString);

        // Also save the tiny version file locally (for local dev Two-Step Version Check)
        $versionPath = "menus/{$restaurant->slug}-version.json";
        $generatedAt = json_decode($jsonString, true)['generated_at'] ?? now()->toIso8601String();
        \Illuminate\Support\Facades\Storage::disk('public')->put(
            $versionPath,
            json_encode(['v' => $generatedAt])
        );

        Log::info("GitHubSyncService: Saved JSON + version file locally.");

        if (empty($this->token) || empty($this->owner) || empty($this->repo)) {
            Log::warning('GitHubSyncService: GitHub config is missing. Only saved locally.', [
                'has_token' => !empty($this->token),
                'owner'     => $this->owner,
                'repo'      => $this->repo
            ]);
            return;
        }

        $commitMessage = "chore(menu): update {$restaurant->slug} — " . now()->toDateTimeString();

        // 1. Push the full menu JSON
        $jsonPath = "frontend/public/data/{$restaurant->slug}.json";
        $this->pushFile($jsonPath, $jsonString, $commitMessage);

        // 2. Push the tiny version file (~40 bytes)
        //    The frontend fetches this first to decide whether to download the full JSON.
        $versionFilePath = "frontend/public/data/{$restaurant->slug}-version.json";
        $versionContent  = json_encode(['v' => $generatedAt]);
        $this->pushFile($versionFilePath, $versionContent, $commitMessage . ' [version]');

        Log::info('GitHubSyncService: Full JSON + version file synced to GitHub.', [
            'slug' => $restaurant->slug,
        ]);
    }

    /**
     * Push (create or update) a single file on GitHub.
     *
     * @throws \RuntimeException on API failure
     */
    private function pushFile(string $filePath, string $rawContent, string $commitMessage): void
    {
        $content = base64_encode($rawContent);
        $sha     = $this->getFileSha($filePath);

        $payload = [
            'message' => $commitMessage,
            'content' => $content,
            'branch'  => $this->branch,
        ];

        if ($sha !== null) {
            $payload['sha'] = $sha;
        }

        $endpoint = "/repos/{$this->owner}/{$this->repo}/contents/{$filePath}";
        $response = $this->request('PUT', $endpoint, $payload);

        if (! $response['success']) {
            $error = $response['error'] ?? 'Unknown GitHub API error';
            Log::error('GitHubSyncService: Upload failed', [
                'endpoint' => $endpoint,
                'error'    => $error,
            ]);

            if (str_contains(strtolower($error), 'bad credentials')) {
                throw new \RuntimeException('GitHub API Error: Invalid GITHUB_TOKEN provided.');
            } elseif (str_contains(strtolower($error), 'not found')) {
                throw new \RuntimeException("GitHub API Error: Repository '{$this->owner}/{$this->repo}' not found.");
            } elseif (str_contains(strtolower($error), 'branch')) {
                throw new \RuntimeException("GitHub API Error: Branch '{$this->branch}' not found.");
            }

            throw new \RuntimeException("GitHub sync failed for {$filePath}: {$error}");
        }

        Log::info('GitHubSyncService: File pushed to GitHub.', ['path' => $filePath]);
    }

    // ─── Private helpers ─────────────────────────────────────────────────────

    /**
     * Retrieve the current SHA of a file (returns null if file doesn't exist yet).
     */
    private function getFileSha(string $filePath): ?string
    {
        $endpoint = "/repos/{$this->owner}/{$this->repo}/contents/{$filePath}?ref={$this->branch}";
        Log::debug("GitHubSyncService: GET request to check file SHA", ['endpoint' => $endpoint]);

        $response = $this->request('GET', $endpoint);

        if ($response['success'] && isset($response['data']['sha'])) {
            return $response['data']['sha'];
        }

        return null;
    }

    /**
     * Make an authenticated request to the GitHub Contents API using cURL.
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

        if ($curlError) {
            Log::error("GitHubSyncService: cURL transport error", ['error' => $curlError]);
            return ['success' => false, 'error' => "cURL error: {$curlError}"];
        }

        $decoded = json_decode((string) $body, true) ?? [];

        if ($httpCode >= 400) {
            $message = $decoded['message'] ?? "HTTP {$httpCode}";
            Log::error("GitHubSyncService: API error {$httpCode}", ['response' => $decoded]);
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
