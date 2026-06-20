<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index(): View
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('items.product');

        return view('customer.orders.show', compact('order'));
    }

    public function checkout(): View|RedirectResponse
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('customer.cart.index')->with('error', 'Keranjang masih kosong.');
        }

        return view('customer.checkout.index', [
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('customer.cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $data = $request->validate([
            'tipe_pesanan' => ['required', 'in:dine_in,takeaway'],
            'nomor_meja' => ['nullable', 'required_if:tipe_pesanan,dine_in', 'string', 'max:20'],
            'alamat_pengiriman' => ['nullable', 'string', 'max:500'],
            'metode_pembayaran' => ['required', 'in:cash,qris,transfer,midtrans'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $items = $this->cart->items();

        foreach ($items as $item) {
            if (! $item['product']->isAvailable()) {
                return back()->with('error', "{$item['product']->nama_produk} sedang habis.");
            }
        }

        $order = DB::transaction(function () use ($data, $items) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_harga' => $this->cart->total(),
                'status_pesanan' => Order::STATUS_PENDING,
                'tipe_pesanan' => $data['tipe_pesanan'],
                'nomor_meja' => $data['nomor_meja'] ?? null,
                'alamat_pengiriman' => $data['alamat_pengiriman'] ?? null,
                'metode_pembayaran' => $data['metode_pembayaran'],
                'payment_status' => 'pending',
                'catatan' => $data['catatan'] ?? null,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'kuantitas' => $item['kuantitas'],
                    'harga_satuan' => $item['product']->harga,
                    'catatan' => $item['catatan'],
                ]);
            }

            return $order;
        });

        $this->cart->clear();

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat! Menunggu konfirmasi.');
    }
}
