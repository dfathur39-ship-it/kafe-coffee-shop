@extends('layouts.admin')

@section('title', 'Tambah Menu Baru')
@section('header', 'Tambah Menu Baru')

@section('content')
    @include('components.alert')

    <div class="mb-6">
        <p class="text-sm text-stone-500 dark:text-stone-400">
            Tambahkan menu kopi atau makanan baru. Foto akan diunggah ke
            <strong>Supabase Storage</strong> (bucket: <code class="text-amber-700 dark:text-amber-400">{{ config('supabase.storage.bucket') }}</code>)
            dan URL publiknya tersimpan di database.
        </p>
    </div>

    <form method="POST" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data" class="card max-w-4xl space-y-6">
        @csrf
        @include('admin.products._form')
        <div class="flex gap-3 border-t border-amber-100 pt-4 dark:border-stone-700">
            <button type="submit" class="btn-primary">Simpan Menu</button>
            <a href="{{ route('admin.products.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
@endsection
