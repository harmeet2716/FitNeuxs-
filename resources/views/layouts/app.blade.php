<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#0f172a" />

        <title>{{ config('app.name', 'FitNexus') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700|syncopate:400,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-100 bg-[#0A0A0B]">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(0,242,255,0.05),_transparent_40%),linear-gradient(180deg,#0A0A0B_0%,#050505_100%)] text-slate-100 flex">
            <!-- React Sidebar Navigation Mount Point -->
            <div id="sidebar-navigation-root" data-path="{{ request()->path() }}"></div>

            <!-- Main Content (padded to account for floating sidebar) -->
            <main class="flex-1 px-4 py-8 sm:px-6 lg:px-10 xl:px-12 lg:ml-28 w-full max-w-[100vw] overflow-x-hidden">
                {{ $slot }}
            </main>

            <!-- Bottom Navigation Mount Point -->
            <div id="bottom-navigation-root" data-path="{{ request()->path() }}"></div>
        </div>
    </body>
</html>
