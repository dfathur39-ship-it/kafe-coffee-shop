<?php

namespace App\Console\Commands;

use App\Services\SupabaseStorageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SetupSupabaseStorageCommand extends Command
{
    protected $signature = 'kafe:setup-storage';

    protected $description = 'Siapkan bucket Supabase Storage untuk foto menu';

    public function handle(SupabaseStorageService $storage): int
    {
        $this->info('Menyiapkan bucket Supabase Storage...');

        try {
            $this->setupViaDatabase();
            $this->components->info('Bucket database/storage policy siap.');
        } catch (\Throwable $e) {
            $this->warn('Setup via SQL: '.$e->getMessage());
        }

        if (filled(config('supabase.service_role_key'))) {
            try {
                $storage->ensureBucketExists();
                $this->components->info('Bucket API Supabase siap.');
            } catch (\Throwable $e) {
                $this->warn('Setup via API: '.$e->getMessage());
            }
        } else {
            $this->warn('SUPABASE_SERVICE_ROLE_KEY belum diisi — upload membutuhkan key ini.');
            $this->line('Ambil di: Supabase Dashboard → Project Settings → API → service_role (secret)');
        }

        $this->newLine();
        $this->line('Bucket: '.config('supabase.storage.bucket', 'menu-images'));

        return self::SUCCESS;
    }

    private function setupViaDatabase(): void
    {
        $sql = File::get(database_path('sql/002_supabase_storage.sql'));

        foreach (array_filter(array_map('trim', preg_split('/;\s*\n/', $sql))) as $statement) {
            if (str_starts_with($statement, '--') || blank($statement)) {
                continue;
            }
            try {
                DB::unprepared($statement);
            } catch (\Throwable $e) {
                if (! str_contains($e->getMessage(), 'already exists')) {
                    throw $e;
                }
            }
        }
    }
}
