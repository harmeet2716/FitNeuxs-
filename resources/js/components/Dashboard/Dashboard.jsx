import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Activity, Flame, Trophy, TrendingUp, Heart, BatteryCharging, 
    CalendarCheck, Target, ChevronRight, Search, Mic, MoreVertical, Plus, 
    Moon, Droplets, Zap, BrainCircuit
} from 'lucide-react';
import { 
    AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer
} from 'recharts';

const weightData = [
    { name: 'Mon', value: 85.2 },
    { name: 'Tue', value: 85.0 },
    { name: 'Wed', value: 84.8 },
    { name: 'Thu', value: 85.1 },
    { name: 'Fri', value: 84.7 },
    { name: 'Sat', value: 84.5 },
    { name: 'Sun', value: 84.3 },
];

const wisdomFeed = [
    "Weightless Wisdom: Your 7-day kinetic trend shows optimal recovery. Push explosive power today.",
    "Weightless Wisdom: Micro-nutrient absorption is peaking. Prioritize magnesium post-workout.",
    "Weightless Wisdom: Anti-gravity sync established. Central nervous system is primed for heavy loads.",
];

// Reusable SVG Ring Component
const Ring = ({ radius, stroke, color, progress, label, icon: Icon }) => {
    const circumference = 2 * Math.PI * radius;
    const offset = circumference - (progress / 100) * circumference;
    
    return (
        <svg className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" width={radius * 2 + stroke * 2} height={radius * 2 + stroke * 2}>
            {/* Background Ring */}
            <circle
                stroke="rgba(255,255,255,0.05)"
                strokeWidth={stroke}
                fill="transparent"
                r={radius}
                cx={radius + stroke}
                cy={radius + stroke}
            />
            {/* Progress Ring */}
            <circle
                stroke={color}
                strokeWidth={stroke}
                strokeLinecap="round"
                fill="transparent"
                r={radius}
                cx={radius + stroke}
                cy={radius + stroke}
                style={{
                    strokeDasharray: circumference,
                    strokeDashoffset: offset,
                    transition: 'stroke-dashoffset 1s ease-in-out',
                    filter: `drop-shadow(0 0 8px ${color})`,
                    transformOrigin: '50% 50%',
                    transform: 'rotate(-90deg)'
                }}
            />
        </svg>
    );
};

const TripleRingCluster = ({ caloriesLeft, steps, micros }) => (
    <div className="relative flex items-center justify-center h-72 w-72 mx-auto animate-float">
        {/* Glow behind the rings */}
        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-40 h-40 bg-cyan-500/15 rounded-full blur-[50px]"></div>
        
        {/* Calorie Orbit: Large (Neon Cyan) */}
        <Ring radius={110} stroke={8} color="#00F2FF" progress={75} />
        {/* Kinetic Ring: Medium (Neon Green) */}
        <Ring radius={85} stroke={8} color="#22C55E" progress={60} />
        {/* Micro-Nutrient Ring: Small (Soft Violet) */}
        <Ring radius={60} stroke={8} color="#A78BFA" progress={90} />

        {/* Center Display */}
        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center justify-center text-center z-10">
            <span className="text-3xl font-black text-white tracking-tighter drop-shadow-[0_0_10px_#00F2FF]">{caloriesLeft}</span>
            <span className="text-[9px] font-bold text-cyan-400 uppercase tracking-[0.2em] mt-1">Calories Left</span>
        </div>
    </div>
);

const ModalityCard = ({ title, subtitle, colorClass, glowClass, imageSrc, delay }) => (
    <div 
        className={`group relative overflow-hidden rounded-[2rem] bg-white/5 border border-white/10 backdrop-blur-xl transition-all duration-500 animate-float`}
        style={{ 
            animationDelay: `${delay}s`,
            boxShadow: '0 0 15px rgba(0,0,0,0.5)'
        }}
        onMouseEnter={(e) => {
            e.currentTarget.style.boxShadow = `0 0 40px ${glowClass}`;
            e.currentTarget.style.transform = 'translateY(-10px)';
        }}
        onMouseLeave={(e) => {
            e.currentTarget.style.boxShadow = '0 0 15px rgba(0,0,0,0.5)';
            e.currentTarget.style.transform = 'translateY(0px)';
        }}
    >
        <div className={`absolute -top-10 -left-10 w-40 h-40 ${colorClass} blur-[50px] opacity-0 group-hover:opacity-100 transition-opacity duration-700`}></div>
        
        <img src={imageSrc} className="w-full h-48 object-cover opacity-50 mix-blend-overlay transition-all duration-700 group-hover:opacity-80 group-hover:scale-105" alt={title} />
        
        <div className="absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 via-black/40 to-transparent">
            <h3 className="text-white font-bold tracking-widest uppercase text-sm drop-shadow-lg">{title}</h3>
            <p className={`text-[10px] font-bold mt-1 uppercase tracking-widest opacity-90`} style={{ color: glowClass }}>{subtitle}</p>
        </div>
    </div>
);

export default function Dashboard({ userName = "Athlete" }) {
    const [wisdomIndex, setWisdomIndex] = useState(0);

    useEffect(() => {
        const interval = setInterval(() => {
            setWisdomIndex(prev => (prev + 1) % wisdomFeed.length);
        }, 5000);
        return () => clearInterval(interval);
    }, []);

    const trainingModalities = [
        { title: 'Yoga Flow', subtitle: 'Recovery & Flexibility', colorClass: 'bg-teal-500/20', glowClass: 'rgba(45,212,191,0.5)', imageSrc: 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=400&q=80', delay: 0 },
        { title: 'Endurance', subtitle: 'Runner Light Trails', colorClass: 'bg-cyan-500/20', glowClass: 'rgba(34,211,238,0.5)', imageSrc: 'https://images.unsplash.com/photo-1530143311094-34d807799e8f?auto=format&fit=crop&w=400&q=80', delay: 0.1 },
        { title: 'Explosive', subtitle: 'High-Contrast Jump', colorClass: 'bg-lime-500/20', glowClass: 'rgba(163,230,53,0.5)', imageSrc: 'https://images.unsplash.com/photo-1599058917212-d750089bc07e?auto=format&fit=crop&w=400&q=80', delay: 0.2 },
        { title: 'Strength', subtitle: 'Glowing Dumbbell', colorClass: 'bg-blue-500/20', glowClass: 'rgba(96,165,250,0.5)', imageSrc: 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?auto=format&fit=crop&w=400&q=80', delay: 0.3 },
        { title: 'Bodybuilding', subtitle: 'Muscular Silhouette', colorClass: 'bg-fuchsia-500/20', glowClass: 'rgba(232,121,249,0.5)', imageSrc: 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=400&q=80', delay: 0.4 },
        { title: 'Powerlifting', subtitle: 'Heavy Barbell Plates', colorClass: 'bg-red-600/20', glowClass: 'rgba(239,68,68,0.5)', imageSrc: 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=400&q=80', delay: 0.5 },
        { title: 'Hybrid', subtitle: 'Cross-Training Action', colorClass: 'bg-pink-500/20', glowClass: 'rgba(236,72,153,0.5)', imageSrc: 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&w=400&q=80', delay: 0.6 },
        { title: 'Powerbuilding', subtitle: 'Solid Heavy Lifter', colorClass: 'bg-yellow-500/20', glowClass: 'rgba(250,204,21,0.5)', imageSrc: 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=400&q=80', delay: 0.7 },
    ];

    return (
        <div className="w-full max-w-[1600px] mx-auto px-4 lg:px-8 py-10 bg-[#0A0A0B] min-h-screen text-slate-100 font-sans overflow-x-hidden">
            
            {/* Top Navigation & Profile Status */}
            <div className="flex justify-between items-center mb-16">
                <div>
                    <h1 className="text-[10px] uppercase tracking-[0.5em] text-white/40 mb-2">Zero-G Command Center</h1>
                    <h2 className="text-4xl font-light tracking-tight text-white/90">
                        Welcome, <span className="font-bold text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.5)]">{userName}</span>
                    </h2>
                </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                {/* Left Column: Vitality Orbit & Coach Feed */}
                <div className="lg:col-span-4 flex flex-col gap-10">
                    {/* The Vitality Orbit */}
                    <div className="bg-white/5 backdrop-blur-xl rounded-[3rem] p-10 border border-white/10 shadow-[0_0_30px_rgba(0,0,0,0.5)]">
                        <div className="text-center mb-8">
                            <h3 className="text-xs uppercase tracking-[0.3em] font-bold text-white/60">Vitality Orbit</h3>
                        </div>
                        <TripleRingCluster caloriesLeft="1,840" steps="8,200" micros="90%" />
                        
                        <div className="flex justify-between items-center mt-12 text-[10px] uppercase tracking-widest font-bold">
                            <div className="flex flex-col items-center">
                                <span className="text-cyan-400 drop-shadow-[0_0_5px_#00F2FF]">Caloric</span>
                                <span className="text-white/40 mt-1">75% Sync</span>
                            </div>
                            <div className="flex flex-col items-center">
                                <span className="text-green-400 drop-shadow-[0_0_5px_#22C55E]">Kinetic</span>
                                <span className="text-white/40 mt-1">60% Sync</span>
                            </div>
                            <div className="flex flex-col items-center">
                                <span className="text-violet-400 drop-shadow-[0_0_5px_#A78BFA]">Micro</span>
                                <span className="text-white/40 mt-1">90% Sync</span>
                            </div>
                        </div>
                    </div>

                    {/* AI Coach Feed */}
                    <div className="bg-white/5 backdrop-blur-xl rounded-[2rem] p-6 border border-white/10 shadow-[0_0_30px_rgba(0,0,0,0.5)] animate-float" style={{ animationDelay: '1s' }}>
                        <div className="flex items-center gap-3 mb-4">
                            <div className="w-8 h-8 rounded-full bg-cyan-500/20 flex items-center justify-center text-cyan-400 shadow-[0_0_10px_rgba(34,211,238,0.4)]">
                                <BrainCircuit size={16} />
                            </div>
                            <h3 className="text-xs uppercase tracking-[0.2em] font-bold text-white/60">AI Coach Feed</h3>
                        </div>
                        
                        <div className="h-16 overflow-hidden relative">
                            <AnimatePresence mode="wait">
                                <motion.p
                                    key={wisdomIndex}
                                    initial={{ opacity: 0, y: 20 }}
                                    animate={{ opacity: 1, y: 0 }}
                                    exit={{ opacity: 0, y: -20 }}
                                    transition={{ duration: 0.5 }}
                                    className="text-sm font-light leading-relaxed text-white/80 absolute"
                                >
                                    {wisdomFeed[wisdomIndex]}
                                </motion.p>
                            </AnimatePresence>
                        </div>
                    </div>
                </div>

                {/* Right Column: Training Grid & Metrics */}
                <div className="lg:col-span-8 flex flex-col gap-10">
                    
                    {/* Training Modalities Grid */}
                    <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
                        {trainingModalities.map((modality, idx) => (
                            <ModalityCard key={idx} {...modality} />
                        ))}
                    </div>

                    {/* The "Float" Metrics Pillar */}
                    <div className="bg-white/5 backdrop-blur-xl rounded-[3rem] p-10 border border-white/10 shadow-[0_0_30px_rgba(0,0,0,0.5)] flex-1 animate-float" style={{ animationDelay: '0.5s' }}>
                        <div className="flex justify-between items-center mb-10">
                            <div>
                                <h3 className="text-sm uppercase tracking-[0.2em] font-bold text-white/80">Mass Fluctuation</h3>
                                <p className="text-[10px] uppercase tracking-widest text-cyan-400 mt-1">7-Day Kinetic Trend</p>
                            </div>
                            <div className="px-4 py-2 bg-white/5 rounded-full border border-white/10 text-[10px] uppercase tracking-widest font-bold text-white/50">
                                Last 7 Days
                            </div>
                        </div>

                        <div className="h-[250px] w-full">
                            <ResponsiveContainer width="100%" height="100%">
                                <AreaChart data={weightData} margin={{ top: 10, right: 0, left: -30, bottom: 0 }}>
                                    <defs>
                                        <linearGradient id="neonCyanGlow" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="5%" stopColor="#00F2FF" stopOpacity={0.5}/>
                                            <stop offset="95%" stopColor="#00F2FF" stopOpacity={0}/>
                                        </linearGradient>
                                    </defs>
                                    <CartesianGrid strokeDasharray="3 3" vertical={false} stroke="rgba(255,255,255,0.05)" />
                                    <XAxis dataKey="name" axisLine={false} tickLine={false} tick={{ fill: 'rgba(255,255,255,0.3)', fontSize: 10, fontWeight: 700 }} dy={10} />
                                    <YAxis axisLine={false} tickLine={false} tick={{ fill: 'rgba(255,255,255,0.3)', fontSize: 10, fontWeight: 700 }} domain={['dataMin - 1', 'dataMax + 1']} />
                                    <Tooltip 
                                        contentStyle={{ backgroundColor: 'rgba(10, 10, 11, 0.9)', borderRadius: '16px', border: '1px solid rgba(255,255,255,0.1)', padding: '12px', boxShadow: '0 0 20px rgba(0,242,255,0.2)', backdropFilter: 'blur(20px)' }}
                                        itemStyle={{ color: '#00F2FF', fontWeight: 800, fontSize: '12px' }}
                                    />
                                    <Area 
                                        type="monotone" 
                                        dataKey="value" 
                                        stroke="#00F2FF" 
                                        strokeWidth={3} 
                                        fillOpacity={1} 
                                        fill="url(#neonCyanGlow)" 
                                        style={{ filter: 'drop-shadow(0 0 8px rgba(0,242,255,0.5))' }}
                                    />
                                </AreaChart>
                            </ResponsiveContainer>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    );
}
