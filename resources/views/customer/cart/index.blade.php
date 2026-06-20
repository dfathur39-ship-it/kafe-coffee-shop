@extends('layouts.customer')

@section('title', 'Keranjang')

@section('content')
    <h1 class="text-2xl font-bold text-stone-900">Keranjang Belanja</h1>

    @if($items->isEmpty())
        <div class="card mt-8 text-center">
            <p class="text-stone-500">Keranjang masih kosong.</p>
            <a href="{{ route('customer.products.index') }}" class="btn-primary mt-4 inline-flex">Lihat Menu</a>
        </div>
    @else
        <div class="mt-6 space-y-4">
            @foreach($items as $item)
                <div class="card flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-lg bg-amber-50 text-2xl">☕</div>
                        <div>
                            <h3 class="font-semibold">{{ $item['product']->nama_produk }}</h3>
                            <p class="text-sm text-stone-500">{{ rupiah($item['product']->harga) }} / item</p>
                            @if($item['catatan'])
                                <p class="text-xs text-amber-700">Catatan: {{ $item['catatan'] }}</p>
                            @endif
                        </div>
                    </div>
                    <form method="POST" action="{{ route('customer.cart.update', $item['product']->id) }}" class="flex items-center gap-3">
                        @csrf @method('PATCH')
                        <input type="number" name="kuantitas" value="{{ $item['kuantitas'] }}" min="0" max="99" class="input-field w-20">
                        <input type="hidden" name="catatan" value="{{ $item['catatan'] }}">
                        <button type="submit" class="btn-secondary text-xs">Update</button>
                    </form>
                    <div class="text-right">
                        <p class="font-bold text-amber-800">{{ rupiah($item['subtotal']) }}</p>
                        <form method="POST" action="{{ route('customer.cart.destroy', $item['product']->id) }}" class="mt-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card mt-6 flex items-center justify-between">
            <span class="text-lg font-semibold">Total</span>
            <span class="text-2xl font-bold text-amber-800">{{ rupiah($total) }}</span>
        </div>

        <div class="mt-6 text-right">
            <a href="{{ route('customer.checkout') }}" class="btn-primary">Lanjut Checkout →</a>
        </div>
    @endif
@endsection
