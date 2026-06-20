@extends('layouts.customer')

@section('title', 'Riwayat Pesanan')

@php
    $statusColors = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'diproses' => 'bg-blue-100 text-blue-800',
        'siap' => 'bg-purple-100 text-purple-800',
        'selesai' => 'bg-green-100 text-green-800',
        'dibatalkan' => 'bg-red-100 text-red-800',
    ];
    $statusLabels = [
        'pending' => 'Pending',
        'diproses' => 'Diproses',
        'siap' => 'Siap Diambil',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];
@endphp

@section('content')
    <h1 class="text-2xl font-bold text-stone-900">Riwayat Pesanan</h1>

    <div class="mt-6 space-y-4">
        @forelse($orders as $order)
            <a href="{{ route('customer.orders.show', $order) }}" class="card block transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold">Pesanan #{{ $order->id }}</p>
                        <p class="text-sm text-stone-500">{{ $order->created_at->format('d M Y, H:i') }} · {{ ucfirst(str_replace('_', ' ', $order->tipe_pesanan)) }}</p>
                    </div>
                    <div class="text-right">
                        <span class="badge {{ $statusColors[$order->status_pesanan] ?? '' }}">{{ $statusLabels[$order->status_pesanan] ?? $order->status_pesanan }}</span>
                        <p class="mt-1 font-bold text-amber-800">{{ rupiah($order->total_harga) }}</p>
                    </div>
                </div>
            </a>
        @empty
            <div class="card text-center text-stone-500">Belum ada pesanan.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
@endsection
