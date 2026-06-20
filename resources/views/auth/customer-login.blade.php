@extends('layouts.guest')

@section('title', 'Masuk Pelanggan')

@section('content')
    <h2 class="text-xl font-bold text-stone-900">Masuk Pelanggan</h2>
    <p class="mt-1 text-sm text-stone-500">Belum punya akun? <a href="{{ route('customer.register') }}" class="text-amber-700 hover:underline">Daftar</a></p>

    <form method="POST" action="{{ route('customer.login') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-stone-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="input-field mt-1">
        </div>
        <div>
            <label class="block text-sm font-medium text-stone-700">Password</label>
            <input type="password" name="password" required class="input-field mt-1">
        </div>
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Ingat saya</label>
            <a href="{{ route('password.request') }}" class="text-sm text-amber-700 hover:underline">Lupa password?</a>
        </div>
        <button type="submit" class="btn-primary w-full">Masuk</button>
    </form>

    <p class="mt-6 text-center text-xs text-stone-400">
        Admin? <a href="{{ route('admin.login') }}" class="text-amber-700 hover:underline">Login di sini</a>
    </p>
@endsection
