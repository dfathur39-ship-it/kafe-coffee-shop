@extends('layouts.admin')

@section('header', 'Detail Pesanan #'.$order->id)

@php
    $statusLabels = ['pending' => 'Pending', 'diproses' => 'Diproses', 'siap' => 'Siap Diambil/Diantar', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'];
@endphp

@section('content')
    @include('components.alert')

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="card">
            <h2 class="font-semibold">Info Pesanan</h2>
            <dl class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-stone-500">Pelanggan</dt><dd>{{ $order->user->name }} ({{ $order->user->email }})</dd></div>
                <div class="flex justify-between"><dt class="text-stone-500">Tipe</dt><dd>{{ ucfirst(str_replace('_', ' ', $order->tipe_pesanan)) }}</dd></div>
                @if($order->nomor_meja)<div class="flex justify-between"><dt class="text-stone-500">Meja</dt><dd>{{ $order->nomor_meja }}</dd></div>@endif
                <div class="flex justify-between"><dt class="text-stone-500">Pembayaran</dt><dd>{{ strtoupper($order->metode_pembayaran) }}</dd></div>
                <div class="flex justify-between"><dt class="text-stone-500">Total</dt><dd class="font-bold text-amber-800">{{ rupiah($order->total_harga) }}</dd></div>
            </dl>

            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="mt-6 space-y-3 border-t border-amber-100 pt-4">
                @csrf @method('PATCH')
                <label class="block text-sm font-medium">Ubah Status</label>
                <select name="status_pesanan" class="input-field">
                    @foreach($statusLabels as $val => $label)
                        <option value="{{ $val }}" @selected($order->status_pesanan === $val)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary text-sm">Update Status</button>
            </form>
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
        </div>
    </div>
@endsection
