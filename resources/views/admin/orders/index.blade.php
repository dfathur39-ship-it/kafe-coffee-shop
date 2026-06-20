@extends('layouts.admin')

@section('header', 'Manajemen Pesanan')

@php
    $statusLabels = ['pending' => 'Pending', 'diproses' => 'Diproses', 'siap' => 'Siap', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'];
@endphp

@section('content')
    @include('components.alert')

    <form method="GET" class="mb-4">
        <select name="status" class="input-field max-w-xs" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            @foreach($statusLabels as $val => $label)
                <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </form>

    <div class="card overflow-x-auto p-0">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-amber-100 bg-amber-50/50">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Pelanggan</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr class="border-b border-amber-50">
                        <td class="px-4 py-3 font-medium">#{{ $order->id }}</td>
                        <td class="px-4 py-3">{{ $order->user->name }}</td>
                        <td class="px-4 py-3">{{ rupiah($order->total_harga) }}</td>
                        <td class="px-4 py-3">{{ $statusLabels[$order->status_pesanan] ?? $order->status_pesanan }}</td>
                        <td class="px-4 py-3">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-amber-700 hover:underline">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $orders->links() }}</div>
@endsection
