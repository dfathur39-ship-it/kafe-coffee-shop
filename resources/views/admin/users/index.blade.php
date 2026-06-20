@extends('layouts.admin')

@section('header', 'Daftar Pelanggan')

@section('content')
    <div class="card overflow-x-auto p-0">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-amber-100 bg-amber-50/50">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Telepon</th>
                    <th class="px-4 py-3">Terdaftar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-b border-amber-50">
                        <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ $user->phone ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
