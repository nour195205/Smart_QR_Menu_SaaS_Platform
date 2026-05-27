<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * Handles image and PDF uploads to Cloudinary.
 *
 * Uses the Cloudinary REST Upload API directly (no SDK required).
 * Keeps dependencies minimal for InfinityFree shared hosting compatibility.
 */
class CloudinaryService
{
    private string $cloudName;
    private string $apiKey;
    private string $apiSecret;

    public function __construct()
    {
        $this->cloudName = (string) config('services.cloudinary.cloud_name', '');
        $this->apiKey    = (string) config('services.cloudinary.api_key', '');
        $this->apiSecret = (string) config('services.cloudinary.api_secret', '');
    }

    /**
     * Upload an image file to Cloudinary.
     *
     * @param  string $filePath Absolute path to the temp file
     * @param  string $folder   Cloudinary folder
     * @return array{url: string, public_id: string}
     */
    public function uploadImage(string $filePath, string $folder = 'menu-images'): array
    {
        return $this->upload($filePath, $folder, 'image');
    }

    /**
     * Upload a PDF file to Cloudinary.
     *
     * @param  string $filePath Absolute path to the temp file
     * @param  string $folder   Cloudinary folder
     * @return array{url: string, public_id: string}
     */
    public function uploadPdf(string $filePath, string $folder = 'menu-pdfs'): array
    {
        // PDFs should be uploaded as 'raw' or 'image' (if we want Cloudinary to render pages).
        // Let's use 'image' so Cloudinary can generate thumbnails if needed,
        // but 'raw' is safer for pure download/viewing. Let's stick to 'raw' or 'image' 
        // based on standard usage. Actually, auto works.
        return $this->upload($filePath, $folder, 'auto');
    }

    /**
     * Delete a resource from Cloudinary by public_id.
     */
    public function delete(string $publicId, string $resourceType = 'image'): void
    {
        if (! $this->isConfigured() || empty($publicId)) {
            return;
        }

        $timestamp = time();
        $params = [
            'public_id' => $publicId,
            'timestamp' => $timestamp,
        ];
        
        $signature = $this->generateSignature($params);
        
        $postFields = [
            'public_id' => $publicId,
            'timestamp' => $timestamp,
            'api_key'   => $this->apiKey,
            'signature' => $signature,
        ];

        $url = "https://api.cloudinary.com/v1_1/{$this->cloudName}/{$resourceType}/destroy";

        $this->executeCurl($url, $postFields);
    }

    // ─── Private helpers ─────────────────────────────────────────────────────

    private function upload(string $filePath, string $folder, string $resourceType): array
    {
        if (! $this->isConfigured()) {
            // Local fallback for testing without Cloudinary credentials
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            if (!$extension && $resourceType === 'auto') $extension = 'pdf';
            if (!$extension) $extension = 'jpg';
            
            $filename = uniqid() . '.' . $extension;
            $path = $folder . '/' . $filename;
            
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, file_get_contents($filePath));
            
            return [
                'url'       => asset('storage/' . $path),
                'public_id' => 'local_' . uniqid(),
            ];
        }

        $timestamp = time();
        $params = [
            'folder'    => $folder,
            'timestamp' => $timestamp,
        ];

        $signature = $this->generateSignature($params);

        $postFields = [
            'file'      => new \CURLFile($filePath),
            'folder'    => $folder,
            'timestamp' => $timestamp,
            'api_key'   => $this->apiKey,
            'signature' => $signature,
        ];

        $url = "https://api.cloudinary.com/v1_1/{$this->cloudName}/{$resourceType}/upload";

        $response = $this->executeCurl($url, $postFields);

        if (empty($response['secure_url']) || empty($response['public_id'])) {
            $error = $response['error']['message'] ?? 'Unknown Cloudinary error';
            Log::error('Cloudinary upload failed', ['response' => $response]);
            throw new \RuntimeException("Cloudinary upload failed: {$error}");
        }

        return [
            'url'       => $response['secure_url'],
            'public_id' => $response['public_id'],
        ];
    }

    private function generateSignature(array $params): string
    {
        ksort($params);
        $parts = [];
        foreach ($params as $k => $v) {
            $parts[] = "{$k}={$v}";
        }
        $toSign = implode('&', $parts) . $this->apiSecret;
        
        return sha1($toSign);
    }

    private function executeCurl(string $url, array $postFields): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $body = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            throw new \RuntimeException("cURL error during Cloudinary request: {$curlError}");
        }

        return json_decode((string) $body, true) ?? [];
    }

    private function isConfigured(): bool
    {
        return ! empty($this->cloudName) && ! empty($this->apiKey) && ! empty($this->apiSecret);
    }
}
