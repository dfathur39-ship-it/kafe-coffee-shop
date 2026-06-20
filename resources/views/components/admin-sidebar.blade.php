@php
    $links = [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => '📊'],
        ['route' => 'admin.menu.create', 'label' => 'Tambah Menu', 'icon' => '➕'],
        ['route' => 'admin.products.index', 'label' => 'Daftar Menu', 'icon' => '☕'],
        ['route' => 'admin.orders.index', 'label' => 'Pesanan', 'icon' => '📋'],
        ['route' => 'admin.users.index', 'label' => 'Pelanggan', 'icon' => '👥'],
    ];
@endphp
<aside class="flex hidden w-64 flex-shrink-0 flex-col border-r border-amber-100 bg-white dark:border-stone-700 dark:bg-stone-900 md:flex">
    <div class="border-b border-amber-100 px-6 py-5 dark:border-stone-700">
        <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold text-amber-800 dark:text-amber-400">☕ Admin Panel</a>
    </div>
    <nav class="flex-1 space-y-1 p-4">
        @foreach($links as $link)
            <a href="{{ route($link['route']) }}"
               class="{{ request()->routeIs(str_replace('.index', '.*', $link['route'])) || request()->routeIs($link['route']) ? 'bg-amber-50 text-amber-900 dark:bg-stone-800 dark:text-amber-300' : 'text-stone-600 hover:bg-stone-50 dark:text-stone-300 dark:hover:bg-stone-800' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium">
                <span>{{ $link['icon'] }}</span> {{ $link['label'] }}
            </a>
        @endforeach
    </nav>
    <div class="border-t border-amber-100 p-4 dark:border-stone-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20">Keluar</button>
        </form>
    </div>
</aside>
