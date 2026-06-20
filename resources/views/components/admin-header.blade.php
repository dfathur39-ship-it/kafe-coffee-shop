<header class="border-b border-amber-100 bg-white px-6 py-4 dark:border-stone-700 dark:bg-stone-900">
    <div class="flex items-center justify-between">
        <h1 class="text-lg font-semibold text-stone-800 dark:text-stone-100">@yield('header', 'Admin Panel')</h1>
        <div class="flex items-center gap-3">
            @include('components.theme-toggle')
            <span class="text-sm text-stone-500 dark:text-stone-400">{{ auth()->user()->name }}</span>
        </div>
    </div>
</header>
