<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 text-slate-100" x-data="workoutApp()">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
            <div>
                <h1 class="text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400 tracking-tight">Workout</h1>
                <p class="text-slate-400 mt-2 text-lg">Build and track your training</p>
            </div>
            <button @click="startCustomBuilder()" 
                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-xl font-semibold transition-all shadow-[0_0_15px_rgba(79,70,229,0.4)] hover:shadow-[0_0_25px_rgba(79,70,229,0.6)] flex items-center gap-2 border border-indigo-400/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Create Custom Workout
            </button>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex space-x-2 mb-8 overflow-x-auto pb-2 border-b border-slate-800/60 scrollbar-hide">
            <template x-for="tab in tabs" :key="tab.id">
                <button @click="activeTab = tab.id" 
                        class="px-6 py-3 rounded-xl font-medium transition-all whitespace-nowrap text-sm tracking-wide"
                        :class="activeTab === tab.id ? 'bg-slate-800/80 text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.1)] ring-1 ring-slate-700/50' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40'">
                    <span x-text="tab.name"></span>
                </button>
            </template>
        </div>

        <!-- 1. Predefined Workouts -->
        <div x-show="activeTab === 'predefined'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="workout in predefinedWorkouts" :key="workout.id">
                    <div class="group relative bg-slate-900/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_15px_35px_rgba(79,70,229,0.15)] hover:border-indigo-500/30">
                        <div class="absolute -inset-[1px] bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl opacity-0 group-hover:opacity-20 transition duration-500 blur-sm"></div>
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700/50 flex items-center justify-center text-indigo-400 group-hover:text-indigo-300 group-hover:scale-110 shadow-inner transition-all duration-300" x-html="workout.icon"></div>
                                <span class="px-3 py-1 bg-slate-800/80 rounded-full text-xs font-semibold text-slate-300 border border-slate-700/50" x-text="workout.duration"></span>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2 tracking-tight" x-text="workout.title"></h3>
                            <p class="text-slate-400 text-sm mb-6 leading-relaxed line-clamp-2" x-text="workout.description"></p>
                            <button @click="startActiveWorkout(workout)" class="w-full py-3 rounded-xl bg-slate-800/80 text-white font-medium hover:bg-indigo-600 hover:shadow-[0_0_15px_rgba(79,70,229,0.4)] border border-slate-700/50 hover:border-indigo-500 transition-all duration-300 flex justify-center items-center gap-2 group/btn">
                                Start Workout
                                <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- 2. Custom Workout Builder -->
        <div x-show="activeTab === 'custom'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
            
            <div class="bg-slate-900/40 backdrop-blur-xl border border-slate-800/80 rounded-3xl overflow-hidden shadow-2xl relative">
                
                <!-- Steps Header -->
                <div class="px-8 py-6 border-b border-slate-800/60 bg-slate-900/60 flex justify-between items-center relative z-10">
                    <div class="flex items-center gap-4">
                        <template x-for="step in [1, 2, 3]" :key="step">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                                     :class="customBuilder.step >= step ? 'bg-indigo-600 text-white shadow-[0_0_10px_rgba(79,70,229,0.5)]' : 'bg-slate-800 text-slate-500 border border-slate-700'">
                                    <span x-text="step"></span>
                                </div>
                                <div x-show="step < 3" class="w-8 h-[2px] mx-2 transition-all duration-300"
                                     :class="customBuilder.step > step ? 'bg-indigo-500' : 'bg-slate-800'"></div>
                            </div>
                        </template>
                    </div>
                    <div class="text-right">
                        <h2 class="text-xl font-bold text-white tracking-tight" x-text="getStepTitle()"></h2>
                        <p class="text-sm text-slate-400" x-text="getStepDescription()"></p>
                    </div>
                </div>

                <!-- Step 1: Name & Target -->
                <div x-show="customBuilder.step === 1" class="p-8 relative z-10" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="max-w-2xl mx-auto space-y-8">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Workout Name</label>
                            <input type="text" x-model="customBuilder.name" class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-5 py-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all shadow-inner" placeholder="e.g. Explosive Leg Day">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-4">Primary Target</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <template x-for="target in targets" :key="target.id">
                                    <button @click="customBuilder.target = target.id" 
                                            class="p-4 rounded-xl border flex flex-col items-center gap-3 transition-all duration-200"
                                            :class="customBuilder.target === target.id ? 'bg-indigo-600/20 border-indigo-500 text-indigo-300 shadow-[inset_0_0_15px_rgba(79,70,229,0.2)]' : 'bg-slate-800/30 border-slate-700/50 text-slate-400 hover:bg-slate-800/60 hover:border-slate-600'">
                                        <div class="w-8 h-8" x-html="target.icon"></div>
                                        <span class="text-sm font-medium" x-text="target.name"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button @click="nextStep()" :disabled="!customBuilder.name || !customBuilder.target" class="px-8 py-3.5 bg-white text-slate-900 rounded-xl font-bold hover:bg-indigo-50 hover:text-indigo-900 transition-all shadow-[0_0_20px_rgba(255,255,255,0.1)] disabled:opacity-50 disabled:cursor-not-allowed">
                                Continue to Exercises
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Choose Exercises (ExerciseDB API) -->
                <div x-show="customBuilder.step === 2" class="p-8 relative z-10" style="display: none;">
                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Left: Search & Library Grid -->
                        <div class="w-full lg:w-2/3 space-y-6">
                            <div class="flex gap-4">
                                <div class="relative flex-1">
                                    <input type="text" x-model="searchQuery" @input.debounce.500ms="searchExercises()" class="w-full bg-slate-800/50 border border-slate-700 rounded-xl pl-12 pr-5 py-3.5 text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all shadow-inner" placeholder="Search exercises (API powered)...">
                                    <svg class="w-5 h-5 absolute left-4 top-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>

                            <div class="h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                                <div x-show="loadingExercises" class="flex justify-center items-center h-full">
                                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-500"></div>
                                </div>
                                
                                <div x-show="!loadingExercises" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <template x-for="exercise in exercisesList" :key="exercise.id">
                                        <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl overflow-hidden hover:border-slate-600 transition-all group flex flex-col">
                                            <div class="h-40 bg-slate-900 flex items-center justify-center p-2 relative overflow-hidden">
                                                <img :src="exercise.gifUrl" :alt="exercise.name" class="h-full object-contain mix-blend-screen opacity-80 group-hover:opacity-100 transition-opacity rounded-lg" loading="lazy">
                                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                                                <div class="absolute bottom-2 left-3 flex gap-2">
                                                    <span class="px-2 py-1 bg-indigo-900/60 text-indigo-300 text-[10px] uppercase font-bold rounded border border-indigo-500/30 backdrop-blur-sm" x-text="exercise.target"></span>
                                                    <span class="px-2 py-1 bg-slate-800/60 text-slate-300 text-[10px] uppercase font-bold rounded border border-slate-600/50 backdrop-blur-sm" x-text="exercise.equipment"></span>
                                                </div>
                                            </div>
                                            <div class="p-4 flex-1 flex flex-col justify-between">
                                                <h4 class="text-white font-semibold leading-tight mb-3 capitalize text-sm" x-text="exercise.name"></h4>
                                                <button @click="addExerciseToWorkout(exercise)" class="w-full py-2 bg-slate-700/50 hover:bg-indigo-600 text-white rounded-lg text-sm font-medium transition-colors flex justify-center items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    Add
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Selected Exercises List -->
                        <div class="w-full lg:w-1/3 flex flex-col">
                            <div class="bg-slate-800/30 border border-slate-700/50 rounded-2xl p-5 flex-1 flex flex-col h-[500px]">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-white">Workout Plan</h3>
                                    <span class="text-xs bg-indigo-600/20 text-indigo-400 px-2.5 py-1 rounded-md font-semibold border border-indigo-500/30" x-text="customBuilder.exercises.length + ' Exercises'"></span>
                                </div>
                                
                                <div class="flex-1 overflow-y-auto space-y-3 custom-scrollbar pr-2" id="sortable-list">
                                    <div x-show="customBuilder.exercises.length === 0" class="h-full flex flex-col items-center justify-center text-slate-500 text-sm text-center p-6 border-2 border-dashed border-slate-700 rounded-xl">
                                        <svg class="w-12 h-12 mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        Add exercises from the library
                                    </div>
                                    
                                    <template x-for="(ex, index) in customBuilder.exercises" :key="ex.uniqueId">
                                        <div class="bg-slate-900/60 border border-slate-700 rounded-xl p-3 flex items-center gap-3 group relative cursor-move">
                                            <div class="w-12 h-12 bg-slate-800 rounded-lg overflow-hidden flex-shrink-0">
                                                <img :src="ex.gifUrl" class="w-full h-full object-cover mix-blend-screen opacity-70">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h5 class="text-white text-sm font-bold truncate capitalize" x-text="ex.name"></h5>
                                                <div class="flex gap-3 mt-1.5">
                                                    <div class="flex items-center gap-1">
                                                        <span class="text-xs text-slate-400">Sets</span>
                                                        <input type="number" x-model.number="ex.sets" class="w-10 bg-slate-800 border border-slate-700 rounded text-xs text-white px-1 py-0.5 text-center focus:border-indigo-500 outline-none">
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <span class="text-xs text-slate-400">Reps</span>
                                                        <input type="number" x-model.number="ex.reps" class="w-10 bg-slate-800 border border-slate-700 rounded text-xs text-white px-1 py-0.5 text-center focus:border-indigo-500 outline-none">
                                                    </div>
                                                </div>
                                            </div>
                                            <button @click="removeExercise(index)" class="w-8 h-8 rounded-full bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>

                                <div class="mt-4 pt-4 border-t border-slate-700/50 flex gap-3">
                                    <button @click="customBuilder.step = 1" class="px-4 py-3 bg-slate-800 hover:bg-slate-700 text-white rounded-xl font-medium transition-colors text-sm">Back</button>
                                    <button @click="nextStep()" :disabled="customBuilder.exercises.length === 0" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition-all shadow-[0_0_15px_rgba(79,70,229,0.3)] disabled:opacity-50 disabled:cursor-not-allowed">
                                        Review & Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Review & Save -->
                <div x-show="customBuilder.step === 3" class="p-8 relative z-10" style="display: none;">
                    <div class="max-w-3xl mx-auto">
                        <div class="bg-gradient-to-br from-indigo-900/40 to-purple-900/40 border border-indigo-500/30 rounded-2xl p-8 text-center mb-8 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                            <h3 class="text-3xl font-bold text-white mb-2" x-text="customBuilder.name"></h3>
                            <div class="flex justify-center gap-4 text-slate-300 text-sm">
                                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> <span x-text="customBuilder.exercises.length + ' Exercises'"></span></span>
                                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> <span x-text="calculateTotalSets() + ' Sets Total'"></span></span>
                            </div>
                        </div>

                        <div class="space-y-3 mb-8 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="(ex, index) in customBuilder.exercises" :key="index">
                                <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl p-4 flex items-center gap-4">
                                    <div class="w-8 h-8 rounded-full bg-slate-800 text-slate-400 flex items-center justify-center font-bold text-sm border border-slate-700">
                                        <span x-text="index + 1"></span>
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="text-white font-bold capitalize" x-text="ex.name"></h5>
                                        <p class="text-sm text-slate-400"><span x-text="ex.sets"></span> sets × <span x-text="ex.reps"></span> reps</p>
                                    </div>
                                    <div class="w-16 h-16 rounded bg-slate-900 border border-slate-700 p-1">
                                        <img :src="ex.gifUrl" class="w-full h-full object-cover mix-blend-screen opacity-80">
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="flex justify-end gap-4">
                            <button @click="customBuilder.step = 2" class="px-6 py-3.5 bg-slate-800 hover:bg-slate-700 text-white rounded-xl font-medium transition-colors">Edit Exercises</button>
                            <button @click="saveCustomWorkout()" class="px-8 py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-xl font-bold transition-all shadow-[0_0_20px_rgba(79,70,229,0.5)] flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Save & Finish
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. My Workouts -->
        <div x-show="activeTab === 'my'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
            <div x-show="myWorkouts.length === 0" class="text-center py-20 bg-slate-900/30 rounded-3xl border border-slate-800/50 backdrop-blur-sm">
                <div class="w-20 h-20 bg-slate-800/80 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-700">
                    <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">No custom workouts yet</h3>
                <p class="text-slate-400 mb-8 max-w-md mx-auto">Create your own tailored routines by combining exercises from our extensive library.</p>
                <button @click="startCustomBuilder()" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition-all shadow-[0_0_15px_rgba(79,70,229,0.3)] inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create Your First Workout
                </button>
            </div>

            <div x-show="myWorkouts.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="workout in myWorkouts" :key="workout.id">
                    <div class="group bg-slate-900/50 backdrop-blur-md border border-slate-800 rounded-2xl p-6 transition-all duration-300 hover:shadow-[0_10px_30px_rgba(168,85,247,0.1)] hover:border-purple-500/40 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-500/20 to-transparent rounded-bl-full opacity-50 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold text-white mb-2" x-text="workout.name"></h3>
                            <div class="flex gap-4 text-sm text-slate-400 mb-6">
                                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> <span x-text="workout.exercises.length + ' Exercises'"></span></span>
                            </div>
                            
                            <div class="flex gap-2">
                                <button @click="startActiveWorkout(workout)" class="flex-1 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-medium transition-colors shadow-[0_0_10px_rgba(79,70,229,0.3)] text-sm">Start</button>
                                <button class="px-4 py-2.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 transition-colors border border-slate-700 text-sm">Edit</button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Active Workout Modal -->
        <div x-show="activeWorkout.isActive" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
             style="display: none;">
            
            <div class="absolute inset-0 bg-black/80 backdrop-blur-xl transition-opacity" x-transition.opacity></div>
            
            <div class="relative bg-slate-900 border border-slate-700/50 rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl flex flex-col max-h-full"
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4" 
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                 
                <!-- Neon top border glow -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-neon-blue via-indigo-500 to-neon-green"></div>

                <!-- Header -->
                <div class="p-6 border-b border-slate-800/80 flex justify-between items-center bg-slate-900/80 backdrop-blur z-10">
                    <div>
                        <span class="text-indigo-400 font-bold text-xs uppercase tracking-wider mb-1 block" x-text="activeWorkout.data?.name || activeWorkout.data?.title"></span>
                        <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                            <span x-text="activeWorkout.currentExerciseIndex + 1"></span>. 
                            <span x-text="getCurrentExercise()?.name" class="capitalize"></span>
                        </h2>
                    </div>
                    <button @click="endWorkout()" class="w-10 h-10 rounded-full bg-slate-800 text-slate-400 hover:bg-slate-700 hover:text-white flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 sm:p-8 flex-1 overflow-y-auto">
                    <div class="flex flex-col sm:flex-row gap-8 items-center sm:items-start">
                        
                        <!-- GIF Preview -->
                        <div class="w-48 sm:w-64 aspect-square bg-slate-800/50 rounded-2xl border border-slate-700 p-4 flex items-center justify-center shrink-0 relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-transparent rounded-2xl"></div>
                            <img :src="getCurrentExercise()?.gifUrl || 'https://via.placeholder.com/400x400.png?text=Exercise+GIF'" class="w-full h-full object-contain mix-blend-screen">
                        </div>

                        <!-- Details & Tracker -->
                        <div class="flex-1 w-full space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl p-4 text-center">
                                    <span class="block text-slate-400 text-sm mb-1">Target Sets</span>
                                    <span class="text-3xl font-extrabold text-white" x-text="getCurrentExercise()?.sets || 3"></span>
                                </div>
                                <div class="bg-slate-800/40 border border-slate-700/50 rounded-xl p-4 text-center">
                                    <span class="block text-slate-400 text-sm mb-1">Target Reps</span>
                                    <span class="text-3xl font-extrabold text-white" x-text="getCurrentExercise()?.reps || 12"></span>
                                </div>
                            </div>

                            <!-- Set Tracker -->
                            <div>
                                <h4 class="text-sm font-semibold text-slate-300 mb-3 uppercase tracking-wider">Track Your Sets</h4>
                                <div class="space-y-2">
                                    <template x-for="setNum in parseInt(getCurrentExercise()?.sets || 3)" :key="setNum">
                                        <div class="flex items-center gap-4 bg-slate-800/30 p-2.5 rounded-lg border border-slate-700/30">
                                            <div class="w-8 h-8 rounded-full bg-slate-800 text-slate-400 flex items-center justify-center text-xs font-bold border border-slate-700">
                                                <span x-text="setNum"></span>
                                            </div>
                                            <div class="flex-1 flex gap-2">
                                                <input type="number" placeholder="lbs" class="w-20 bg-slate-900 border border-slate-700 rounded-md px-2 py-1.5 text-white text-sm focus:border-indigo-500 outline-none placeholder-slate-600">
                                                <input type="number" :placeholder="getCurrentExercise()?.reps || 12" class="w-20 bg-slate-900 border border-slate-700 rounded-md px-2 py-1.5 text-white text-sm focus:border-indigo-500 outline-none placeholder-slate-600">
                                            </div>
                                            <button class="w-8 h-8 rounded-full bg-slate-700 hover:bg-green-500 text-white flex items-center justify-center transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer / Next Action -->
                <div class="p-6 bg-slate-900 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4">
                    
                    <!-- Progress bar -->
                    <div class="w-full sm:w-1/2">
                        <div class="flex justify-between text-xs text-slate-400 mb-1.5">
                            <span>Workout Progress</span>
                            <span x-text="Math.round(((activeWorkout.currentExerciseIndex) / (activeWorkout.data?.exercises?.length || 1)) * 100) + '%'"></span>
                        </div>
                        <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 transition-all duration-500"
                                 :style="`width: ${((activeWorkout.currentExerciseIndex) / (activeWorkout.data?.exercises?.length || 1)) * 100}%`"></div>
                        </div>
                    </div>

                    <button @click="nextExercise()" class="w-full sm:w-auto px-8 py-3.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition-all shadow-[0_0_15px_rgba(79,70,229,0.3)] flex items-center justify-center gap-2">
                        <span x-text="activeWorkout.currentExerciseIndex >= (activeWorkout.data?.exercises?.length - 1) ? 'Finish Workout' : 'Next Exercise'"></span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- Add Tailwind Custom Config via CSS variables and custom classes -->
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #475569; }

        .text-neon-blue { color: #00f0ff; }
        .text-neon-green { color: #39ff14; }
        .from-neon-blue { --tw-gradient-from: #00f0ff; --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(0, 240, 255, 0)); }
        .to-neon-green { --tw-gradient-to: #39ff14; }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('workoutApp', () => ({
                activeTab: 'predefined',
                tabs: [
                    { id: 'predefined', name: 'Predefined Workouts' },
                    { id: 'custom', name: 'Custom Builder' },
                    { id: 'my', name: 'My Workouts' }
                ],
                
                // Predefined Data
                predefinedWorkouts: [
                    { id: 1, title: 'Push Day', duration: '45-60 min', description: 'Chest, shoulders, and triceps focus. Build upper body pushing strength.', icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>', exercises: [{name: 'Bench Press', sets: 4, reps: 10}, {name: 'Overhead Press', sets: 3, reps: 12}] },
                    { id: 2, title: 'Pull Day', duration: '50-60 min', description: 'Back, biceps, and rear delts. Essential for posture and pulling power.', icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>', exercises: [{name: 'Pull Ups', sets: 4, reps: 8}, {name: 'Barbell Rows', sets: 3, reps: 10}] },
                    { id: 3, title: 'Legs & Core', duration: '60 min', description: 'Quads, hamstrings, glutes, and calves. The foundation of true strength.', icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>', exercises: [{name: 'Squats', sets: 4, reps: 8}, {name: 'Leg Press', sets: 3, reps: 15}] },
                    { id: 4, title: 'HIIT Burner', duration: '20-30 min', description: 'High intensity intervals for maximum calorie burn and cardiovascular health.', icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path></svg>', exercises: [{name: 'Burpees', sets: 5, reps: 15}, {name: 'Jump Squats', sets: 4, reps: 20}] },
                ],

                // Targets for Builder
                targets: [
                    { id: 'chest', name: 'Chest', icon: '<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>' },
                    { id: 'back', name: 'Back', icon: '<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>' },
                    { id: 'legs', name: 'Legs', icon: '<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>' },
                    { id: 'arms', name: 'Arms', icon: '<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>' },
                ],

                // Custom Builder State
                customBuilder: {
                    step: 1,
                    name: '',
                    target: null,
                    exercises: []
                },

                // API & Library State
                searchQuery: '',
                loadingExercises: false,
                exercisesList: [],
                
                // My Workouts
                myWorkouts: [],

                // Active Workout State
                activeWorkout: {
                    isActive: false,
                    data: null,
                    currentExerciseIndex: 0,
                    restTimer: 0
                },

                // API Key fallback logic (Since env might not be loaded in client JS directly this way securely, we use a mock approach if not provided via blade)
                init() {
                    // Initialize some mock API data to show UI without API key
                    this.loadMockExercises();
                },

                startCustomBuilder() {
                    this.activeTab = 'custom';
                    this.customBuilder = { step: 1, name: '', target: null, exercises: [] };
                },

                getStepTitle() {
                    if (this.customBuilder.step === 1) return 'Workout Details';
                    if (this.customBuilder.step === 2) return 'Build Routine';
                    return 'Review & Save';
                },

                getStepDescription() {
                    if (this.customBuilder.step === 1) return 'Name your workout and set a primary target';
                    if (this.customBuilder.step === 2) return 'Select and reorder your exercises';
                    return 'Confirm your selections and save';
                },

                nextStep() {
                    if (this.customBuilder.step === 1 && this.customBuilder.target) {
                        this.loadingExercises = true;
                        // Simulate API fetch delay
                        setTimeout(() => {
                            this.searchExercises();
                            this.loadingExercises = false;
                        }, 600);
                    }
                    if (this.customBuilder.step < 3) this.customBuilder.step++;
                },

                async searchExercises() {
                    // Realistic Mock of ExerciseDB API since we don't expose API key to client directly usually
                    // Or if we had it: fetch(`https://exercisedb.p.rapidapi.com/exercises/name/${this.searchQuery}...`)
                    this.loadingExercises = true;
                    
                    setTimeout(() => {
                        this.loadMockExercises();
                        
                        if (this.searchQuery) {
                            this.exercisesList = this.exercisesList.filter(ex => 
                                ex.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                            );
                        }
                        
                        this.loadingExercises = false;
                    }, 500);
                },

                loadMockExercises() {
                    const mockData = [
                        { id: '0001', name: 'Barbell Bench Press', target: 'chest', equipment: 'barbell', gifUrl: 'https://fitnessprogramer.com/wp-content/uploads/2021/02/Barbell-Bench-Press.gif' },
                        { id: '0002', name: 'Dumbbell Flyes', target: 'chest', equipment: 'dumbbell', gifUrl: 'https://fitnessprogramer.com/wp-content/uploads/2021/02/Dumbbell-Fly.gif' },
                        { id: '0003', name: 'Push-up', target: 'chest', equipment: 'body weight', gifUrl: 'https://fitnessprogramer.com/wp-content/uploads/2021/02/Push-Up.gif' },
                        { id: '0004', name: 'Cable Crossover', target: 'chest', equipment: 'cable', gifUrl: 'https://fitnessprogramer.com/wp-content/uploads/2021/02/Cable-Crossover.gif' },
                        { id: '0005', name: 'Barbell Squat', target: 'legs', equipment: 'barbell', gifUrl: 'https://fitnessprogramer.com/wp-content/uploads/2021/02/BARBELL-SQUAT.gif' },
                        { id: '0006', name: 'Leg Extension', target: 'legs', equipment: 'machine', gifUrl: 'https://fitnessprogramer.com/wp-content/uploads/2021/02/Leg-Extension.gif' },
                        { id: '0007', name: 'Lat Pulldown', target: 'back', equipment: 'cable', gifUrl: 'https://fitnessprogramer.com/wp-content/uploads/2021/02/Lat-Pulldown.gif' },
                        { id: '0008', name: 'Barbell Curl', target: 'arms', equipment: 'barbell', gifUrl: 'https://fitnessprogramer.com/wp-content/uploads/2021/02/Barbell-Curl.gif' },
                    ];

                    // Filter by target if in step 2 and target is selected
                    if (this.customBuilder.target && this.customBuilder.step === 2 && !this.searchQuery) {
                         this.exercisesList = mockData.filter(ex => ex.target === this.customBuilder.target || this.customBuilder.target === 'arms'); // relaxed filter for demo
                    } else {
                         this.exercisesList = mockData;
                    }
                },

                addExerciseToWorkout(exercise) {
                    this.customBuilder.exercises.push({
                        ...exercise,
                        uniqueId: Date.now() + Math.random(), // For key tracking if same exercise added twice
                        sets: 3,
                        reps: 12
                    });
                },

                removeExercise(index) {
                    this.customBuilder.exercises.splice(index, 1);
                },

                calculateTotalSets() {
                    return this.customBuilder.exercises.reduce((total, ex) => total + parseInt(ex.sets || 0), 0);
                },

                saveCustomWorkout() {
                    const newWorkout = {
                        id: Date.now(),
                        name: this.customBuilder.name,
                        target: this.customBuilder.target,
                        exercises: [...this.customBuilder.exercises],
                        createdAt: new Date().toISOString()
                    };
                    
                    this.myWorkouts.push(newWorkout);
                    this.activeTab = 'my';
                    
                    // Reset builder
                    this.customBuilder = { step: 1, name: '', target: null, exercises: [] };
                },

                startActiveWorkout(workout) {
                    this.activeWorkout = {
                        isActive: true,
                        data: workout,
                        currentExerciseIndex: 0,
                        restTimer: 0
                    };
                    // Lock body scroll
                    document.body.style.overflow = 'hidden';
                },

                getCurrentExercise() {
                    if (!this.activeWorkout.data || !this.activeWorkout.data.exercises) return null;
                    return this.activeWorkout.data.exercises[this.activeWorkout.currentExerciseIndex] || null;
                },

                nextExercise() {
                    const total = this.activeWorkout.data?.exercises?.length || 0;
                    if (this.activeWorkout.currentExerciseIndex < total - 1) {
                        this.activeWorkout.currentExerciseIndex++;
                    } else {
                        this.endWorkout();
                        alert("Workout Completed! Great job!");
                    }
                },

                endWorkout() {
                    this.activeWorkout.isActive = false;
                    document.body.style.overflow = '';
                }
            }));
        });
    </script>
</x-app-layout>
