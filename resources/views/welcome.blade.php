<x-guest-layout>
    <div class="relative overflow-hidden px-4 py-12 sm:px-6 lg:px-8">
        <div class="absolute inset-0 opacity-25 bg-[radial-gradient(circle_at_top_left,_rgba(34,197,94,0.28),transparent_25%),radial-gradient(circle_at_center_right,_rgba(14,165,233,0.16),transparent_20%)]"></div>
        <div class="relative mx-auto max-w-7xl">
            <div class="grid gap-12 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-400/20 bg-emerald-400/10 px-4 py-2 text-sm font-medium text-emerald-200 shadow-sm shadow-emerald-500/10">Elite Fitness Tracking</div>

                    <div class="space-y-6">
                        <h1 class="max-w-3xl text-5xl font-semibold tracking-tight text-white sm:text-6xl">Build your ideal body. Track every step.</h1>
                        <p class="max-w-2xl text-xl leading-8 text-slate-300">FitNexus gives you a premium fitness HQ with smart onboarding, powerful metrics, and a dashboard built to keep you motivated.</p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                        <a href="{{ route('login') }}" class="btn-secondary">Log In</a>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-3">
                        <div class="stat-chip">
                            <span class="text-xs uppercase tracking-[0.28em] text-slate-400">Onboarding</span>
                            <span class="text-lg font-semibold text-white">5 steps</span>
                        </div>
                        <div class="stat-chip">
                            <span class="text-xs uppercase tracking-[0.28em] text-slate-400">Macros</span>
                            <span class="text-lg font-semibold text-white">Protein, carbs, fats</span>
                        </div>
                        <div class="stat-chip">
                            <span class="text-xs uppercase tracking-[0.28em] text-slate-400">Style</span>
                            <span class="text-lg font-semibold text-white">Premium dark mode</span>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-white/10 bg-slate-950/85 p-8 shadow-[0_30px_80px_-30px_rgba(0,0,0,0.75)] backdrop-blur-xl">
                    <div class="flex flex-col gap-6">
                        <div class="rounded-[1.75rem] border border-white/10 bg-slate-900/90 p-6 shadow-[0_25px_70px_-40px_rgba(0,0,0,0.8)]">
                            <p class="text-sm uppercase tracking-[0.28em] text-emerald-400">Premium overview</p>
                            <h2 class="mt-4 text-3xl font-semibold text-white">Your fitness intelligence dashboard awaits.</h2>
                            <p class="mt-4 text-slate-400">Create a plan, calculate your metrics, and stay accountable with a dashboard designed for high-achievers.</p>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="feature-card">
                                <p class="text-sm uppercase tracking-[0.28em] text-emerald-300">Goal</p>
                                <h3 class="mt-3 text-xl font-semibold text-white">Lose fat or build muscle</h3>
                            </div>
                            <div class="feature-card">
                                <p class="text-sm uppercase tracking-[0.28em] text-sky-300">Metrics</p>
                                <h3 class="mt-3 text-xl font-semibold text-white">BMI, TDEE, macros</h3>
                            </div>
                            <div class="feature-card sm:col-span-2">
                                <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Experience</p>
                                <h3 class="mt-3 text-xl font-semibold text-white">Sleek onboarding, polished dashboard</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="mt-16 grid gap-6 lg:grid-cols-3">
                <div class="feature-card">
                    <p class="text-sm uppercase tracking-[0.28em] text-emerald-300">Personalized</p>
                    <h3 class="mt-4 text-2xl font-semibold text-white">Custom training profiles</h3>
                    <p class="mt-3 text-slate-400">Enter your body stats and goals, then let FitNexus generate a smarter plan.</p>
                </div>
                <div class="feature-card">
                    <p class="text-sm uppercase tracking-[0.28em] text-sky-300">Clarity</p>
                    <h3 class="mt-4 text-2xl font-semibold text-white">Beautiful analytics</h3>
                    <p class="mt-3 text-slate-400">Understand your fitness journey with metrics displayed in premium cards and bars.</p>
                </div>
                <div class="feature-card">
                    <p class="text-sm uppercase tracking-[0.28em] text-fuchsia-300">Accountability</p>
                    <h3 class="mt-4 text-2xl font-semibold text-white">Built for momentum</h3>
                    <p class="mt-3 text-slate-400">Every step is designed to keep you moving forward, from onboarding to daily tracking.</p>
                </div>
            </section>

            <section class="mt-16 rounded-[2rem] border border-white/10 bg-slate-950/85 p-8 shadow-[0_30px_80px_-30px_rgba(0,0,0,0.75)]">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.28em] text-slate-400">FitNexus by design</p>
                        <h2 class="mt-3 text-3xl font-semibold text-white">A premium fitness experience with every screen.</h2>
                    </div>
                    <a href="{{ route('register') }}" class="btn-primary">Create your profile</a>
                </div>
                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl border border-white/10 bg-slate-900/90 p-6">
                        <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Fast setup</p>
                        <p class="mt-3 text-white">Complete onboarding in five simple steps.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-slate-900/90 p-6">
                        <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Insightful</p>
                        <p class="mt-3 text-white">Get immediately useful fitness metrics and recommendations.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-slate-900/90 p-6">
                        <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Modern UI</p>
                        <p class="mt-3 text-white">A premium interface designed for high-energy athletes.</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-guest-layout>
