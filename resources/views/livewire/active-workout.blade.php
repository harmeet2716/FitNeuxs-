<div class="space-y-12 pb-32">
    @if(!$isSessionActive)
        <!-- PLANNING STATE: THE LAUNCH DECK -->
        <div class="max-w-6xl mx-auto space-y-16 animate-in fade-in slide-in-from-top-12 duration-1000">
            <div class="text-center space-y-4">
                <h1 class="text-6xl font-black text-white tracking-[0.2em] uppercase font-syncopate">The Strength Vault</h1>
                <p class="text-cyan-400 font-black text-xs uppercase tracking-[0.8em] animate-pulse">Neural Interface: Ready for Sequence</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($modalities as $modality)
                    <div class="group relative bg-white/5 backdrop-blur-3xl rounded-[3rem] p-10 border border-white/10 hover:border-{{ $modality['color'] }}-400/40 transition-all duration-700 hover:-translate-y-4 shadow-2xl overflow-hidden">
                        <!-- Holographic Glow Background -->
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-{{ $modality['color'] }}-400/10 blur-[80px] group-hover:bg-{{ $modality['color'] }}-400/20 transition-all duration-700"></div>
                        
                        <div class="relative z-10 flex flex-col h-full">
                            <div class="w-16 h-16 rounded-2xl bg-{{ $modality['color'] }}-400/10 border border-{{ $modality['color'] }}-400/20 flex items-center justify-center text-{{ $modality['color'] }}-400 mb-8 group-hover:shadow-[0_0_30px_rgba(0,242,255,0.2)] transition-all">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            
                            <h3 class="text-2xl font-black text-white uppercase tracking-tighter mb-4 group-hover:text-{{ $modality['color'] }}-400 transition-colors">{{ $modality['name'] }}</h3>
                            <p class="text-xs text-white/40 leading-relaxed mb-10 tracking-wide">Initiate high-intensity neural load for {{ strtolower($modality['name']) }} optimization.</p>
                            
                            <button 
                                wire:click="launchSession('{{ $modality['name'] }}')"
                                class="mt-auto py-5 bg-white/5 hover:bg-{{ $modality['color'] }}-400 text-white hover:text-black rounded-2xl font-black text-[10px] uppercase tracking-[0.5em] transition-all duration-500 border border-white/10 hover:border-{{ $modality['color'] }}-400 active:scale-95 group-hover:shadow-[0_0_40px_rgba(0,242,255,0.2)]"
                            >
                                Launch Session
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- ACTIVE SESSION HUD WITH INTELLIGENCE PANEL -->
        <div 
            class="max-w-[1400px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10 animate-in fade-in zoom-in-95 duration-700" 
            x-data="Object.assign(restTimer(), { pulsing: false, finishing: false })"
            @pulse-intelligence.window="pulsing = true; setTimeout(() => pulsing = false, 1000)"
        >
            
            <!-- LEFT COLUMN: ACTIVE LOGGER -->
            <div class="{{ $activeExercise ? 'lg:col-span-8' : 'lg:col-span-12' }} space-y-12 transition-all duration-700">
                
                <!-- HEADER HUD -->
                <div class="flex flex-col md:flex-row items-center justify-between bg-white/5 backdrop-blur-3xl rounded-[4rem] p-12 border border-white/10 shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-cyan-400 to-transparent opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="flex items-center gap-10 mb-8 md:mb-0">
                        <div class="w-24 h-24 rounded-[2.5rem] bg-cyan-400/10 flex items-center justify-center text-cyan-400 border border-cyan-400/20 shadow-[0_0_30px_rgba(0,242,255,0.2)] float-animation">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-4xl font-black text-white tracking-tighter uppercase mb-2 font-syncopate">{{ $trainingType }}</h2>
                            <div class="flex items-center gap-4">
                                <span class="text-[10px] font-black text-white/40 uppercase tracking-[0.5em]">Metabolic Output</span>
                                <div class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_12px_#00F2FF]"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-16 text-center">
                        <div>
                            <span class="block text-[10px] font-black text-white/20 uppercase tracking-widest mb-2">Total Volume</span>
                            <span class="text-5xl font-black text-white tracking-tighter neon-text">{{ number_format($totalVolume) }}</span>
                            <span class="text-[10px] font-bold text-cyan-400 ml-1">KG</span>
                        </div>
                        <div class="h-20 w-[1px] bg-white/10 hidden md:block"></div>
                        <div>
                            <span class="block text-[10px] font-black text-white/20 uppercase tracking-widest mb-2">Duration</span>
                            <span class="text-5xl font-black text-white tracking-tighter font-mono" x-text="formatTime(elapsed)">00:00</span>
                        </div>
                    </div>
                </div>

                <!-- EXERCISE LIST -->
                <div class="space-y-12">
                    @foreach($exercises as $exIdx => $exercise)
                        <div wire:key="exercise-{{ $exIdx }}" 
                             class="bg-white/5 backdrop-blur-2xl rounded-[3.5rem] p-12 border {{ ($activeExercise && $activeExercise['name'] === $exercise['name']) ? 'border-cyan-400/40 shadow-[0_0_40px_rgba(0,242,255,0.1)]' : 'border-white/10' }} shadow-2xl space-y-10 animate-in slide-in-from-bottom-8 duration-700 relative overflow-hidden transition-all">
                            
                            @if($activeExercise && $activeExercise['name'] === $exercise['name'])
                                <div class="absolute top-0 left-0 w-full h-1 bg-cyan-400 shadow-[0_0_15px_#00F2FF]"></div>
                            @endif

                            <div class="flex items-center gap-8 px-4 relative z-10">
                                <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center text-white/40 border border-white/10 shadow-inner cursor-pointer hover:bg-cyan-400/10 transition-colors" wire:click="selectExercise({{ $exIdx }})">
                                    <span class="font-black text-lg">{{ $exIdx + 1 }}</span>
                                </div>
                                <div class="flex-1 group">
                                    <input 
                                        type="text" 
                                        wire:model.blur="exercises.{{ $exIdx }}.name"
                                        wire:click="selectExercise({{ $exIdx }})"
                                        class="bg-transparent border-none text-3xl font-black text-white placeholder-white/10 focus:ring-0 focus:outline-none w-full tracking-tight cursor-pointer hover:text-cyan-400 transition-colors"
                                        placeholder="Identify Movement..."
                                    >
                                    <div class="h-[1px] w-0 group-focus-within:w-full bg-cyan-400 transition-all duration-700 opacity-30"></div>
                                </div>
                                @if($activeExercise && $activeExercise['name'] === $exercise['name'])
                                    <div class="flex items-center gap-2 px-4 py-2 bg-cyan-400/10 border border-cyan-400/20 rounded-full">
                                        <span class="text-[8px] font-black text-cyan-400 uppercase tracking-widest">Selected Intelligence</span>
                                    </div>
                                @endif
                            </div>

                            <!-- SETS TABLE -->
                            <div class="overflow-x-auto relative z-10">
                                <table class="w-full text-left">
                                    <thead class="text-[11px] font-black text-white/20 uppercase tracking-[0.4em]">
                                        <tr>
                                            <th class="pb-8 px-6">Set</th>
                                            <th class="pb-8 px-6">Weight (kg)</th>
                                            <th class="pb-8 px-6">Reps</th>
                                            <th class="pb-8 px-6">RPE</th>
                                            <th class="pb-8 px-6 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="space-y-6">
                                        @foreach($exercise['sets'] as $setIdx => $set)
                                            <tr wire:key="set-{{ $exIdx }}-{{ $setIdx }}" class="group bg-white/2 hover:bg-white/5 transition-all rounded-2xl border-b border-white/5 last:border-none">
                                                <td class="py-6 px-6">
                                                    <div class="flex items-center gap-4">
                                                        <span class="text-sm font-black text-white/40">{{ $setIdx + 1 }}</span>
                                                        @if($set['is_pr'] ?? false)
                                                            <span class="px-3 py-1 bg-yellow-400/10 border border-yellow-400/30 text-yellow-400 text-[8px] font-black uppercase tracking-widest rounded-full shadow-[0_0_15px_rgba(250,204,21,0.2)] animate-pulse">New PR</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="py-6 px-6">
                                                    <input type="number" 
                                                        wire:model.blur="exercises.{{ $exIdx }}.sets.{{ $setIdx }}.weight" 
                                                        wire:change="checkPR({{ $exIdx }}, {{ $setIdx }})" 
                                                        class="w-28 bg-black/40 border border-white/10 rounded-2xl px-5 py-3 text-white font-black text-lg focus:border-cyan-400 focus:glow-cyan-border outline-none transition-all placeholder-white/5"
                                                        placeholder="0.0">
                                                </td>
                                                <td class="py-6 px-6">
                                                    <input type="number" 
                                                        wire:model.blur="exercises.{{ $exIdx }}.sets.{{ $setIdx }}.reps" 
                                                        wire:change="calculateVolume" 
                                                        class="w-24 bg-black/40 border border-white/10 rounded-2xl px-5 py-3 text-white font-black text-lg focus:border-cyan-400 focus:glow-cyan-border outline-none transition-all placeholder-white/5"
                                                        placeholder="0">
                                                </td>
                                                <td class="py-6 px-6">
                                                    <input type="number" 
                                                        wire:model.blur="exercises.{{ $exIdx }}.sets.{{ $setIdx }}.rpe" 
                                                        class="w-20 bg-black/40 border border-white/10 rounded-2xl px-5 py-3 text-white font-black text-lg focus:border-cyan-400 focus:glow-cyan-border outline-none transition-all placeholder-white/5" 
                                                        max="10" placeholder="RPE">
                                                </td>
                                                <td class="py-6 px-6 text-right">
                                                    <button 
                                                        wire:click="removeSet({{ $exIdx }}, {{ $setIdx }})" 
                                                        class="p-3 text-rose-500/20 hover:text-rose-500 hover:bg-rose-500/10 rounded-xl transition-all opacity-0 group-hover:opacity-100 hover:glow-red"
                                                    >
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button 
                                wire:click="addSet({{ $exIdx }})"
                                class="w-full py-5 border border-dashed border-white/10 rounded-3xl text-[11px] font-black text-white/20 uppercase tracking-[0.5em] hover:bg-white/5 hover:text-cyan-400 hover:border-cyan-400/30 transition-all duration-500"
                            >
                                + Push Set & Ignite Recovery
                            </button>
                        </div>
                    @endforeach

                    <div class="flex flex-col md:flex-row gap-8">
                        <button 
                            wire:click="addExercise"
                            class="flex-1 py-10 bg-white/5 backdrop-blur-xl border border-white/10 rounded-[3.5rem] text-[11px] font-black text-white uppercase tracking-[0.6em] hover:bg-white/10 hover:border-cyan-400/40 transition-all shadow-2xl group overflow-hidden relative"
                        >
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            <span class="group-hover:text-cyan-400 transition-colors relative z-10">Integrate New Movement</span>
                        </button>
                        
                        <button 
                            @click="finishing = true; setTimeout(() => $wire.finishSession(), 500)"
                            class="px-20 py-10 bg-cyan-400 hover:bg-cyan-300 text-black rounded-[3.5rem] font-black text-[11px] uppercase tracking-[0.5em] transition-all shadow-[0_0_50px_rgba(0,242,255,0.4)] active:scale-95"
                        >
                            Secure Vault Entry
                        </button>
                    </div>

                    <div class="text-center pt-8">
                        <button wire:click="cancelSession" class="group px-10 py-4 text-[10px] font-black text-rose-500/40 hover:text-rose-500 uppercase tracking-[0.6em] transition-all hover:bg-rose-500/5 rounded-full border border-transparent hover:border-rose-500/20">
                            <span class="group-hover:neon-text">Abort Mission & Eject Data</span>
                        </button>
                    </div>
                </div>
            </div>

            @if($activeExercise)
                <div 
                    class="lg:col-span-4 space-y-8 sticky top-12 h-fit transition-all duration-700"
                    x-show="!finishing"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-x-12 scale-95"
                    x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-x-0 origin-right"
                >
                    <div 
                        class="bg-white/5 backdrop-blur-3xl rounded-[3.5rem] border transition-all duration-500 overflow-hidden relative group"
                        :class="pulsing ? 'border-cyan-400 shadow-[0_0_50px_rgba(0,242,255,0.4)] scale-[1.02]' : 'border-cyan-400/30 shadow-neon-cyan'"
                    >
                        <!-- Holographic Glitch Effect Background -->
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,_rgba(0,242,255,0.1),_transparent_70%)]"></div>
                        
                        <div class="relative z-10 p-8">
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-cyan-400" :class="pulsing ? 'animate-ping' : ''"></div>
                                    <span class="text-[10px] font-black text-cyan-400 uppercase tracking-[0.5em]">Neural Link: {{ $trainingType }}</span>
                                </div>
                                <button wire:click="$set('activeExercise', null)" class="text-white/20 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <!-- Holographic Video Player -->
                            <div class="relative rounded-[2.5rem] overflow-hidden border border-white/10 mb-8 aspect-square bg-black shadow-[inset_0_0_50px_rgba(0,0,0,0.8)]">
                                @if($activeExercise['demo_url'])
                                    <video 
                                        src="{{ $activeExercise['demo_url'] }}" 
                                        autoplay loop muted playsinline 
                                        class="w-full h-full object-cover mix-blend-lighten opacity-90 filter brightness-110 contrast-125 transition-all duration-500"
                                        :class="pulsing ? 'scale-110 brightness-150' : ''"
                                    ></video>
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-white/2">
                                        <svg class="w-20 h-20 text-white/5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 21a9 9 0 100-18 9 9 0 000 18z"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0B] via-transparent to-transparent opacity-60"></div>
                                <div class="absolute bottom-6 left-6">
                                    <h3 class="text-2xl font-black text-white tracking-tighter uppercase font-syncopate">{{ $activeExercise['name'] }}</h3>
                                </div>
                            </div>

                            <div class="space-y-10">
                                <!-- Anatomical Mapping -->
                                <div>
                                    <h4 class="text-[10px] font-black text-white/30 uppercase tracking-[0.4em] mb-6 px-2 text-center">Anatomical HUD</h4>
                                    <div class="p-8 bg-black/40 rounded-[2.5rem] border border-white/5 flex flex-col items-center justify-center relative overflow-hidden">
                                        <div class="absolute inset-0 bg-cyan-400/2 opacity-20"></div>
                                        
                                        <!-- Final Stylized Geometric SVG -->
                                        <svg viewBox="0 0 200 400" class="w-full h-auto opacity-80 transition-all duration-700 max-w-[120px]">
                                            <!-- Geometric Body Shell -->
                                            <path d="M100,20 L120,40 L120,80 L80,80 L80,40 Z" class="fill-white/5 stroke-white/20" />
                                            <path d="M80,85 L120,85 L130,130 L110,180 L90,180 L70,130 Z" class="fill-white/5 stroke-white/20" />
                                            <path d="M70,135 L60,200 L75,350 L95,350 L100,200 Z" class="fill-white/5 stroke-white/20" />
                                            <path d="M130,135 L140,200 L125,350 L105,350 L100,200 Z" class="fill-white/5 stroke-white/20" />
                                            <path d="M80,85 L50,110 L40,160 L55,160 L65,110 Z" class="fill-white/5 stroke-white/20" />
                                            <path d="M120,85 L150,110 L160,160 L145,160 L135,110 Z" class="fill-white/5 stroke-white/20" />

                                            <!-- Dynamic Muscle Highlights -->
                                            <path id="chest" d="M85,90 L115,90 L115,115 L85,115 Z" 
                                                class="{{ $activeExercise['muscle_group'] == 'Chest' ? 'fill-cyan-400 filter drop-shadow-[0_0_8px_rgba(0,242,255,0.8)]' : 'fill-transparent' }} transition-all duration-500" />
                                            
                                            <path id="back" d="M85,120 L115,120 L115,170 L85,170 Z" 
                                                class="{{ $activeExercise['muscle_group'] == 'Back' ? 'fill-cyan-400 filter drop-shadow-[0_0_8px_rgba(0,242,255,0.8)]' : 'fill-transparent' }} transition-all duration-500" />

                                            <path id="quads" d="M70,190 L95,190 L95,280 L70,280 Z M105,190 L130,190 L130,280 L105,280 Z" 
                                                class="{{ $activeExercise['muscle_group'] == 'Legs' ? 'fill-cyan-400 filter drop-shadow-[0_0_8px_rgba(0,242,255,0.8)]' : 'fill-transparent' }} transition-all duration-500" />
                                            
                                            <path id="shoulders" d="M60,90 L75,90 L75,110 L60,110 Z M125,90 L140,90 L140,110 L125,110 Z" 
                                                class="{{ $activeExercise['muscle_group'] == 'Shoulders' ? 'fill-cyan-400 filter drop-shadow-[0_0_8px_rgba(0,242,255,0.8)]' : 'fill-transparent' }} transition-all duration-500" />
                                        </svg>

                                        <div class="mt-8 text-center relative z-10">
                                            <span class="block text-white font-black text-xl uppercase tracking-tighter">{{ $activeExercise['muscle_group'] }}</span>
                                            <div class="mt-2 flex items-center justify-center gap-2">
                                                <div class="w-1.5 h-1.5 rounded-full bg-cyan-400" :class="pulsing ? 'animate-ping' : 'animate-pulse'"></div>
                                                <span class="text-[9px] font-bold text-cyan-400/80 uppercase tracking-widest">Metabolic Target Locked</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vertical Form Cues Ticker -->
                                <div class="relative bg-black/40 rounded-3xl border border-white/5 overflow-hidden p-6 h-32">
                                    <div class="absolute top-0 left-0 w-full h-8 bg-gradient-to-b from-[#0A0A0B] to-transparent z-10"></div>
                                    <div class="absolute bottom-0 left-0 w-full h-8 bg-gradient-to-t from-[#0A0A0B] to-transparent z-10"></div>
                                    
                                    <div class="space-y-6 animate-ticker-vertical flex flex-col items-center">
                                        @foreach(explode(',', $activeExercise['tips']) as $tip)
                                            <div class="flex items-center gap-4 group">
                                                <div class="w-1 h-1 rounded-full bg-cyan-400 shadow-[0_0_8px_#00F2FF]"></div>
                                                <p class="text-[10px] font-black text-cyan-400/70 uppercase tracking-widest text-center group-hover:text-cyan-400 transition-colors">{{ trim($tip) }}</p>
                                            </div>
                                        @endforeach
                                        <!-- Duplicate for seamless loop -->
                                        @foreach(explode(',', $activeExercise['tips']) as $tip)
                                            <div class="flex items-center gap-4 group">
                                                <div class="w-1 h-1 rounded-full bg-cyan-400 shadow-[0_0_8px_#00F2FF]"></div>
                                                <p class="text-[10px] font-black text-cyan-400/70 uppercase tracking-widest text-center group-hover:text-cyan-400 transition-colors">{{ trim($tip) }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Performance Benchmarks -->
                                <div class="bg-white/5 backdrop-blur-2xl rounded-[2.5rem] border border-white/10 p-6 flex items-center justify-between group hover:border-cyan-400/20 transition-all">
                                    <div>
                                        <span class="block text-[8px] font-black text-white/20 uppercase tracking-widest mb-1">Session Target</span>
                                        <span class="text-lg font-black text-white">Hypertrophy Zone</span>
                                    </div>
                                    <div class="w-12 h-12 rounded-full border-2 border-cyan-400/20 flex items-center justify-center text-cyan-400">
                                        <span class="text-[10px] font-black">85%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
      <!-- REST TIMER HUD -->
            <div 
                x-show="show" 
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 translate-y-20 scale-90"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-20 scale-90"
                class="fixed bottom-12 left-1/2 -translate-x-1/2 z-[100] w-72 p-8 bg-black/90 backdrop-blur-3xl rounded-[3rem] border border-cyan-400/40 shadow-[0_0_80px_rgba(0,242,255,0.3)] text-center"
            >
                <div class="relative w-32 h-32 mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-full h-full -rotate-90 transform" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="2" fill="transparent" class="text-white/5" />
                        <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="4" fill="transparent"
                            class="text-cyan-400"
                            stroke-dasharray="282.7"
                            :stroke-dashoffset="282.7 - (timeLeft / 90) * 282.7"
                            stroke-linecap="round"
                            style="filter: drop-shadow(0 0 12px #00F2FF); transition: stroke-dashoffset 1s linear;"
                        />
                    </svg>
                    <div class="absolute flex flex-col items-center">
                        <span class="text-4xl font-black text-white tracking-tighter font-mono leading-none" x-text="timeLeft">90</span>
                        <span class="text-[8px] font-black text-white/30 uppercase tracking-widest mt-1">Sec</span>
                    </div>
                </div>
                <span class="text-[10px] font-black text-cyan-400 uppercase tracking-[0.5em] animate-pulse">Recovery In Progress</span>
                <button @click="show = false" class="absolute top-6 right-6 text-white/20 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <script>
            function restTimer() {
                return {
                    show: false,
                    timeLeft: 90,
                    elapsed: 0,
                    interval: null,
                    timerInterval: null,
                    
                    init() {
                        this.interval = setInterval(() => {
                            this.elapsed++;
                        }, 1000);

                        this.$on('start-rest-timer', (event) => {
                            this.startTimer(event.detail.duration);
                        });
                    },

                    startTimer(seconds) {
                        this.show = true;
                        this.timeLeft = seconds;
                        clearInterval(this.timerInterval);
                        
                        this.timerInterval = setInterval(() => {
                            if (this.timeLeft > 0) {
                                this.timeLeft--;
                            } else {
                                this.show = false;
                                clearInterval(this.timerInterval);
                                // Play subtle ping
                                new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3').play();
                            }
                        }, 1000);
                    },

                    formatTime(seconds) {
                        const mins = Math.floor(seconds / 60);
                        const secs = seconds % 60;
                        return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                    }
                }
            }
        </script>
    @endif
</div>
