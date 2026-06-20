<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::with('category')
            ->where('is_featured', true)
            ->where('stok_status', Product::STOK_TERSEDIA)
            ->latest()
            ->take(4)
            ->get();

        return view('home.index', compact('featuredProducts'));
    }
}
