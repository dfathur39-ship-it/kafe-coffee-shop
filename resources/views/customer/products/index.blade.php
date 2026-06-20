@extends('layouts.customer')

@section('title', 'Katalog Menu')

@section('content')
    <h1 class="text-2xl font-bold text-stone-900">Katalog Menu</h1>
    <p class="mt-1 text-stone-500">Pilih menu favoritmu dan tambahkan ke keranjang</p>

    <form method="GET" class="mt-6 flex flex-wrap gap-3">
        <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari menu..." class="input-field max-w-xs">
        <select name="kategori" class="input-field max-w-xs" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" @selected(request('kategori') === $cat->slug)>{{ $cat->nama_kategori }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary">Cari</button>
    </form>

    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($products as $product)
            <div class="card">
                @if($product->foto)
                    <img src="{{ $product->foto_url }}" alt="{{ $product->nama_produk }}" class="mb-4 h-40 w-full rounded-lg object-cover">
                @else
                    <div class="mb-4 flex h-40 items-center justify-center rounded-lg bg-amber-50 text-4xl">☕</div>
                @endif
                <span class="badge bg-amber-100 text-amber-800">{{ $product->category->nama_kategori }}</span>
                <h3 class="mt-2 text-lg font-semibold">{{ $product->nama_produk }}</h3>
                <p class="mt-1 text-sm text-stone-500">{{ $product->deskripsi }}</p>
                <p class="mt-2 text-lg font-bold text-amber-800">{{ rupiah($product->harga) }}</p>

                @if($product->isAvailable())
                    <form method="POST" action="{{ route('customer.cart.store') }}" class="mt-4 space-y-2 border-t border-amber-50 pt-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex gap-2">
                            <input type="number" name="kuantitas" value="1" min="1" max="99" class="input-field w-20">
                            <input type="text" name="catatan" placeholder="Catatan (less sugar...)" class="input-field flex-1 text-sm">
                        </div>
                        <button type="submit" class="btn-primary w-full text-sm">Tambah ke Keranjang</button>
                    </form>
                @else
                    <span class="badge mt-4 bg-red-100 text-red-700">Habis</span>
                @endif
            </div>
        @empty
            <p class="col-span-full text-center text-stone-500">Tidak ada produk ditemukan.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $products->links() }}</div>
@endsection
