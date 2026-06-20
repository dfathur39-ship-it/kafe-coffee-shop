@extends('layouts.customer')

@section('title', 'Detail Pesanan #'.$order->id)

@php
    $statusLabels = ['pending' => 'Pending', 'diproses' => 'Diproses', 'siap' => 'Siap Diambil', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'];
@endphp

@section('content')
    <a href="{{ route('customer.orders.index') }}" class="text-sm text-amber-700 hover:underline">← Kembali</a>
    <h1 class="mt-2 text-2xl font-bold">Pesanan #{{ $order->id }}</h1>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="card">
            <h2 class="font-semibold">Info Pesanan</h2>
            <dl class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-stone-500">Status</dt><dd class="font-medium">{{ $statusLabels[$order->status_pesanan] ?? $order->status_pesanan }}</dd></div>
                <div class="flex justify-between"><dt class="text-stone-500">Tipe</dt><dd>{{ ucfirst(str_replace('_', ' ', $order->tipe_pesanan)) }}</dd></div>
                @if($order->nomor_meja)<div class="flex justify-between"><dt class="text-stone-500">Meja</dt><dd>{{ $order->nomor_meja }}</dd></div>@endif
                <div class="flex justify-between"><dt class="text-stone-500">Pembayaran</dt><dd>{{ strtoupper($order->metode_pembayaran) }}</dd></div>
                <div class="flex justify-between"><dt class="text-stone-500">Tanggal</dt><dd>{{ $order->created_at->format('d M Y, H:i') }}</dd></div>
            </dl>
        </div>

        <div class="card">
            <h2 class="font-semibold">Item Pesanan</h2>
            <ul class="mt-4 space-y-3">
                @foreach($order->items as $item)
                    <li class="flex justify-between text-sm">
                        <div>
                            <p class="font-medium">{{ $item->product->nama_produk }} × {{ $item->kuantitas }}</p>
                            @if($item->catatan)<p class="text-xs text-amber-700">{{ $item->catatan }}</p>@endif
                        </div>
                        <span>{{ rupiah($item->subtotal()) }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4 flex justify-between border-t border-amber-100 pt-4 font-bold">
                <span>Total</span>
                <span class="text-amber-800">{{ rupiah($order->total_harga) }}</span>
            </div>
        </div>
    </div>
@endsection
