<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    @include('components.html-head')
</head>
<body class="min-h-screen bg-stone-50 font-sans text-stone-800 antialiased dark:bg-stone-900 dark:text-stone-100">
    @include('components.navbar')
    <main>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @include('components.alert')
        </div>
        @yield('content')
    </main>
    @include('components.footer')
</body>
</html>
