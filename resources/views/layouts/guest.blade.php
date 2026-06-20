<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    @include('components.html-head')
</head>
<body class="min-h-screen bg-stone-50 font-sans text-stone-800 antialiased dark:bg-stone-900 dark:text-stone-100">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">
        <div class="absolute right-4 top-4">
            @include('components.theme-toggle')
        </div>
        <a href="{{ route('home') }}" class="mb-8 text-2xl font-bold text-amber-800 dark:text-amber-400">☕ {{ config('app.name') }}</a>
        <div class="w-full max-w-md rounded-2xl border border-amber-100 bg-white p-8 shadow-sm dark:border-stone-700 dark:bg-stone-800">
            @include('components.alert')
            @yield('content')
        </div>
    </div>
</body>
</html>
