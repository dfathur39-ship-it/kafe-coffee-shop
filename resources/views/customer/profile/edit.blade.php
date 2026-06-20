@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')
    <h1 class="text-2xl font-bold text-stone-900">Profil Saya</h1>

    <div class="mt-6 grid gap-8 lg:grid-cols-2">
        <form method="POST" action="{{ route('customer.profile.update') }}" class="card space-y-4">
            @csrf @method('PATCH')
            <h2 class="font-semibold">Data Diri</h2>
            <div>
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="input-field mt-1">
            </div>
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="input-field mt-1">
            </div>
            <div>
                <label class="block text-sm font-medium">Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="input-field mt-1">
            </div>
            <div>
                <label class="block text-sm font-medium">Alamat</label>
                <textarea name="address" rows="2" class="input-field mt-1">{{ old('address', $user->address) }}</textarea>
            </div>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>

        <form method="POST" action="{{ route('customer.profile.password') }}" class="card space-y-4">
            @csrf @method('PUT')
            <h2 class="font-semibold">Ganti Password</h2>
            <div>
                <label class="block text-sm font-medium">Password Saat Ini</label>
                <input type="password" name="current_password" required class="input-field mt-1">
            </div>
            <div>
                <label class="block text-sm font-medium">Password Baru</label>
                <input type="password" name="password" required class="input-field mt-1">
            </div>
            <div>
                <label class="block text-sm font-medium">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required class="input-field mt-1">
            </div>
            <button type="submit" class="btn-primary">Ubah Password</button>
        </form>
    </div>
@endsection
