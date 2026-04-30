<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/95 backdrop-blur-xl shadow-[0_10px_60px_-35px_rgba(0,0,0,0.75)]">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-lg font-semibold tracking-tight text-white">
                <div class="flex h-11 w-11 items-center justify-center rounded-3xl bg-gradient-to-br from-emerald-400 to-teal-500 text-slate-950 shadow-lg shadow-emerald-500/20">
                    FN
                </div>
                <span class="text-white">FitNexus</span>
            </a>

            <div class="hidden items-center gap-1 text-sm text-slate-300 sm:flex">
                <a href="{{ route('dashboard') }}" class="transition hover:text-white {{ request()->routeIs('dashboard') ? 'text-white font-semibold' : 'text-slate-400' }}">Dashboard</a>
                <span class="text-slate-600">·</span>
                <a href="{{ route('onboarding') }}" class="transition hover:text-white {{ request()->routeIs('onboarding') ? 'text-white font-semibold' : 'text-slate-400' }}">Onboarding</a>
            </div>
        </div>

        <div class="hidden items-center gap-3 sm:flex">
            <a href="{{ route('profile.edit') }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-slate-100 transition hover:border-emerald-400/30 hover:bg-emerald-400/10">Profile</a>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="rounded-full bg-emerald-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">Log Out</button>
            </form>
        </div>

        <button @click="open = !open" class="inline-flex items-center justify-center rounded-full border border-white/10 bg-slate-900/80 p-2 text-slate-300 transition hover:text-white hover:border-emerald-400/30 sm:hidden">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div :class="{'block': open, 'hidden': !open}" class="hidden border-t border-white/10 bg-slate-950/95 sm:hidden">
        <div class="space-y-1 px-4 py-4">
            <a href="{{ route('dashboard') }}" class="block rounded-2xl px-4 py-3 text-sm {{ request()->routeIs('dashboard') ? 'bg-emerald-500/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">Dashboard</a>
            <a href="{{ route('onboarding') }}" class="block rounded-2xl px-4 py-3 text-sm {{ request()->routeIs('onboarding') ? 'bg-emerald-500/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">Onboarding</a>
            <a href="{{ route('profile.edit') }}" class="block rounded-2xl px-4 py-3 text-sm text-slate-300 hover:bg-white/5 hover:text-white">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-2xl bg-emerald-400 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">Log Out</button>
            </form>
        </div>
    </div>
</nav>
