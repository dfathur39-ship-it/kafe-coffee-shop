<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    @include('components.html-head')
</head>
<body class="min-h-screen bg-stone-100 font-sans text-stone-800 antialiased dark:bg-stone-950 dark:text-stone-100">
    <div class="flex min-h-screen">
        @include('components.admin-sidebar')
        <div class="flex flex-1 flex-col">
            @include('components.admin-header')
            <main class="flex-1 p-6">@yield('content')</main>
        </div>
    </div>
</body>
</html>
