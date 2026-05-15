<x-app-layout>
    <div class="w-full max-w-[1600px] mx-auto px-4 lg:px-8 py-10">
        <!-- Top Navigation & Profile Status -->
        <div class="flex justify-between items-center mb-16">
            <div>
                <h1 class="text-[10px] uppercase tracking-[0.5em] text-white/40 mb-2">Nutritional Sync Command</h1>
                <h2 class="text-4xl font-light tracking-tight text-white/90">
                    Fueling <span class="font-bold text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.5)]">Your Orbit</span>
                </h2>
            </div>
            
            <div class="hidden md:flex items-center gap-6">
                <div class="px-6 py-3 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_10px_#00F2FF]"></div>
                    <span class="text-[10px] font-black text-white/60 uppercase tracking-widest">Metabolic Status: Syncing</span>
                </div>
            </div>
        </div>

        <!-- Livewire Food Logger Component -->
        <livewire:quick-add-food />
    </div>
</x-app-layout>
