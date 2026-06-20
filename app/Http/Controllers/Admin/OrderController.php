<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status_pesanan' => ['required', 'in:pending,diproses,siap,selesai,dibatalkan'],
        ]);

        $updates = ['status_pesanan' => $data['status_pesanan']];

        if ($data['status_pesanan'] === Order::STATUS_SELESAI) {
            $updates['payment_status'] = 'paid';
        }

        $order->update($updates);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
