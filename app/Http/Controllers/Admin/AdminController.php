<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $totalPendapatan = Order::where('status_pesanan', Order::STATUS_SELESAI)->sum('total_harga');
        $pesananHariIni = Order::whereDate('created_at', today())->count();
        $pesananPending = Order::where('status_pesanan', Order::STATUS_PENDING)->count();
        $totalPelanggan = User::where('role', User::ROLE_CUSTOMER)->count();

        $produkTerlaris = Product::query()
            ->select('products.*', DB::raw('COALESCE(SUM(order_items.kuantitas), 0) as total_terjual'))
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        $pesananTerbaru = Order::with('user')->latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'totalPendapatan',
            'pesananHariIni',
            'pesananPending',
            'totalPelanggan',
            'produkTerlaris',
            'pesananTerbaru'
        ));
    }
}
