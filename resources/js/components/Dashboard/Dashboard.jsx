import React from 'react';
import { motion } from 'framer-motion';
import { 
    Activity, Flame, Trophy, TrendingUp, Heart, BatteryCharging, 
    CalendarCheck, Target, ChevronRight, Search, Mic, MoreVertical, Plus, 
    Moon, Droplets, Zap, BrainCircuit
} from 'lucide-react';
import { 
    AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer,
    BarChart, Bar, Cell
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

const activityData = [
    { name: 'Sun', protein: 80, carbs: 40 },
    { name: 'Mon', protein: 110, carbs: 60 },
    { name: 'Tue', protein: 90, carbs: 70 },
    { name: 'Wed', protein: 100, carbs: 55 },
    { name: 'Thu', protein: 120, carbs: 85 },
    { name: 'Fri', protein: 85, carbs: 65 },
    { name: 'Sat', protein: 95, carbs: 75 },
];

const WellnessCard = ({ label, value, unit, icon: Icon, color, progress, trend }) => (
    <motion.div 
        whileHover={{ y: -10 }}
        className="bg-white/5 backdrop-blur-3xl rounded-[2.5rem] p-8 border border-white/10 shadow-[0_0_40px_rgba(0,0,0,0.4)] relative overflow-hidden group float-animation"
        style={{ animationDelay: `${Math.random() * 2}s` }}
    >
        <div className={`absolute -top-10 -right-10 w-32 h-32 blur-[60px] opacity-20 rounded-full bg-${color}-400 group-hover:opacity-40 transition-opacity`}></div>
        
        <div className="flex flex-col h-full relative z-10">
            <div className="flex justify-between items-start mb-8">
                <div className={`w-14 h-14 rounded-2xl bg-${color}-400/10 flex items-center justify-center text-${color}-400 shadow-inner border border-white/5`}>
                    <Icon size={24} className="drop-shadow-[0_0_8px_currentColor]" />
                </div>
                <div className="text-[10px] font-black uppercase tracking-widest px-3 py-1 bg-white/5 rounded-full text-white/40">
                    {trend}
                </div>
            </div>
            
            <div>
                <h4 className="text-white/40 text-xs font-black uppercase tracking-[0.2em] mb-2">{label}</h4>
                <div className="flex items-baseline gap-2">
                    <span className="text-4xl font-black tracking-tighter text-white">{value}</span>
                    <span className="text-sm font-bold text-white/30">{unit}</span>
                </div>
            </div>

            <div className="mt-8 space-y-3">
                <div className="flex justify-between text-[10px] font-black text-white/40 uppercase">
                    <span>Performance</span>
                    <span className={`text-${color}-400 font-black`}>{Math.round(progress * 100)}%</span>
                </div>
                <div className="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                    <motion.div 
                        initial={{ width: 0 }}
                        animate={{ width: `${progress * 100}%` }}
                        className={`h-full bg-${color}-400 shadow-[0_0_15px_rgba(var(--${color}-rgb),0.6)]`}
                    />
                </div>
            </div>
        </div>
    </motion.div>
);

export default function Dashboard({ userName = "Athlete" }) {
    return (
        <div className="w-full max-w-[1400px] mx-auto px-6 py-8 space-y-12 bg-black min-h-screen">
            {/* Minimal Mobile Header */}
            <div className="flex flex-col md:flex-row justify-between items-start md:items-end gap-8 pt-4">
                <div>
                    <div className="flex items-center gap-3 mb-3">
                        <div className="w-2 h-2 rounded-full bg-cyan-glow animate-pulse shadow-[0_0_8px_#00F2FF]"></div>
                        <span className="text-white/40 text-[10px] font-black uppercase tracking-[0.4em] font-syncopate">FITNEXUS PRIME v4.0</span>
                    </div>
                    <h1 className="text-6xl font-black text-white tracking-tighter leading-none">
                        Evening, <span className="text-cyan-glow italic underline decoration-cyan-glow/20">{userName}</span>
                    </h1>
                </div>
                
                <div className="relative group w-full md:w-[400px]">
                    <Search className="absolute left-6 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-cyan-glow transition-colors" size={20} />
                    <input 
                        type="text" 
                        placeholder="Scan weightless metrics..." 
                        className="w-full bg-white/5 border border-white/10 rounded-2xl py-5 pl-16 pr-14 text-white placeholder-white/20 focus:outline-none focus:ring-2 focus:ring-cyan-glow/20 focus:border-cyan-glow/50 transition-all shadow-2xl font-bold backdrop-blur-xl"
                    />
                    <button className="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-cyan-glow text-black flex items-center justify-center shadow-lg shadow-cyan-glow/30">
                        <Mic size={18} />
                    </button>
                </div>
            </div>

            {/* Quick Metrics Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <WellnessCard label="Recovery" value="84" unit="%" icon={BatteryCharging} color="emerald" progress={0.84} trend="+5.2%" />
                <WellnessCard label="Sleep Architecture" value="7.5" unit="Hrs" icon={Moon} color="purple" progress={0.75} trend="Optimal" />
                <WellnessCard label="Cardiac Strain" value="62" unit="Bpm" icon={Heart} color="rose" progress={0.62} trend="Low" />
                <WellnessCard label="Hydration Flux" value="2.8" unit="L" icon={Droplets} color="blue" progress={0.7} trend="Target 4.0L" />
            </div>

            {/* Hero Analytics & AI Insights */}
            <div className="grid grid-cols-1 lg:grid-cols-12 gap-10">
                {/* Dynamic Progress Chart */}
                <motion.div 
                    initial={{ opacity: 0, scale: 0.95 }}
                    animate={{ opacity: 1, scale: 1 }}
                    className="lg:col-span-8 bg-white/5 backdrop-blur-3xl rounded-[3rem] p-12 border border-white/10 shadow-2xl relative overflow-hidden"
                >
                    <div className="absolute top-0 right-0 w-96 h-96 bg-cyan-glow/5 blur-[120px] rounded-full"></div>
                    
                    <div className="flex justify-between items-center mb-16 relative z-10">
                        <div>
                            <h3 className="text-3xl font-black text-white tracking-tighter">Performance Flux</h3>
                            <p className="text-white/30 font-bold text-sm mt-2 uppercase tracking-widest">Real-time Biometric Variance</p>
                        </div>
                        <div className="flex bg-white/5 rounded-2xl p-1.5 border border-white/10 backdrop-blur-xl">
                            {['7D', '30D', '1Y'].map(t => (
                                <button key={t} className={`px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all ${t === '7D' ? 'bg-cyan-glow text-black shadow-lg shadow-cyan-glow/20' : 'text-white/30 hover:text-white'}`}>{t}</button>
                            ))}
                        </div>
                    </div>

                    <div className="h-[400px] w-full">
                        <ResponsiveContainer width="100%" height="100%">
                            <AreaChart data={weightData} margin={{ top: 0, right: 0, left: -30, bottom: 0 }}>
                                <defs>
                                    <linearGradient id="neonCyan" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="5%" stopColor="#00F2FF" stopOpacity={0.4}/>
                                        <stop offset="95%" stopColor="#00F2FF" stopOpacity={0}/>
                                    </linearGradient>
                                </defs>
                                <CartesianGrid strokeDasharray="3 3" vertical={false} stroke="rgba(255,255,255,0.03)" />
                                <XAxis dataKey="name" axisLine={false} tickLine={false} tick={{ fill: 'rgba(255,255,255,0.2)', fontSize: 11, fontWeight: 900 }} dy={20} />
                                <YAxis axisLine={false} tickLine={false} tick={{ fill: 'rgba(255,255,255,0.2)', fontSize: 11, fontWeight: 900 }} domain={['dataMin - 1', 'dataMax + 1']} />
                                <Tooltip 
                                    contentStyle={{ backgroundColor: 'rgba(10, 10, 11, 0.9)', borderRadius: '24px', border: '1px solid rgba(255,255,255,0.1)', padding: '20px', boxShadow: '0 20px 40px rgba(0,0,0,0.5)', backdropFilter: 'blur(20px)' }}
                                    itemStyle={{ color: '#00F2FF', fontWeight: 900, textTransform: 'uppercase', fontSize: '10px', letterSpacing: '0.1em' }}
                                />
                                <Area 
                                    type="monotone" 
                                    dataKey="value" 
                                    stroke="#00F2FF" 
                                    strokeWidth={4} 
                                    fillOpacity={1} 
                                    fill="url(#neonCyan)" 
                                    animationDuration={2000}
                                />
                            </AreaChart>
                        </ResponsiveContainer>
                    </div>
                </motion.div>

                {/* AI Recommendation Engine */}
                <div className="lg:col-span-4 space-y-8">
                    <div className="flex justify-between items-center">
                        <h3 className="text-xl font-black text-white tracking-tight font-syncopate uppercase text-xs">AI Insights</h3>
                        <BrainCircuit className="text-cyan-glow" size={24} />
                    </div>
                    
                    <div className="space-y-6">
                        {[
                            { title: 'Neural Recovery', desc: 'Optimize REM cycles with 10m meditation', color: 'purple', icon: Zap },
                            { title: 'Hydration Gap', desc: 'Current intake -1.2L vs optimal curve', color: 'blue', icon: Droplets },
                            { title: 'Anti-Gravity Sync', desc: 'Peak lightness detected for agility work', color: 'cyan', icon: Activity }
                        ].map((insight, i) => (
                            <motion.div 
                                key={i}
                                whileHover={{ x: 10, backgroundColor: 'rgba(255,255,255,0.08)' }}
                                className="p-6 bg-white/5 border border-white/10 rounded-[2.5rem] flex items-center gap-5 cursor-pointer group transition-colors backdrop-blur-xl"
                            >
                                <div className={`w-14 h-14 rounded-2xl bg-${insight.color}-500/10 flex items-center justify-center text-${insight.color}-500 group-hover:scale-110 transition-transform`}>
                                    <insight.icon size={24} />
                                </div>
                                <div>
                                    <h4 className="text-white font-black text-sm uppercase tracking-widest mb-1">{insight.title}</h4>
                                    <p className="text-white/30 text-xs font-bold leading-relaxed">{insight.desc}</p>
                                </div>
                            </motion.div>
                        ))}
                    </div>

                    {/* Featured Live Program Card */}
                    <div className="bg-cyan-glow rounded-[2.5rem] p-8 text-black shadow-[0_0_50px_rgba(0,242,255,0.3)] group cursor-pointer relative overflow-hidden float-animation">
                        <div className="absolute top-0 right-0 w-32 h-32 bg-white/30 blur-3xl rounded-full translate-x-10 -translate-y-10 group-hover:scale-150 transition-transform duration-700"></div>
                        <div className="relative z-10">
                            <h3 className="text-2xl font-black tracking-tighter mb-4 italic font-syncopate uppercase text-lg">Nexus-Protocol: Phase 2</h3>
                            <p className="text-black/70 text-sm font-bold mb-8">Initiate weightless resistance training sequences.</p>
                            <button className="w-full py-4 bg-black rounded-2xl text-white font-black text-[10px] uppercase tracking-[0.2em] shadow-xl group-hover:scale-105 transition-transform">Start Sequence</button>
                        </div>
                    </div>
                </div>
            </div>

            {/* Futuristic Floating FAB */}
            <motion.button 
                whileHover={{ scale: 1.1, rotate: 90 }}
                whileTap={{ scale: 0.9 }}
                className="fixed bottom-10 right-10 w-24 h-24 bg-cyan-glow text-black rounded-full shadow-[0_0_50px_rgba(0,242,255,0.5)] flex items-center justify-center z-50 border-8 border-obsidian group"
            >
                <Plus size={40} strokeWidth={4} className="group-hover:scale-125 transition-transform" />
            </motion.button>
        </div>
    );
}
