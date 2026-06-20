<nav class="sticky top-0 z-50 border-b border-amber-100 bg-white/90 backdrop-blur dark:border-stone-700 dark:bg-stone-900/90">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="text-xl font-bold text-amber-800 dark:text-amber-400">☕ {{ config('app.name') }}</a>

        <div class="hidden items-center gap-6 md:flex">
            <a href="{{ route('home') }}#tentang" class="text-sm text-stone-600 hover:text-amber-800 dark:text-stone-300 dark:hover:text-amber-400">Tentang</a>
            <a href="{{ route('home') }}#menu" class="text-sm text-stone-600 hover:text-amber-800 dark:text-stone-300 dark:hover:text-amber-400">Menu</a>
            <a href="{{ route('home') }}#kontak" class="text-sm text-stone-600 hover:text-amber-800 dark:text-stone-300 dark:hover:text-amber-400">Kontak</a>
        </div>

        <div class="flex items-center gap-3">
            @include('components.theme-toggle')

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn-secondary text-sm">Dashboard Admin</a>
                @else
                    <a href="{{ route('customer.cart.index') }}" class="relative text-sm text-stone-600 hover:text-amber-800 dark:text-stone-300 dark:hover:text-amber-400">
                        🛒
                        @if(($cartCount ?? 0) > 0)
                            <span class="absolute -right-2 -top-2 flex h-4 w-4 items-center justify-center rounded-full bg-amber-700 text-[10px] text-white">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('customer.products.index') }}" class="btn-primary text-sm">Pesan Sekarang</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-stone-500 hover:text-red-600 dark:text-stone-400 dark:hover:text-red-400">Keluar</button>
                </form>
            @else
                <a href="{{ route('customer.login') }}" class="text-sm font-medium text-stone-600 hover:text-amber-800 dark:text-stone-300 dark:hover:text-amber-400">Masuk</a>
                <a href="{{ route('customer.register') }}" class="btn-primary text-sm">Daftar</a>
            @endauth
        </div>
    </div>
</nav>
