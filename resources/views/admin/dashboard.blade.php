@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
    @include('components.alert')

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="card">
            <p class="text-sm text-stone-500">Total Pendapatan</p>
            <p class="mt-2 text-2xl font-bold text-amber-800">{{ rupiah($totalPendapatan) }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-stone-500">Pesanan Hari Ini</p>
            <p class="mt-2 text-2xl font-bold text-stone-900">{{ $pesananHariIni }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-stone-500">Pesanan Pending</p>
            <p class="mt-2 text-2xl font-bold text-yellow-600">{{ $pesananPending }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-stone-500">Total Pelanggan</p>
            <p class="mt-2 text-2xl font-bold text-stone-900">{{ $totalPelanggan }}</p>
        </div>
    </div>

    <div class="mt-8 grid gap-8 lg:grid-cols-2">
        <div class="card">
            <h2 class="font-semibold">Produk Terlaris</h2>
            <ul class="mt-4 space-y-3">
                @forelse($produkTerlaris as $product)
                    <li class="flex items-center justify-between text-sm">
                        <span>{{ $product->nama_produk }}</span>
                        <span class="badge bg-amber-100 text-amber-800">{{ $product->total_terjual }} terjual</span>
                    </li>
                @empty
                    <li class="text-sm text-stone-500">Belum ada data penjualan.</li>
                @endforelse
            </ul>
        </div>

        <div class="card">
            <h2 class="font-semibold">Pesanan Terbaru</h2>
            <ul class="mt-4 space-y-3">
                @foreach($pesananTerbaru as $order)
                    <li class="flex items-center justify-between text-sm">
                        <div>
                            <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-amber-800 hover:underline">#{{ $order->id }}</a>
                            <p class="text-stone-500">{{ $order->user->name }}</p>
                        </div>
                        <span>{{ rupiah($order->total_harga) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
