<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ConnectSupabaseCommand extends Command
{
    protected $signature = 'kafe:connect-supabase
                            {--ref= : Supabase project reference (contoh: abcdefghijklmnop)}
                            {--password= : Database password dari Supabase}
                            {--migrate : Jalankan migration setelah koneksi berhasil}
                            {--seed : Jalankan seeder setelah migration}';

    protected $description = 'Hubungkan Laravel ke Supabase PostgreSQL dan uji koneksi';

    public function handle(): int
    {
        $ref = $this->option('ref') ?: $this->ask('Supabase Project Ref (dari URL dashboard)');
        $password = $this->option('password') ?: $this->secret('Database Password Supabase');

        if (blank($ref) || blank($password)) {
            $this->error('Project Ref dan Password wajib diisi.');

            return self::FAILURE;
        }

        $ref = Str::trim($ref);
        $host = "db.{$ref}.supabase.co";

        $this->updateEnv([
            'APP_NAME' => '"Kafe Coffee Shop"',
            'APP_URL' => 'http://kafe.test',
            'DB_CONNECTION' => 'pgsql',
            'DB_HOST' => $host,
            'DB_PORT' => '5432',
            'DB_DATABASE' => 'postgres',
            'DB_USERNAME' => 'postgres',
            'DB_PASSWORD' => $password,
            'DB_SSLMODE' => 'require',
            'SUPABASE_PROJECT_REF' => $ref,
            'SUPABASE_URL' => "https://{$ref}.supabase.co",
        ]);

        $this->info('File .env telah diperbarui. Menguji koneksi...');

        config([
            'database.default' => 'pgsql',
            'database.connections.pgsql.host' => $host,
            'database.connections.pgsql.port' => '5432',
            'database.connections.pgsql.database' => 'postgres',
            'database.connections.pgsql.username' => 'postgres',
            'database.connections.pgsql.password' => $password,
            'database.connections.pgsql.sslmode' => 'require',
        ]);

        DB::purge('pgsql');

        try {
            DB::connection('pgsql')->getPdo();
            $version = DB::connection('pgsql')->selectOne('SELECT version()')->version;
            $this->components->info('Koneksi Supabase berhasil!');
            $this->line('  Host: '.$host);
            $this->line('  PostgreSQL: '.Str::limit($version, 60));
        } catch (\Throwable $e) {
            $this->error('Koneksi gagal: '.$e->getMessage());
            $this->newLine();
            $this->warn('Pastikan:');
            $this->line('  1. Project Ref benar (dari Settings → General → Reference ID)');
            $this->line('  2. Password database benar (Settings → Database)');
            $this->line('  3. Project Supabase sudah aktif (tidak paused)');

            return self::FAILURE;
        }

        if ($this->option('migrate') || $this->confirm('Jalankan migration sekarang?', true)) {
            $this->call('migrate', ['--force' => true]);

            if ($this->option('seed') || $this->confirm('Jalankan seeder (kategori, admin, produk)?', true)) {
                $this->call('db:seed', ['--force' => true]);
            }
        }

        $this->newLine();
        $this->components->info('Setup selesai!');
        $this->line('  Admin: admin@kafe.test / password');

        return self::SUCCESS;
    }

    private function updateEnv(array $values): void
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            copy(base_path('.env.example'), $envPath);
        }

        $content = file_get_contents($envPath);

        foreach ($values as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $line = "{$key}={$value}";

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $line, $content);
            } else {
                $content .= PHP_EOL.$line;
            }
        }

        file_put_contents($envPath, $content);
    }
}
