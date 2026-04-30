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
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-100 bg-[#050814]">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(34,197,94,0.08),_transparent_35%),linear-gradient(180deg,#040711_0%,#02040a_100%)] text-slate-100">
            @include('layouts.navigation')

            <main class="px-4 py-8 sm:px-6 lg:px-10 xl:px-12">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
