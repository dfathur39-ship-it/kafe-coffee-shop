@extends('layouts.admin')

@section('title', 'Edit Menu')
@section('header', 'Edit Menu')

@section('content')
    @include('components.alert')

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="card max-w-4xl space-y-6">
        @csrf @method('PUT')
        @include('admin.products._form')
        <div class="flex gap-3 border-t border-amber-100 pt-4 dark:border-stone-700">
            <button type="submit" class="btn-primary">Perbarui Menu</button>
            <a href="{{ route('admin.products.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
@endsection
