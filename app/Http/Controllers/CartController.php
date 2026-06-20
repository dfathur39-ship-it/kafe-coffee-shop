<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index(): View
    {
        return view('customer.cart.index', [
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'kuantitas' => ['required', 'integer', 'min:1', 'max:99'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);

        $product = Product::findOrFail($data['product_id']);

        if (! $product->isAvailable()) {
            return back()->with('error', 'Produk sedang habis.');
        }

        $this->cart->add($product->id, $data['kuantitas'], $data['catatan'] ?? null);

        return back()->with('success', "{$product->nama_produk} ditambahkan ke keranjang.");
    }

    public function update(Request $request, int $productId): RedirectResponse
    {
        $data = $request->validate([
            'kuantitas' => ['required', 'integer', 'min:0', 'max:99'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);

        $this->cart->update($productId, $data['kuantitas'], $data['catatan'] ?? null);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(int $productId): RedirectResponse
    {
        $this->cart->remove($productId);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
