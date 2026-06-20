<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category')->where('stok_status', Product::STOK_TERSEDIA);

        if ($request->filled('kategori')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->kategori));
        }

        if ($request->filled('cari')) {
            $query->where('nama_produk', 'ilike', '%'.$request->cari.'%');
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('nama_kategori')->get();

        return view('customer.products.index', compact('products', 'categories'));
    }
}
