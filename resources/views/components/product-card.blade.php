<div class="card group overflow-hidden transition hover:shadow-md dark:hover:shadow-stone-900/50">
    @if($product->foto)
        <img src="{{ $product->foto_url }}" alt="{{ $product->nama_produk }}" class="mb-4 h-40 w-full rounded-lg object-cover">
    @else
        <div class="mb-4 flex h-40 items-center justify-center rounded-lg bg-amber-50 text-4xl dark:bg-stone-700">☕</div>
    @endif
    <span class="badge bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">{{ $product->category->nama_kategori }}</span>
    <h3 class="mt-2 text-lg font-semibold text-stone-900 dark:text-stone-100">{{ $product->nama_produk }}</h3>
    <p class="mt-1 line-clamp-2 text-sm text-stone-500 dark:text-stone-400">{{ $product->deskripsi }}</p>
    <div class="mt-4 flex items-center justify-between">
        <span class="text-lg font-bold text-amber-800 dark:text-amber-400">{{ rupiah($product->harga) }}</span>
        @isset($showAddButton)
            @if($product->isAvailable())
                <form method="POST" action="{{ route('customer.cart.store') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="kuantitas" value="1">
                    <button type="submit" class="btn-primary text-xs">+ Keranjang</button>
                </form>
            @else
                <span class="badge bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300">Habis</span>
            @endif
        @endisset
    </div>
</div>
