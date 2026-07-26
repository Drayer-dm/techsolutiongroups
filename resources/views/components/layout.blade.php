<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Inicio' }}</title>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-atoms.icon.icon />
</head>
<body class="bg-slate-100 text-slate-800 font-sans min-h-screen dark:bg-slate-950 dark:text-slate-200">
    <div class="flex min-h-screen flex-col">
        <x-organism.navbar />

        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
            {{ $slot ?? '' }}
        </main>

        <x-organism.footer />
    </div>
</body>
</html>