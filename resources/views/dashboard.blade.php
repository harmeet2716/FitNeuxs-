<x-app-layout>
    <div class="grid gap-8 lg:grid-cols-[320px_minmax(0,1fr)]">
        <aside class="space-y-6 rounded-[2rem] border border-white/10 bg-slate-950/85 p-6 shadow-2xl shadow-black/20 backdrop-blur-xl">
            <div class="rounded-[1.75rem] border border-white/10 bg-slate-900/90 p-6">
                <p class="text-sm uppercase tracking-[0.28em] text-emerald-400">Welcome back</p>
                <h2 class="mt-3 text-3xl font-semibold text-white">{{ auth()->user()->name }}</h2>
                <p class="mt-4 text-sm leading-6 text-slate-400">Your fitness profile is live. Keep building momentum with weekly progress and smart metrics.</p>
            </div>

            <div class="rounded-[1.75rem] border border-white/10 bg-slate-900/90 p-6">
                <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Quick actions</p>
                <div class="mt-5 grid gap-3">
                    <a href="{{ route('onboarding') }}" class="inline-flex items-center justify-center rounded-full border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold text-white transition hover:border-emerald-400/30 hover:bg-emerald-400/10">Edit profile</a>
                    <a href="#metrics" class="inline-flex items-center justify-center rounded-full border border-white/10 bg-emerald-400/10 px-4 py-3 text-sm font-semibold text-emerald-300 transition hover:bg-emerald-400/15">View metrics</a>
                </div>
            </div>

            <div class="rounded-[1.75rem] border border-white/10 bg-slate-900/90 p-6">
                <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Profile summary</p>
                <ul class="mt-5 space-y-4 text-sm text-slate-300">
                    <li><span class="font-semibold text-white">Goal:</span> {{ $profile->goal_label }}</li>
                    <li><span class="font-semibold text-white">Activity:</span> {{ ucfirst($profile->activity_level) }}</li>
                    <li><span class="font-semibold text-white">Days / week:</span> {{ $profile->days_per_week }}</li>
                    <li><span class="font-semibold text-white">Motivation:</span> {{ $profile->motivation }}</li>
                </ul>
            </div>
        </aside>

        <div class="space-y-8">
            <section class="rounded-[2rem] border border-white/10 bg-slate-950/85 p-8 shadow-2xl shadow-black/20 backdrop-blur-xl">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.28em] text-emerald-400">Dashboard</p>
                        <h1 class="mt-3 text-4xl font-semibold text-white">Your FitNexus HQ</h1>
                        <p class="mt-4 max-w-2xl text-slate-400">Insightful analytics, macros, and body stats all in one premium dashboard.</p>
                    </div>
                    <div class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-200">
                        <span class="mr-2 h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                        Active profile
                    </div>
                </div>
            </section>

            <section id="metrics" class="grid gap-6 lg:grid-cols-3">
                <div class="metric-card">
                    <p class="text-sm uppercase tracking-[0.28em] text-slate-400">BMI</p>
                    <p class="mt-4 text-4xl font-semibold text-white">{{ $profile->bmi }}</p>
                    <p class="mt-2 text-sm text-slate-300">{{ $profile->bmi_category }}</p>
                </div>
                <div class="metric-card">
                    <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Body Fat</p>
                    <p class="mt-4 text-4xl font-semibold text-white">{{ $profile->body_fat_percent }}%</p>
                    <p class="mt-2 text-sm text-slate-300">{{ $profile->body_fat_category }}</p>
                </div>
                <div class="metric-card">
                    <p class="text-sm uppercase tracking-[0.28em] text-slate-400">TDEE</p>
                    <p class="mt-4 text-4xl font-semibold text-white">{{ $profile->tdee }} kcal</p>
                    <p class="mt-2 text-sm text-slate-300">Daily energy target</p>
                </div>
            </section>

            <section class="rounded-[2rem] border border-white/10 bg-slate-950/85 p-8 shadow-2xl shadow-black/20 backdrop-blur-xl">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Macro breakdown</p>
                        <h2 class="mt-3 text-3xl font-semibold text-white">Fuel your goals</h2>
                    </div>
                    <p class="text-sm text-slate-400">Target calories: <span class="font-semibold text-white">{{ $profile->target_calories }} kcal</span></p>
                </div>

                @php
                    $totalMacros = max(1, $profile->protein_g + $profile->carbs_g + $profile->fats_g);
                    $proteinPct = round($profile->protein_g / $totalMacros * 100);
                    $carbsPct = round($profile->carbs_g / $totalMacros * 100);
                    $fatsPct = round($profile->fats_g / $totalMacros * 100);
                @endphp

                <div class="mt-8 space-y-5">
                    <div>
                        <div class="flex items-center justify-between text-sm text-slate-400">
                            <span>Protein</span>
                            <span class="font-semibold text-white">{{ $profile->protein_g }}g • {{ $proteinPct }}%</span>
                        </div>
                        <div class="progress-track mt-3">
                            <div class="progress-fill bg-emerald-400" style="width: {{ $proteinPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-sm text-slate-400">
                            <span>Carbs</span>
                            <span class="font-semibold text-white">{{ $profile->carbs_g }}g • {{ $carbsPct }}%</span>
                        </div>
                        <div class="progress-track mt-3">
                            <div class="progress-fill bg-sky-400" style="width: {{ $carbsPct }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-sm text-slate-400">
                            <span>Fats</span>
                            <span class="font-semibold text-white">{{ $profile->fats_g }}g • {{ $fatsPct }}%</span>
                        </div>
                        <div class="progress-track mt-3">
                            <div class="progress-fill bg-fuchsia-400" style="width: {{ $fatsPct }}%"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-[2rem] border border-white/10 bg-slate-950/85 p-8 shadow-2xl shadow-black/20 backdrop-blur-xl">
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-4">
                        <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Body stats</p>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-5">
                                <p class="text-sm text-slate-400">Weight</p>
                                <p class="mt-3 text-2xl font-semibold text-white">{{ $profile->weight_kg }} kg</p>
                            </div>
                            <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-5">
                                <p class="text-sm text-slate-400">Height</p>
                                <p class="mt-3 text-2xl font-semibold text-white">{{ $profile->height_cm }} cm</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Lifestyle</p>
                        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-5">
                            <p class="text-sm text-slate-400">Workout rhythm</p>
                            <p class="mt-3 text-2xl font-semibold text-white">{{ ucfirst($profile->activity_level) }}</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-5">
                            <p class="text-sm text-slate-400">Motivation</p>
                            <p class="mt-3 text-lg font-semibold text-white">{{ $profile->motivation }}</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
