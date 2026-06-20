<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            'coffee' => [
                ['nama' => 'Espresso Klasik', 'deskripsi' => 'Single origin Arabica dengan rasa bold.', 'harga' => 25000],
                ['nama' => 'Cappuccino Velvet', 'deskripsi' => 'Espresso, susu steamed, dan foam lembut.', 'harga' => 32000],
                ['nama' => 'V60 Pour Over', 'deskripsi' => 'Seduh manual dengan biji pilihan hari ini.', 'harga' => 30000],
            ],
            'non-coffee' => [
                ['nama' => 'Matcha Latte', 'deskripsi' => 'Matcha premium Jepang dengan susu oat.', 'harga' => 35000],
                ['nama' => 'Chocolate Frappe', 'deskripsi' => 'Cokelat Belgia blended dengan es.', 'harga' => 33000],
            ],
            'snack' => [
                ['nama' => 'Croissant Butter', 'deskripsi' => 'Croissant renyah dengan mentega premium.', 'harga' => 28000],
                ['nama' => 'Banana Bread', 'deskripsi' => 'Roti pisang homemade, hangat.', 'harga' => 22000],
            ],
            'makanan-berat' => [
                ['nama' => 'Nasi Goreng Kafe', 'deskripsi' => 'Nasi goreng spesial dengan telur dan ayam.', 'harga' => 38000],
            ],
        ];

        foreach ($products as $slug => $items) {
            $category = Category::where('slug', $slug)->first();

            if (! $category) {
                continue;
            }

            foreach ($items as $index => $item) {
                Product::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'nama_produk' => $item['nama'],
                    ],
                    [
                        'deskripsi' => $item['deskripsi'],
                        'harga' => $item['harga'],
                        'stok_status' => Product::STOK_TERSEDIA,
                        'is_featured' => $index === 0,
                    ]
                );
            }
        }
    }
}
