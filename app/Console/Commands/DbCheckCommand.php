<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DbCheckCommand extends Command
{
    protected $signature = 'kafe:db-check';

    protected $description = 'Cek koneksi Supabase PostgreSQL dan status tabel';

    public function handle(): int
    {
        $this->info('Menguji koneksi ke: '.config('database.connections.pgsql.host'));

        try {
            DB::connection()->getPdo();
            $this->components->info('Koneksi database berhasil.');
        } catch (\Throwable $e) {
            $this->error('Koneksi gagal: '.$e->getMessage());
            $this->newLine();
            $this->line('Isi DB_HOST dan DB_PASSWORD di file .env, lalu jalankan ulang.');

            return self::FAILURE;
        }

        $tables = ['users', 'categories', 'products', 'orders', 'order_items'];

        $this->newLine();
        $this->line('Status tabel:');

        foreach ($tables as $table) {
            $exists = DB::getSchemaBuilder()->hasTable($table);
            $status = $exists ? '<fg=green>OK</>' : '<fg=yellow>BELUM ADA</>';
            $this->line("  {$table}: {$status}");
        }

        if (DB::getSchemaBuilder()->hasTable('categories')) {
            $this->newLine();
            $this->line('  Kategori: '.Category::count());
            $this->line('  Admin: '.User::where('role', 'admin')->count());
        }

        return self::SUCCESS;
    }
}
