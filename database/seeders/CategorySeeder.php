<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Coffee',
            'Non-Coffee',
            'Snack',
            'Makanan Berat',
        ];

        foreach ($categories as $nama) {
            DB::table('categories')->updateOrInsert(
                ['slug' => Str::slug($nama)],
                [
                    'nama_kategori' => $nama,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
