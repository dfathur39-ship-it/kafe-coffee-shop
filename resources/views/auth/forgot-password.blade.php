@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
    <h2 class="text-xl font-bold text-stone-900">Lupa Password</h2>
    <p class="mt-1 text-sm text-stone-500">Masukkan email untuk menerima link reset password.</p>

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-stone-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="input-field mt-1">
        </div>
        <button type="submit" class="btn-primary w-full">Kirim Link Reset</button>
    </form>

    <p class="mt-4 text-center text-sm"><a href="{{ route('customer.login') }}" class="text-amber-700 hover:underline">← Kembali ke login</a></p>
@endsection
