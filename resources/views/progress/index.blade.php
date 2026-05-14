<x-app-layout>
    <div class="grid gap-8 lg:grid-cols-[1fr_320px]">
        <div class="space-y-8">
            <div class="rounded-[2rem] border border-white/10 bg-slate-950/85 p-8 shadow-2xl shadow-black/20 backdrop-blur-xl">
                <p class="text-sm uppercase tracking-[0.28em] text-emerald-400">Progress tracker</p>
                <h1 class="mt-4 text-4xl font-semibold text-white">Your recent training momentum</h1>
                <p class="mt-4 text-slate-400">Track your weight, body fat %, and streak over time.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="rounded-[2rem] border border-white/10 bg-slate-950/85 p-8 shadow-xl shadow-black/20">
                    <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Completed workouts</p>
                    <p class="mt-5 text-4xl font-semibold text-white">{{ $totalCompleted }}</p>
                </div>
                <div class="rounded-[2rem] border border-white/10 bg-slate-950/85 p-8 shadow-xl shadow-black/20">
                    <p class="text-sm uppercase tracking-[0.28em] text-slate-400">Current streak</p>
                    <p class="mt-5 text-4xl font-semibold text-white">{{ $currentStreak }} days</p>
                </div>
            </div>

            <!-- React Premium Analytics Graph Mount Point -->
            <div id="analytics-graph-root"></div>

            <!-- React Anatomy Heatmap Mount Point -->
            <div id="anatomy-heatmap-root" class="mt-8"></div>
            
            <!-- React Weekly Analytics Mount Point -->
            <div id="weekly-analytics-root" class="mt-8"></div>
        </div>
    </div>
</x-app-layout>
