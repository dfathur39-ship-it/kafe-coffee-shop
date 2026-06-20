<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    private const SESSION_KEY = 'cart';

    public function all(): array
    {
        return session(self::SESSION_KEY, []);
    }

    public function items(): Collection
    {
        $cart = $this->all();

        if (empty($cart)) {
            return collect();
        }

        $products = Product::with('category')
            ->whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        return collect($cart)->map(function (array $item, int $productId) use ($products) {
            $product = $products->get($productId);

            if (! $product) {
                return null;
            }

            return [
                'product' => $product,
                'kuantitas' => $item['kuantitas'],
                'catatan' => $item['catatan'] ?? '',
                'subtotal' => $product->harga * $item['kuantitas'],
            ];
        })->filter()->values();
    }

    public function count(): int
    {
        return collect($this->all())->sum('kuantitas');
    }

    public function total(): float
    {
        return $this->items()->sum('subtotal');
    }

    public function add(int $productId, int $kuantitas = 1, ?string $catatan = null): void
    {
        $cart = $this->all();
        $existing = $cart[$productId] ?? ['kuantitas' => 0, 'catatan' => ''];

        $cart[$productId] = [
            'kuantitas' => $existing['kuantitas'] + $kuantitas,
            'catatan' => $catatan ?? $existing['catatan'],
        ];

        session([self::SESSION_KEY => $cart]);
    }

    public function update(int $productId, int $kuantitas, ?string $catatan = null): void
    {
        $cart = $this->all();

        if ($kuantitas <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = [
                'kuantitas' => $kuantitas,
                'catatan' => $catatan ?? ($cart[$productId]['catatan'] ?? ''),
            ];
        }

        session([self::SESSION_KEY => $cart]);
    }

    public function remove(int $productId): void
    {
        $cart = $this->all();
        unset($cart[$productId]);
        session([self::SESSION_KEY => $cart]);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }
}
