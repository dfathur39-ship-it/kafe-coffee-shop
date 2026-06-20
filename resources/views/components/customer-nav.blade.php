<nav class="mb-6 flex flex-wrap items-center gap-2 border-b border-amber-100 pb-4 dark:border-stone-700">
    <a href="{{ route('customer.products.index') }}" class="{{ request()->routeIs('customer.products.*') ? 'bg-amber-700 text-white dark:bg-amber-600' : 'bg-white text-stone-600 hover:bg-amber-50 dark:bg-stone-800 dark:text-stone-300 dark:hover:bg-stone-700' }} rounded-lg px-4 py-2 text-sm font-medium">Menu</a>
    <a href="{{ route('customer.cart.index') }}" class="{{ request()->routeIs('customer.cart.*') ? 'bg-amber-700 text-white dark:bg-amber-600' : 'bg-white text-stone-600 hover:bg-amber-50 dark:bg-stone-800 dark:text-stone-300 dark:hover:bg-stone-700' }} relative rounded-lg px-4 py-2 text-sm font-medium">
        Keranjang
        @if(($cartCount ?? 0) > 0)
            <span class="ml-1 rounded-full bg-amber-600 px-1.5 text-xs text-white">{{ $cartCount }}</span>
        @endif
    </a>
    <a href="{{ route('customer.orders.index') }}" class="{{ request()->routeIs('customer.orders.*') ? 'bg-amber-700 text-white dark:bg-amber-600' : 'bg-white text-stone-600 hover:bg-amber-50 dark:bg-stone-800 dark:text-stone-300 dark:hover:bg-stone-700' }} rounded-lg px-4 py-2 text-sm font-medium">Pesanan</a>
    <a href="{{ route('customer.profile.edit') }}" class="{{ request()->routeIs('customer.profile.*') ? 'bg-amber-700 text-white dark:bg-amber-600' : 'bg-white text-stone-600 hover:bg-amber-50 dark:bg-stone-800 dark:text-stone-300 dark:hover:bg-stone-700' }} rounded-lg px-4 py-2 text-sm font-medium">Profil</a>
    <div class="ml-auto flex items-center gap-2">
        @include('components.theme-toggle')
        <a href="{{ route('home') }}" class="rounded-lg px-4 py-2 text-sm text-stone-500 hover:text-amber-800 dark:text-stone-400 dark:hover:text-amber-400">← Beranda</a>
    </div>
</nav>
