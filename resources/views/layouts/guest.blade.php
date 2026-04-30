<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FitNexus') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-100 antialiased bg-[#02040a]">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.16),transparent_20%),radial-gradient(circle_at_bottom_right,_rgba(14,165,233,0.1),transparent_20%),#02040a]">
            <div class="absolute inset-x-0 top-0 h-40 bg-[radial-gradient(circle,_rgba(34,197,94,0.18),transparent_40%)]"></div>
            <div class="relative min-h-screen flex flex-col items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_rgba(15,23,42,0.85),transparent_65%)]"></div>
                <div class="relative w-full max-w-7xl">
                    <header class="mb-8 flex items-center justify-between px-4 sm:px-0">
                        <a href="/" class="inline-flex items-center gap-3">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-gradient-to-br from-emerald-400 to-cyan-400 text-slate-950 text-lg font-bold shadow-lg shadow-emerald-500/20">FN</span>
                            <span class="text-xl font-semibold tracking-tight text-white">FitNexus</span>
                        </a>
                        <div class="hidden gap-4 text-sm text-slate-300 sm:flex">
                            <a href="{{ route('login') }}" class="transition hover:text-white">Log In</a>
                            <a href="{{ route('register') }}" class="btn-secondary">Get Started</a>
                        </div>
                    </header>

                    <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-slate-950/90 shadow-[0_35px_120px_-40px_rgba(0,0,0,0.7)] backdrop-blur-xl">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
