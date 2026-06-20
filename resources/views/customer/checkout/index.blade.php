@extends('layouts.customer')

@section('title', 'Checkout')

@section('content')
    <h1 class="text-2xl font-bold text-stone-900">Checkout</h1>

    <div class="mt-6 grid gap-8 lg:grid-cols-2">
        <form method="POST" action="{{ route('customer.orders.store') }}" class="card space-y-4">
            @csrf
            <h2 class="font-semibold">Detail Pesanan</h2>

            <div>
                <label class="block text-sm font-medium">Tipe Pesanan</label>
                <select name="tipe_pesanan" id="tipe_pesanan" class="input-field mt-1" required>
                    <option value="dine_in">Dine In</option>
                    <option value="takeaway">Takeaway</option>
                </select>
            </div>

            <div id="meja_field">
                <label class="block text-sm font-medium">Nomor Meja</label>
                <input type="text" name="nomor_meja" value="{{ old('nomor_meja') }}" class="input-field mt-1" placeholder="Contoh: A3">
            </div>

            <div>
                <label class="block text-sm font-medium">Alamat / Catatan Pengiriman</label>
                <textarea name="alamat_pengiriman" rows="2" class="input-field mt-1" placeholder="Opsional untuk takeaway">{{ old('alamat_pengiriman') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Metode Pembayaran</label>
                <select name="metode_pembayaran" class="input-field mt-1" required>
                    <option value="cash">Tunai (Cash)</option>
                    <option value="qris">QRIS</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="midtrans">Midtrans (Coming Soon)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Catatan Pesanan</label>
                <textarea name="catatan" rows="2" class="input-field mt-1" placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
            </div>

            <button type="submit" class="btn-primary w-full">Buat Pesanan — {{ rupiah($total) }}</button>
        </form>

        <div class="card">
            <h2 class="font-semibold">Ringkasan</h2>
            <ul class="mt-4 space-y-3">
                @foreach($items as $item)
                    <li class="flex justify-between text-sm">
                        <span>{{ $item['product']->nama_produk }} × {{ $item['kuantitas'] }}</span>
                        <span>{{ rupiah($item['subtotal']) }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4 flex justify-between border-t border-amber-100 pt-4 font-bold">
                <span>Total</span>
                <span class="text-amber-800">{{ rupiah($total) }}</span>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('tipe_pesanan').addEventListener('change', function() {
            document.getElementById('meja_field').style.display = this.value === 'dine_in' ? 'block' : 'none';
        });
    </script>
@endsection
