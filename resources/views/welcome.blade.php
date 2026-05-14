<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FITNEXUS | Anti-Gravity Fitness</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #000;
            color: #fff;
            overflow-x: hidden;
        }
        .neon-cyan { color: #00F2FF; }
        .bg-neon-cyan { background-color: #00F2FF; color: #000; }
        .hover-bg-neon-cyan:hover { background-color: #55f7ff; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
        }

        .gradient-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(0,242,255,0.1) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }
        
        /* Image masking for hero */
        .hero-image-container {
            position: relative;
            z-index: 10;
        }
        .hero-image-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40%;
            background: linear-gradient(to top, #000 0%, transparent 100%);
            pointer-events: none;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-card !rounded-none !border-x-0 !border-t-0 !border-b-white/10 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-neon-cyan flex items-center justify-center shadow-[0_0_20px_rgba(0,242,255,0.5)]">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-xl font-black tracking-[0.2em] font-syncopate uppercase">FITNEXUS</span>
            </div>
            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-300">
                <a href="#" class="hover:text-white transition">Exercises</a>
                <a href="#" class="hover:text-white transition">Trainers</a>
                <a href="#" class="hover:text-white transition">Pricing</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative pt-32 pb-16 lg:pt-48 lg:pb-32 px-6 overflow-hidden">
        <div class="gradient-glow top-20 right-20"></div>
        <div class="gradient-glow bottom-20 left-10"></div>
        
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center relative z-10">
            
            <!-- Left: Content -->
            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs font-medium text-gray-300 uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-neon-green animate-pulse"></span>
                    Premium Fitness
                </div>
                
                <h1 class="text-6xl lg:text-8xl font-black leading-[1] tracking-tighter uppercase font-syncopate">
                    FIT<br>
                    <span class="neon-cyan">NEXUS</span>
                </h1>
                
                <p class="text-lg text-slate-400 max-w-md leading-relaxed font-medium">
                    Experience the future of weightless performance. Defy gravity, optimize biometrics, and achieve peak human output.
                </p>
                
                <div class="flex flex-wrap items-center gap-6 pt-4">
                    <a href="{{ route('register') }}" class="bg-neon-cyan hover-bg-neon-cyan px-10 py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] transition shadow-[0_0_30px_rgba(0,242,255,0.3)] hover:shadow-[0_0_50px_rgba(0,242,255,0.5)] transform hover:-translate-y-1">
                        Initiate Protocol
                    </a>
                    <a href="#" class="glass-card px-10 py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-white/10 transition flex items-center gap-3 text-white border border-white/10 transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Neural Sync
                    </a>
                </div>
                
                <div class="pt-12 flex items-center gap-8 border-t border-white/10">
                    <div>
                        <div class="text-3xl font-bold">50+</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider mt-1">Expert Trainers</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">4.9</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider mt-1">Rating Review</div>
                    </div>
                </div>
            </div>

            <!-- Right: Image & Floating Cards -->
            <div class="relative hero-image-container lg:h-[700px] flex justify-center lg:justify-end items-center">
                <!-- Main Image -->
                <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                     alt="Athletic woman doing lunges" 
                     class="w-full max-w-md lg:max-w-none lg:w-[120%] lg:-mr-20 h-auto object-cover rounded-2xl grayscale contrast-125 mix-blend-lighten opacity-80"
                     style="mask-image: linear-gradient(to bottom, black 60%, transparent 100%); -webkit-mask-image: linear-gradient(to bottom, black 60%, transparent 100%);">
                     
                <!-- Floating Card 1: Time -->
                <div class="absolute top-20 left-0 lg:-left-10 glass-card p-4 flex items-center gap-4 animate-[bounce_4s_infinite] shadow-2xl border border-white/20">
                    <div class="w-10 h-10 rounded-full bg-neon-cyan/20 flex items-center justify-center text-neon-cyan shadow-[0_0_15px_rgba(0,242,255,0.3)]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">Time</div>
                        <div class="font-bold text-lg">38:14</div>
                    </div>
                </div>

                <!-- Floating Card 2: Calories -->
                <div class="absolute bottom-40 right-0 lg:-right-10 glass-card p-4 flex items-center gap-4 animate-[bounce_5s_infinite] shadow-2xl">
                    <div class="w-10 h-10 rounded-full bg-red-500/20 flex items-center justify-center text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path></svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">Calories</div>
                        <div class="font-bold text-lg">165 Kcal</div>
                    </div>
                </div>
            </div>
            
        </div>
    </main>

    <!-- Popular Exercises Section -->
    <section class="py-24 px-6 relative z-10 border-t border-white/5 bg-[#030408]">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4">Popular Exercises</h2>
                    <p class="text-gray-400">Trending workouts designed for maximum results</p>
                </div>
                <a href="#" class="text-neon-cyan text-[10px] font-black uppercase tracking-[0.2em] hover:underline hidden md:block">Access All Protocols &rarr;</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card 1 -->
                <div class="glass-card group overflow-hidden cursor-pointer hover:border-white/20 transition-all duration-300">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Gym" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 grayscale group-hover:grayscale-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#000] to-transparent"></div>
                    </div>
                    <div class="p-6 relative z-10 -mt-10">
                        <div class="bg-white/10 backdrop-blur text-xs px-2 py-1 rounded inline-block mb-3 border border-white/5">Strength</div>
                        <h3 class="text-xl font-bold mb-1">Gym Training</h3>
                        <p class="text-sm text-gray-400">45 Min • High Intensity</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="glass-card group overflow-hidden cursor-pointer hover:border-white/20 transition-all duration-300">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1576678927484-cc907957088c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Treadmill" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 grayscale group-hover:grayscale-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#000] to-transparent"></div>
                    </div>
                    <div class="p-6 relative z-10 -mt-10">
                        <div class="bg-white/10 backdrop-blur text-xs px-2 py-1 rounded inline-block mb-3 border border-white/5">Cardio</div>
                        <h3 class="text-xl font-bold mb-1">Treadmill Run</h3>
                        <p class="text-sm text-gray-400">30 Min • Fat Burn</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="glass-card group overflow-hidden cursor-pointer hover:border-white/20 transition-all duration-300">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Yoga" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 grayscale group-hover:grayscale-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#000] to-transparent"></div>
                    </div>
                    <div class="p-6 relative z-10 -mt-10">
                        <div class="bg-white/10 backdrop-blur text-xs px-2 py-1 rounded inline-block mb-3 border border-white/5">Flexibility</div>
                        <h3 class="text-xl font-bold mb-1">Yoga Flow</h3>
                        <p class="text-sm text-gray-400">60 Min • Low Impact</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="glass-card group overflow-hidden cursor-pointer hover:border-white/20 transition-all duration-300">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1598971639058-fab3c3109a00?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Pushups" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 grayscale group-hover:grayscale-0">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#000] to-transparent"></div>
                    </div>
                    <div class="p-6 relative z-10 -mt-10">
                        <div class="bg-white/10 backdrop-blur text-xs px-2 py-1 rounded inline-block mb-3 border border-white/5">Bodyweight</div>
                        <h3 class="text-xl font-bold mb-1">Core Pushups</h3>
                        <p class="text-sm text-gray-400">20 Min • Medium</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

</body>
</html>
