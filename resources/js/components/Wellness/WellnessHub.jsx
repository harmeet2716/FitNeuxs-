import React from 'react';
import { motion } from 'framer-motion';
import { 
    Moon, Wind, Droplets, Zap, ShieldCheck, 
    ChevronRight, ArrowUpRight, Smile, Coffee, 
    Waves, BrainCircuit, Activity
} from 'lucide-react';
import { 
    ResponsiveContainer, AreaChart, Area, XAxis, YAxis, 
    CartesianGrid, Tooltip 
} from 'recharts';

const sleepData = [
    { time: '22:00', deep: 0, light: 20 },
    { time: '00:00', deep: 40, light: 30 },
    { time: '02:00', deep: 80, light: 40 },
    { time: '04:00', deep: 90, light: 20 },
    { time: '06:00', deep: 30, light: 50 },
    { time: '08:00', deep: 0, light: 10 },
];

const WellnessMetric = ({ label, value, unit, icon: Icon, color, detail }) => (
    <motion.div 
        whileHover={{ y: -5, scale: 1.02 }}
        className="bg-[#0D0D0D] rounded-[2.5rem] p-8 border border-white/5 shadow-2xl relative overflow-hidden group transition-all"
    >
        <div className={`absolute -top-10 -right-10 w-32 h-32 blur-[60px] opacity-10 rounded-full bg-${color}-500 group-hover:opacity-30 transition-opacity`}></div>
        
        <div className="flex justify-between items-start mb-10 relative z-10">
            <div className={`w-14 h-14 rounded-2xl flex items-center justify-center bg-${color}-500/10 text-${color}-500 shadow-inner`}>
                <Icon size={24} />
            </div>
            <div className={`flex items-center gap-1 text-[10px] font-black text-${color}-500 bg-${color}-500/10 px-3 py-1.5 rounded-full uppercase tracking-[0.2em]`}>
                <ArrowUpRight size={12} />
                {detail}
            </div>
        </div>
        
        <div className="relative z-10">
            <h4 className="text-white/40 text-[10px] font-black uppercase tracking-[0.3em] mb-2">{label}</h4>
            <div className="flex items-baseline gap-2">
                <span className="text-4xl font-black tracking-tighter text-white">{value}</span>
                <span className="text-sm font-bold text-white/30">{unit}</span>
            </div>
        </div>
    </motion.div>
);

export default function WellnessHub() {
    return (
        <div className="w-full max-w-[1400px] mx-auto px-6 py-8 space-y-12 bg-black min-h-screen">
            {/* Wellness Hero Section */}
            <div className="flex flex-col md:flex-row justify-between items-end gap-10 pt-4">
                <div>
                    <div className="flex items-center gap-3 mb-4">
                        <span className="px-4 py-1.5 bg-orange-500 text-white rounded-full text-[10px] font-black uppercase tracking-[0.3em] shadow-[0_0_20px_rgba(255,92,0,0.4)]">Bio-Sync Active</span>
                        <span className="text-white/20 text-xs font-black uppercase tracking-[0.2em]">System Status: Optimal</span>
                    </div>
                    <h1 className="text-7xl font-black text-white tracking-tighter leading-none italic">
                        Holistic <span className="text-orange-500 not-italic">Vitals</span>
                    </h1>
                    <p className="text-white/30 font-bold mt-6 text-xl max-w-xl leading-relaxed">Neural analysis of your physiological architecture and recovery cycles.</p>
                </div>
                <div className="flex gap-4">
                    <button className="px-10 py-5 bg-white text-black rounded-2xl font-black text-xs uppercase tracking-[0.3em] hover:scale-105 transition-transform shadow-2xl">Analyze Bio-Path</button>
                    <button className="w-16 h-16 bg-[#0D0D0D] border border-white/5 rounded-2xl flex items-center justify-center text-white/40 hover:text-orange-500 transition-all shadow-xl">
                        <Waves size={28} />
                    </button>
                </div>
            </div>

            {/* Core Biometrics Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <WellnessMetric label="Neural Depth" value="8h 45m" unit="Rest" icon={Moon} color="purple" detail="+12% Delta" />
                <WellnessMetric label="Cellular Hydration" value="2.4" unit="L" icon={Droplets} color="blue" detail="Target 3.5L" />
                <WellnessMetric label="Systemic Stress" value="24" unit="V" icon={Wind} color="emerald" detail="Vagal Tone High" />
                <WellnessMetric label="Metabolic Energy" value="85" unit="%" icon={Zap} color="orange" detail="Peak Capacity" />
            </div>

            {/* In-depth Analysis Section */}
            <div className="grid grid-cols-1 lg:grid-cols-12 gap-10">
                {/* Sleep Cycles Chart */}
                <div className="lg:col-span-8 bg-[#0D0D0D] rounded-[3rem] p-12 border border-white/5 shadow-2xl relative overflow-hidden">
                    <div className="absolute top-0 right-0 w-96 h-96 bg-purple-500/5 blur-[120px] rounded-full"></div>
                    
                    <div className="flex justify-between items-center mb-16 relative z-10">
                        <div>
                            <h3 className="text-3xl font-black text-white tracking-tighter">Sleep Architecture</h3>
                            <p className="text-white/30 font-bold text-sm mt-2 uppercase tracking-widest">REM vs Deep Phase Monitoring</p>
                        </div>
                        <div className="flex bg-white/5 rounded-2xl p-1.5 border border-white/5 backdrop-blur-xl">
                            <button className="px-8 py-3 rounded-xl bg-purple-500 text-white text-xs font-black shadow-lg shadow-purple-500/30 uppercase tracking-widest">Delta Wave</button>
                            <button className="px-8 py-3 rounded-xl text-white/30 text-xs font-black hover:text-white uppercase tracking-widest">Readiness</button>
                        </div>
                    </div>

                    <div className="h-[350px] w-full">
                        <ResponsiveContainer width="100%" height="100%">
                            <AreaChart data={sleepData} margin={{ top: 0, right: 0, left: -20, bottom: 0 }}>
                                <defs>
                                    <linearGradient id="deepSleep" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="5%" stopColor="#8B5CF6" stopOpacity={0.4}/>
                                        <stop offset="95%" stopColor="#8B5CF6" stopOpacity={0}/>
                                    </linearGradient>
                                    <linearGradient id="lightSleep" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="5%" stopColor="#3B82F6" stopOpacity={0.2}/>
                                        <stop offset="95%" stopColor="#3B82F6" stopOpacity={0}/>
                                    </linearGradient>
                                </defs>
                                <CartesianGrid strokeDasharray="3 3" vertical={false} stroke="rgba(255,255,255,0.03)" />
                                <XAxis dataKey="time" axisLine={false} tickLine={false} tick={{ fill: 'rgba(255,255,255,0.2)', fontSize: 11, fontWeight: 900 }} dy={20} />
                                <YAxis axisLine={false} tickLine={false} tick={{ fill: 'rgba(255,255,255,0.2)', fontSize: 11, fontWeight: 900 }} />
                                <Tooltip 
                                    contentStyle={{ backgroundColor: '#0D0D0D', borderRadius: '24px', border: '1px solid rgba(255,255,255,0.1)', padding: '20px' }}
                                />
                                <Area type="monotone" dataKey="deep" stroke="#8B5CF6" strokeWidth={5} fillOpacity={1} fill="url(#deepSleep)" />
                                <Area type="monotone" dataKey="light" stroke="#3B82F6" strokeWidth={5} fillOpacity={1} fill="url(#lightSleep)" />
                            </AreaChart>
                        </ResponsiveContainer>
                    </div>

                    <div className="grid grid-cols-2 gap-10 mt-16 pt-10 border-t border-white/5">
                        <div className="flex items-center gap-6">
                            <div className="w-16 h-16 rounded-[1.5rem] bg-purple-500/10 text-purple-500 flex items-center justify-center shadow-inner">
                                <Smile size={28} />
                            </div>
                            <div>
                                <h4 className="text-white font-black text-sm uppercase tracking-[0.2em]">Mental Clarity</h4>
                                <p className="text-white/30 font-bold text-xs mt-1">High focus potential detected</p>
                            </div>
                        </div>
                        <div className="flex items-center gap-6">
                            <div className="w-16 h-16 rounded-[1.5rem] bg-orange-500/10 text-orange-500 flex items-center justify-center shadow-inner">
                                <Coffee size={28} />
                            </div>
                            <div>
                                <h4 className="text-white font-black text-sm uppercase tracking-[0.2em]">Bio-Caffeine Cap</h4>
                                <p className="text-white/30 font-bold text-xs mt-1">Metabolic limit: 180mg remaining</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Right Side: Mind & HRV */}
                <div className="lg:col-span-4 space-y-10">
                    {/* Stress/BPM Dark Neon Card */}
                    <div className="bg-[#0D0D0D] rounded-[3rem] p-10 text-white relative overflow-hidden border border-white/5 group shadow-2xl">
                        <div className="absolute top-0 right-0 w-48 h-48 bg-orange-500/10 blur-[80px] rounded-full group-hover:bg-orange-500/20 transition-all duration-700"></div>
                        <div className="relative z-10">
                            <h3 className="text-[10px] font-black uppercase tracking-[0.4em] mb-10 text-white/30">Vagal Tone Analysis</h3>
                            <div className="flex items-center gap-8 mb-10">
                                <div className="text-7xl font-black tracking-tighter italic glow-orange">64</div>
                                <div>
                                    <div className="text-orange-500 font-black text-sm uppercase tracking-widest">Synchronized</div>
                                    <div className="text-xs font-bold text-white/20">HRV Stability</div>
                                </div>
                            </div>
                            <div className="flex gap-1.5 h-12 items-end mb-10">
                                {[40, 70, 45, 90, 65, 30, 80, 50, 60, 40, 70, 50, 80, 40, 60].map((h, i) => (
                                    <motion.div 
                                        key={i}
                                        initial={{ height: 0 }}
                                        animate={{ height: `${h}%` }}
                                        transition={{ delay: i * 0.05, duration: 1, repeat: Infinity, repeatType: 'reverse' }}
                                        className="flex-1 bg-white/10 rounded-full group-hover:bg-orange-500/40 transition-colors"
                                    />
                                ))}
                            </div>
                            <button className="w-full py-5 bg-white/5 hover:bg-orange-500 hover:text-white rounded-2xl text-white/60 font-black text-[10px] uppercase tracking-[0.3em] border border-white/10 transition-all shadow-xl">Initiate Coherence Breathing</button>
                        </div>
                    </div>

                    {/* AI Wellness Routine */}
                    <div className="bg-[#0D0D0D] rounded-[3rem] p-10 shadow-2xl border border-white/5 space-y-8">
                        <div className="flex justify-between items-center">
                            <h3 className="text-xl font-black text-white tracking-tight uppercase tracking-widest">Protocol Sync</h3>
                            <BrainCircuit className="text-orange-500" size={24} />
                        </div>
                        <div className="space-y-4">
                            {[
                                { title: 'Neural Reset', time: '07:30 AM', icon: Zap, color: 'orange' },
                                { title: 'Deep Coherence', time: '12:00 PM', icon: Wind, color: 'emerald' },
                                { title: 'Delta Prep', time: '21:30 PM', icon: Moon, color: 'purple' }
                            ].map((item, i) => (
                                <div key={i} className="flex items-center justify-between p-5 bg-white/5 rounded-2xl hover:bg-white/10 transition-all group cursor-pointer border border-white/5">
                                    <div className="flex items-center gap-5">
                                        <div className={`w-12 h-12 rounded-xl bg-${item.color}-500/10 flex items-center justify-center text-${item.color}-500 group-hover:scale-110 transition-transform`}>
                                            <item.icon size={20} />
                                        </div>
                                        <div>
                                            <h4 className="text-white font-black text-sm">{item.title}</h4>
                                            <p className="text-white/20 text-[10px] font-bold uppercase tracking-widest">{item.time}</p>
                                        </div>
                                    </div>
                                    <ChevronRight className="text-white/10 group-hover:text-white transition-colors" size={20} />
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
