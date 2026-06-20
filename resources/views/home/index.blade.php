@extends('layouts.app')

@section('title', config('app.name').' — Kedai Kopi Modern')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-amber-900 via-amber-800 to-stone-900 text-white">
        <div class="mx-auto flex max-w-7xl flex-col items-center gap-8 px-4 py-24 sm:px-6 lg:flex-row lg:px-8 lg:py-32">
            <div class="flex-1 text-center lg:text-left">
                <p class="mb-4 text-sm font-medium uppercase tracking-widest text-amber-200">Selamat Datang</p>
                <h1 class="text-4xl font-bold leading-tight sm:text-5xl lg:text-6xl">
                    Rasakan Kopi<br><span class="text-amber-300">Terbaik di Kota</span>
                </h1>
                <p class="mt-6 max-w-lg text-lg text-amber-100">Biji pilihan, seduhan sempurna, dan suasana yang membuat setiap kunjungan istimewa.</p>
                <div class="mt-8 flex flex-wrap justify-center gap-4 lg:justify-start">
                    @auth
                        @if(auth()->user()->isCustomer())
                            <a href="{{ route('customer.products.index') }}" class="btn-primary bg-white text-amber-900 hover:bg-amber-50">Pesan Sekarang</a>
                        @endif
                    @else
                        <a href="{{ route('customer.register') }}" class="btn-primary bg-white text-amber-900 hover:bg-amber-50">Pesan Sekarang</a>
                        <a href="{{ route('customer.login') }}" class="btn-secondary border-white/30 text-white hover:bg-white/10">Masuk</a>
                    @endauth
                </div>
            </div>
            <div class="flex h-64 w-64 items-center justify-center rounded-full bg-amber-700/30 text-8xl lg:h-80 lg:w-80">☕</div>
        </div>
    </section>

    {{-- Tentang --}}
    <section id="tentang" class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                <div>
                    <h2 class="text-3xl font-bold text-stone-900 dark:text-stone-100">Tentang Kami</h2>
                    <p class="mt-4 leading-relaxed text-stone-600 dark:text-stone-400">
                        {{ config('app.name') }} lahir dari kecintaan pada kopi berkualitas. Kami memilih biji kopi langsung dari petani lokal
                        dan menyeduhnya dengan teknik terbaik — dari espresso klasik hingga pour over manual.
                    </p>
                    <p class="mt-4 leading-relaxed text-stone-600 dark:text-stone-400">
                        Tempat kami dirancang sebagai ruang nyaman untuk bekerja, bertemu teman, atau sekadar menikmati secangkir kopi di pagi hari.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="card text-center"><p class="text-3xl font-bold text-amber-800 dark:text-amber-400">50+</p><p class="text-sm text-stone-500 dark:text-stone-400">Menu</p></div>
                    <div class="card text-center"><p class="text-3xl font-bold text-amber-800 dark:text-amber-400">1K+</p><p class="text-sm text-stone-500 dark:text-stone-400">Pelanggan</p></div>
                    <div class="card text-center"><p class="text-3xl font-bold text-amber-800 dark:text-amber-400">4.9</p><p class="text-sm text-stone-500 dark:text-stone-400">Rating</p></div>
                    <div class="card text-center"><p class="text-3xl font-bold text-amber-800 dark:text-amber-400">5th</p><p class="text-sm text-stone-500 dark:text-stone-400">Tahun</p></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Produk Unggulan --}}
    <section id="menu" class="bg-amber-50/50 py-20 dark:bg-stone-800/50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-stone-900 dark:text-stone-100">Produk Unggulan</h2>
                <p class="mt-2 text-stone-600 dark:text-stone-400">Menu terlaris pilihan barista kami</p>
            </div>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($featuredProducts as $product)
                    @include('components.product-card', ['product' => $product])
                @empty
                    <p class="col-span-full text-center text-stone-500">Belum ada produk unggulan. Jalankan seeder setelah koneksi database.</p>
                @endforelse
            </div>
            <div class="mt-10 text-center">
                <a href="{{ auth()->check() && auth()->user()->isCustomer() ? route('customer.products.index') : route('customer.register') }}" class="btn-primary">Lihat Semua Menu</a>
            </div>
        </div>
    </section>

    {{-- Testimoni --}}
    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-3xl font-bold text-stone-900 dark:text-stone-100">Apa Kata Pelanggan</h2>
            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @foreach([
                    ['nama' => 'Rina S.', 'teks' => 'Kopinya enak banget! Suasana cozy, cocok buat WFH. Matcha lattenya favoritku.'],
                    ['nama' => 'Budi P.', 'teks' => 'Pelayanan cepat dan ramah. Cappuccino-nya creamy, croissant-nya fresh tiap pagi.'],
                    ['nama' => 'Dewi A.', 'teks' => 'Tempat favorit keluarga di akhir pekan. Anak-anak suka chocolate frappe-nya!'],
                ] as $review)
                    <div class="card">
                        <div class="mb-3 text-amber-500">★★★★★</div>
                        <p class="text-sm leading-relaxed text-stone-600 dark:text-stone-400">"{{ $review['teks'] }}"</p>
                        <p class="mt-4 text-sm font-semibold text-stone-900 dark:text-stone-100">— {{ $review['nama'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
