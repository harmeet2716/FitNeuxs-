<div class="space-y-12 animate-float" style="animation-delay: 0.5s">
    <!-- THE VITALITY ORBIT (Header Section) -->
    <div class="flex flex-col lg:flex-row items-center justify-between gap-12 bg-white/5 backdrop-blur-2xl rounded-[4rem] p-12 border border-white/10 shadow-[0_0_50px_rgba(0,0,0,0.6)]">
        
        <!-- Primary Ring (Total Calories) -->
        <div class="relative w-64 h-64 flex items-center justify-center">
            <svg class="w-full h-full -rotate-90 transform" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="6" fill="transparent" class="text-white/5" />
                <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="6" fill="transparent"
                    class="text-cyan-400"
                    stroke-dasharray="282.7"
                    stroke-dashoffset="{{ 282.7 - (min(100, ($consumedCalories / max(1, $targetCalories)) * 100) / 100) * 282.7 }}"
                    stroke-linecap="round"
                    style="filter: drop-shadow(0 0 12px rgba(0, 242, 255, 0.8)); transition: stroke-dashoffset 1.5s cubic-bezier(0.4, 0, 0.2, 1);"
                />
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                <span class="text-[10px] font-black text-cyan-400 uppercase tracking-[0.4em] mb-1">Remaining</span>
                <span class="text-5xl font-black text-white tracking-tighter drop-shadow-lg">{{ number_format($caloriesRemaining) }}</span>
                <span class="text-[8px] font-bold text-white/30 uppercase tracking-widest mt-1">Kcal Orbit</span>
            </div>
        </div>

        <!-- Satellite Rings (Macros) -->
        <div class="flex flex-wrap justify-center gap-10">
            <!-- Protein -->
            <div class="flex flex-col items-center gap-4">
                <div class="relative w-24 h-24 flex items-center justify-center">
                    <svg class="w-full h-full -rotate-90 transform" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="42" stroke="currentColor" stroke-width="6" fill="transparent" class="text-white/5" />
                        <circle cx="50" cy="50" r="42" stroke="currentColor" stroke-width="6" fill="transparent"
                            class="text-violet-500"
                            stroke-dasharray="263.9"
                            stroke-dashoffset="{{ 263.9 - (min(100, ($consumedProtein / max(1, $targetProtein)) * 100) / 100) * 263.9 }}"
                            stroke-linecap="round"
                            style="filter: drop-shadow(0 0 8px rgba(139, 92, 246, 0.6)); transition: stroke-dashoffset 1.2s ease-out;"
                        />
                    </svg>
                    <span class="absolute text-xs font-black text-white">{{ round(($consumedProtein / max(1, $targetProtein)) * 100) }}%</span>
                </div>
                <span class="text-[10px] font-black text-violet-400 uppercase tracking-widest">Protein</span>
            </div>

            <!-- Carbs -->
            <div class="flex flex-col items-center gap-4">
                <div class="relative w-24 h-24 flex items-center justify-center">
                    <svg class="w-full h-full -rotate-90 transform" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="42" stroke="currentColor" stroke-width="6" fill="transparent" class="text-white/5" />
                        <circle cx="50" cy="50" r="42" stroke="currentColor" stroke-width="6" fill="transparent"
                            class="text-blue-500"
                            stroke-dasharray="263.9"
                            stroke-dashoffset="{{ 263.9 - (min(100, ($consumedCarbs / max(1, $targetCarbs)) * 100) / 100) * 263.9 }}"
                            stroke-linecap="round"
                            style="filter: drop-shadow(0 0 8px rgba(59, 130, 246, 0.6)); transition: stroke-dashoffset 1.2s ease-out;"
                        />
                    </svg>
                    <span class="absolute text-xs font-black text-white">{{ round(($consumedCarbs / max(1, $targetCarbs)) * 100) }}%</span>
                </div>
                <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Carbs</span>
            </div>

            <!-- Fats -->
            <div class="flex flex-col items-center gap-4">
                <div class="relative w-24 h-24 flex items-center justify-center">
                    <svg class="w-full h-full -rotate-90 transform" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="42" stroke="currentColor" stroke-width="6" fill="transparent" class="text-white/5" />
                        <circle cx="50" cy="50" r="42" stroke="currentColor" stroke-width="6" fill="transparent"
                            class="text-yellow-500"
                            stroke-dasharray="263.9"
                            stroke-dashoffset="{{ 263.9 - (min(100, ($consumedFats / max(1, $targetFats)) * 100) / 100) * 263.9 }}"
                            stroke-linecap="round"
                            style="filter: drop-shadow(0 0 8px rgba(234, 179, 8, 0.6)); transition: stroke-dashoffset 1.2s ease-out;"
                        />
                    </svg>
                    <span class="absolute text-xs font-black text-white">{{ round(($consumedFats / max(1, $targetFats)) * 100) }}%</span>
                </div>
                <span class="text-[10px] font-black text-yellow-400 uppercase tracking-widest">Fats</span>
            </div>
        </div>
    </div>

    <!-- THE SEARCH INTERFACE -->
    <div class="relative max-w-4xl mx-auto z-40">
        <div class="relative group">
            <div class="absolute inset-0 bg-cyan-400/5 blur-xl rounded-full opacity-0 group-focus-within:opacity-100 transition-opacity"></div>
            <div class="relative flex items-center bg-white/5 backdrop-blur-3xl border-b-2 border-white/10 group-focus-within:border-cyan-400 transition-all px-8 py-6 rounded-t-3xl shadow-2xl">
                <div class="mr-6">
                    <svg wire:loading.remove wire:target="foodName" class="w-6 h-6 text-white/30 group-focus-within:text-cyan-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <svg wire:loading wire:target="foodName" class="w-6 h-6 text-cyan-400 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
                
                <input 
                    type="text" 
                    wire:model.live.debounce.500ms="foodName" 
                    class="w-full bg-transparent border-none text-2xl font-light text-white placeholder-white/10 focus:ring-0 focus:outline-none tracking-tight"
                    placeholder="Identify Fuel Source (e.g., Paneer)..."
                >
            </div>

            @if($showDropdown)
                <div class="absolute top-full left-0 w-full bg-black/95 backdrop-blur-3xl border border-white/10 rounded-b-3xl overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.8)] z-[100] animate-in fade-in slide-in-from-top-4 duration-300">
                    @foreach($searchResults as $result)
                        <button 
                            wire:key="result-{{ $result['fdcId'] }}"
                            wire:click="selectFood('{{ $result['fdcId'] }}')"
                            class="w-full px-8 py-5 flex items-center justify-between hover:bg-cyan-400/10 transition-colors border-b border-white/5 last:border-none group text-left"
                        >
                            <div>
                                <span class="block text-white font-bold tracking-wide group-hover:text-cyan-400 transition-colors">{{ $result['name'] }}</span>
                                <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mt-1">Bio-Analyzed Payload @if($result['brand']) | {{ $result['brand'] }} @endif</span>
                            </div>
                            <div class="flex items-center gap-6">
                                <span class="text-lg font-black text-white/80 tracking-tighter">{{ $result['kcal'] }} Kcal</span>
                                <div class="h-8 w-[1px] bg-white/10"></div>
                                <div class="flex gap-3 text-[10px] font-bold uppercase text-white/40">
                                    <span class="text-violet-400">P:{{ $result['p'] }}g</span>
                                    <span class="text-blue-400">C:{{ $result['c'] }}g</span>
                                    <span class="text-yellow-400">F:{{ $result['f'] }}g</span>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="flex flex-wrap justify-center gap-4 mt-8">
            @foreach(['Morning', 'Lunch', 'Snacks', 'Dinner'] as $type)
                <button 
                    wire:click="setMealType('{{ $type }}')"
                    class="px-8 py-3 rounded-full border transition-all duration-500 text-[10px] font-black uppercase tracking-[0.3em] shadow-lg active:scale-95
                    {{ $currentMealType === $type 
                        ? 'bg-cyan-400/20 border-cyan-400 text-cyan-400 shadow-[0_0_15px_rgba(0,242,255,0.4)]' 
                        : 'bg-white/5 border-white/10 text-white/40 hover:bg-white/10 hover:text-white' }}"
                >
                    {{ $type }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- THE METABOLIC FEED -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        @foreach(['Morning', 'Lunch', 'Snacks', 'Dinner'] as $cat)
            <div class="bg-white/5 backdrop-blur-xl rounded-[3rem] p-8 border border-white/10 shadow-2xl min-h-[300px] flex flex-col">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xs uppercase tracking-[0.4em] font-black text-white/40">{{ $cat }} Fueling</h3>
                    @php
                        $catMeals = collect($meals)->where('meal_type', $cat);
                        $catCals = $catMeals->sum('calories');
                    @endphp
                    <span class="text-[10px] font-black text-cyan-400 uppercase tracking-widest">{{ number_format($catCals) }} Kcal</span>
                </div>

                <div class="space-y-4 flex-1">
                    @forelse($catMeals as $meal)
                        <div wire:key="meal-{{ $meal['id'] ?? $loop->index }}" class="group relative bg-white/5 backdrop-blur-md border border-white/5 rounded-[2.5rem] p-6 flex items-center justify-between hover:bg-white/10 hover:border-cyan-400/30 transition-all duration-500 shadow-xl overflow-hidden animate-in fade-in zoom-in-95 duration-500">
                            <div class="absolute top-0 left-0 w-1 h-full bg-cyan-400 shadow-[0_0_10px_#00F2FF]"></div>
                            
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-cyan-400/10 flex items-center justify-center text-cyan-400 border border-cyan-400/20 shadow-[0_0_15px_rgba(0,242,255,0.1)]">
                                    <span class="font-black text-sm">{{ strtoupper(substr($meal['name'], 0, 1)) }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="text-white font-bold tracking-widest uppercase text-[10px] mb-1 truncate max-w-[120px]">{{ $meal['name'] }}</h4>
                                    <div class="flex items-center gap-3 text-[8px] font-black uppercase tracking-widest text-white/30">
                                        <span class="px-2 py-0.5 bg-white/5 rounded text-cyan-400/60">{{ $meal['quantity'] ?? '100' }}{{ $meal['unit'] ?? 'g' }}</span>
                                        <span class="text-violet-400">P:{{ round($meal['protein']) }}</span>
                                        <span class="text-blue-400">C:{{ round($meal['carbs']) }}</span>
                                        <span class="text-yellow-400">F:{{ round($meal['fats']) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-6">
                                <div class="text-right">
                                    <span class="text-2xl font-black text-white tracking-tighter drop-shadow-[0_0_8px_rgba(0,242,255,0.3)]">{{ round($meal['calories']) }}</span>
                                    <span class="block text-[8px] font-black text-white/20 uppercase tracking-widest">Kcal</span>
                                </div>
                                <button wire:click="deleteFood('{{ $meal['id'] }}')" class="p-3 rounded-full bg-red-500/5 border border-red-500/10 text-red-500/30 hover:bg-red-500/20 hover:text-red-500 transition-all active:scale-90 shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-40 text-white/5 border border-dashed border-white/5 rounded-[2rem]">
                            <p class="text-[8px] uppercase tracking-[0.5em] font-black">Waiting for Data Injection</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>

    <!-- THE BIO-ANALYZER CALIBRATION MODAL -->
    @if($showCalibrationModal)
        <div class="fixed inset-0 z-[200] flex items-center justify-center p-6 animate-in fade-in duration-300">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-3xl" wire:click="$set('showCalibrationModal', false)"></div>
            
            <div class="relative w-full max-w-xl bg-white/10 backdrop-blur-2xl rounded-[3rem] border border-white/20 p-10 shadow-[0_0_100px_rgba(0,0,0,0.8)] overflow-hidden">
                <!-- Neon Accents -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent shadow-[0_0_20px_#00F2FF]"></div>
                
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <h2 class="text-2xl font-black text-white tracking-tighter uppercase mb-2">{{ $foodName }}</h2>
                        <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.4em]">Calibrating Metabolic Payload</p>
                    </div>
                    <button wire:click="$set('showCalibrationModal', false)" class="p-3 bg-white/5 rounded-full hover:bg-white/10 text-white/40 hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    <!-- Amount Input -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-cyan-400 uppercase tracking-[0.3em] px-4">Quantity</label>
                        <div class="relative group">
                            <input 
                                type="number" 
                                wire:model.live="amount"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-6 px-8 text-4xl font-black text-white focus:ring-4 focus:ring-cyan-400/20 focus:border-cyan-400 transition-all outline-none"
                            >
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-white/20 font-black uppercase text-xs">{{ $unit }}</div>
                        </div>
                    </div>

                    <!-- Unit Selection -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-white/30 uppercase tracking-[0.3em] px-4">Metric Unit</label>
                        <select 
                            wire:model.live="unit"
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-6 px-8 text-xl font-bold text-white appearance-none focus:ring-4 focus:ring-white/10 focus:border-white/30 transition-all outline-none cursor-pointer"
                        >
                            <option value="g" class="bg-black text-white">Grams (g)</option>
                            <option value="ml" class="bg-black text-white">Milliliters (ml)</option>
                            <option value="oz" class="bg-black text-white">Ounces (oz)</option>
                            <option value="servings" class="bg-black text-white">Servings</option>
                        </select>
                    </div>
                </div>

                <!-- LIVE PREVIEW HUD -->
                <div class="bg-black/40 rounded-3xl p-8 border border-white/5 mb-10">
                    <div class="flex justify-between items-end mb-6 border-b border-white/5 pb-4">
                        <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Total Energy Projection</span>
                        <div class="text-right">
                            <span class="text-5xl font-black text-white tracking-tighter shadow-[0_0_15px_rgba(255,255,255,0.2)]">{{ round($calories) }}</span>
                            <span class="text-xs font-black text-cyan-400 uppercase ml-2">Kcal</span>
                        </div>
                    </div>
                    <div class="flex justify-between gap-4">
                        <div class="flex-1 text-center py-4 bg-white/5 rounded-2xl">
                            <span class="block text-[8px] font-black text-violet-400 uppercase tracking-widest mb-1">Protein</span>
                            <span class="text-xl font-black text-white">{{ round($protein, 1) }}g</span>
                        </div>
                        <div class="flex-1 text-center py-4 bg-white/5 rounded-2xl">
                            <span class="block text-[8px] font-black text-blue-400 uppercase tracking-widest mb-1">Carbs</span>
                            <span class="text-xl font-black text-white">{{ round($carbs, 1) }}g</span>
                        </div>
                        <div class="flex-1 text-center py-4 bg-white/5 rounded-2xl">
                            <span class="block text-[8px] font-black text-yellow-400 uppercase tracking-widest mb-1">Fats</span>
                            <span class="text-xl font-black text-white">{{ round($fats, 1) }}g</span>
                        </div>
                    </div>
                </div>

                <button 
                    wire:click="saveFood"
                    class="w-full py-6 bg-cyan-400 hover:bg-cyan-300 text-black rounded-3xl font-black text-xs uppercase tracking-[0.6em] transition-all duration-500 shadow-[0_0_30px_rgba(0,242,255,0.4)] active:scale-95"
                >
                    Sync Metabolic Payload
                </button>
            </div>
        </div>
    @endif
</div>
