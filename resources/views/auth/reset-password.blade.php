@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
    <h2 class="text-xl font-bold text-stone-900">Reset Password</h2>

    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div>
            <label class="block text-sm font-medium text-stone-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $email) }}" required class="input-field mt-1">
        </div>
        <div>
            <label class="block text-sm font-medium text-stone-700">Password Baru</label>
            <input type="password" name="password" required class="input-field mt-1">
        </div>
        <div>
            <label class="block text-sm font-medium text-stone-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required class="input-field mt-1">
        </div>
        <button type="submit" class="btn-primary w-full">Reset Password</button>
    </form>
@endsection
