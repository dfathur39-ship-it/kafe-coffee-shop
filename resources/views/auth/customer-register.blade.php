@extends('layouts.guest')

@section('title', 'Daftar Pelanggan')

@section('content')
    <h2 class="text-xl font-bold text-stone-900">Daftar Akun</h2>
    <p class="mt-1 text-sm text-stone-500">Sudah punya akun? <a href="{{ route('customer.login') }}" class="text-amber-700 hover:underline">Masuk</a></p>

    <form method="POST" action="{{ route('customer.register') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-stone-700">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="input-field mt-1">
        </div>
        <div>
            <label class="block text-sm font-medium text-stone-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="input-field mt-1">
        </div>
        <div>
            <label class="block text-sm font-medium text-stone-700">No. Telepon</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="input-field mt-1">
        </div>
        <div>
            <label class="block text-sm font-medium text-stone-700">Password</label>
            <input type="password" name="password" required class="input-field mt-1">
        </div>
        <div>
            <label class="block text-sm font-medium text-stone-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required class="input-field mt-1">
        </div>
        <button type="submit" class="btn-primary w-full">Daftar</button>
    </form>
@endsection
