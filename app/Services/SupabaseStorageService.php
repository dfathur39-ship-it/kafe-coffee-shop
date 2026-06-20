<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SupabaseStorageService
{
    public function upload(UploadedFile $file, string $folder = 'menu'): string
    {
        $this->ensureConfigured();

        $bucket = $this->bucket();
        $path = trim($folder, '/').'/'.Str::uuid().'.'.$file->getClientOriginalExtension();

        $response = Http::withHeaders(array_merge($this->authHeaders(), [
            'Content-Type' => $file->getMimeType(),
            'x-upsert' => 'false',
        ]))->withBody(
            file_get_contents($file->getRealPath()),
            $file->getMimeType()
        )->post("{$this->baseUrl()}/storage/v1/object/{$bucket}/{$path}");

        if (! $response->successful()) {
            throw new \RuntimeException(
                'Upload ke Supabase Storage gagal: '.$response->json('message', $response->body())
            );
        }

        return $this->publicUrl($path);
    }

    public function delete(?string $foto): void
    {
        if (blank($foto)) {
            return;
        }

        $this->ensureConfigured();

        $path = $this->extractPath($foto);

        if (! $path) {
            return;
        }

        Http::withHeaders($this->authHeaders())
            ->delete("{$this->baseUrl()}/storage/v1/object/{$this->bucket()}/{$path}");
    }

    public function publicUrl(string $path): string
    {
        return "{$this->baseUrl()}/storage/v1/object/public/{$this->bucket()}/".ltrim($path, '/');
    }

    public function ensureBucketExists(): bool
    {
        $this->ensureConfigured();

        $bucket = $this->bucket();
        $list = Http::withHeaders($this->authHeaders())
            ->get("{$this->baseUrl()}/storage/v1/bucket");

        if ($list->successful()) {
            $exists = collect($list->json())->contains(fn ($b) => ($b['name'] ?? $b['id'] ?? '') === $bucket);
            if ($exists) {
                return true;
            }
        }

        $create = Http::withHeaders(array_merge($this->authHeaders(), [
            'Content-Type' => 'application/json',
        ]))->post("{$this->baseUrl()}/storage/v1/bucket", [
            'name' => $bucket,
            'public' => true,
            'file_size_limit' => 2097152,
            'allowed_mime_types' => ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'],
        ]);

        if (! $create->successful()) {
            throw new \RuntimeException(
                'Gagal membuat bucket Supabase: '.$create->json('message', $create->body())
            );
        }

        return true;
    }

    public function extractPath(string $foto): ?string
    {
        if (str_starts_with($foto, 'http')) {
            $pattern = '#/storage/v1/object/public/'.preg_quote($this->bucket(), '#').'/(.+)$#';
            if (preg_match($pattern, $foto, $matches)) {
                return $matches[1];
            }

            return null;
        }

        return str_starts_with($foto, 'products/') ? null : $foto;
    }

    private function ensureConfigured(): void
    {
        if (blank($this->apiKey()) || blank(config('supabase.url'))) {
            throw new \RuntimeException(
                'Supabase belum dikonfigurasi. Isi SUPABASE_URL dan SUPABASE_SERVICE_ROLE_KEY di file .env'
            );
        }
    }

    private function authHeaders(): array
    {
        $key = $this->apiKey();

        // Key baru Supabase (sb_secret_ / sb_publishable_) — pakai header apikey saja
        if (str_starts_with($key, 'sb_secret_') || str_starts_with($key, 'sb_publishable_')) {
            return ['apikey' => $key];
        }

        // Legacy JWT key (eyJ...)
        return [
            'apikey' => $key,
            'Authorization' => 'Bearer '.$key,
        ];
    }

    private function apiKey(): string
    {
        return config('supabase.service_role_key') ?: config('supabase.anon_key');
    }

    private function bucket(): string
    {
        return config('supabase.storage.bucket', 'menu-images');
    }

    private function baseUrl(): string
    {
        return rtrim(config('supabase.url'), '/');
    }
}
