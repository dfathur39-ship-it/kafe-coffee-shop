@extends('layouts.admin')

@section('title', 'Daftar Menu')
@section('header', 'Manajemen Menu')

@section('content')
    @include('components.alert')

    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-stone-500 dark:text-stone-400">{{ $products->total() }} menu terdaftar</p>
        <a href="{{ route('admin.menu.create') }}" class="btn-primary text-sm">+ Tambah Menu Baru</a>
    </div>

    <div class="card overflow-x-auto p-0">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-amber-100 bg-amber-50/50 dark:border-stone-700 dark:bg-stone-800/80">
                <tr>
                    <th class="px-4 py-3">Foto</th>
                    <th class="px-4 py-3">Nama Menu</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Stok</th>
                    <th class="px-4 py-3">Unggulan</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-b border-amber-50 dark:border-stone-700/50">
                        <td class="px-4 py-3">
                            @if($product->foto)
                                <img src="{{ $product->foto_url }}" alt="{{ $product->nama_produk }}"
                                     class="h-12 w-12 rounded-lg object-cover">
                            @else
                                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-amber-50 text-xl dark:bg-stone-700">☕</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-stone-900 dark:text-stone-100">{{ $product->nama_produk }}</td>
                        <td class="px-4 py-3 text-stone-600 dark:text-stone-400">{{ $product->category->nama_kategori }}</td>
                        <td class="px-4 py-3">{{ rupiah($product->harga) }}</td>
                        <td class="px-4 py-3">
                            <span class="badge {{ $product->stok_status === 'tersedia' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300' }}">
                                {{ ucfirst($product->stok_status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $product->is_featured ? '⭐' : '—' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-amber-700 hover:underline dark:text-amber-400">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Hapus menu ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="ml-2 text-red-600 hover:underline dark:text-red-400">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
@endsection
