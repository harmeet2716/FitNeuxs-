import React from 'react';
import { motion } from 'framer-motion';
import { Calendar, TrendingUp } from 'lucide-react';

const defaultPrograms = [
    { id: 1, name: 'Muscle Builder', duration: '14 Days', diff: 'Intermediate', equipment: 'Minimal', progress: 0.45, img: 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?auto=format&fit=crop&q=80&w=400' },
    { id: 2, name: 'Fat Burn Boost', duration: '8 Weeks', diff: 'Intermediate', equipment: 'Minimal', progress: 0.12, img: 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&q=80&w=400' },
    { id: 3, name: 'Powerbuilding', duration: '12 Weeks', diff: 'Advanced', equipment: 'Full Gym', progress: 0.68, img: 'https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?auto=format&fit=crop&q=80&w=400' },
    { id: 4, name: 'Yoga Basics', duration: '4 Weeks', diff: 'Beginner', equipment: 'Mat', progress: 0.90, img: 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&q=80&w=400' },
];

export default function DefaultPrograms() {
    return (
        <div className="grid gap-6 md:grid-cols-2">
            {defaultPrograms.map((prog, idx) => (
                <motion.div 
                    initial={{ opacity: 0, y: 10 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: idx * 0.1 }}
                    key={prog.id} 
                    className="bg-white rounded-[2.5rem] p-6 shadow-sm border border-black/5 group flex items-center gap-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                >
                    <div className="flex-1 space-y-4">
                        <h3 className="text-xl font-bold text-slate-900">{prog.name}</h3>
                        <div className="flex flex-wrap gap-4 text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <span className="flex items-center gap-1.5"><Calendar size={14} className="text-orange-500" /> {prog.duration}</span>
                            <span>• {prog.diff}</span>
                            <span>• {prog.equipment}</span>
                        </div>
                        <div className="flex items-center gap-4">
                            <button className="bg-orange-500 text-white rounded-full py-2.5 px-6 text-sm font-bold shadow-lg shadow-orange-500/20 hover:bg-orange-600 transition-colors">
                                View all
                            </button>
                            <div className="relative w-12 h-12 flex items-center justify-center">
                                <svg className="w-full h-full -rotate-90" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="40" fill="none" stroke="#F5F1ED" strokeWidth="12" />
                                    <circle 
                                        cx="50" cy="50" r="40" fill="none" 
                                        stroke="#FF8B3D" strokeWidth="12" 
                                        strokeLinecap="round" 
                                        strokeDasharray="251.2" strokeDashoffset={251.2 * (1 - prog.progress)}
                                    />
                                </svg>
                                <span className="absolute text-[10px] font-bold text-slate-900">{Math.round(prog.progress * 100)}%</span>
                            </div>
                        </div>
                    </div>
                    <div className="w-32 h-32 md:w-40 md:h-40 rounded-[2rem] overflow-hidden shadow-md">
                        <img src={prog.img} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                    </div>
                </motion.div>
            ))}
        </div>
    );
}
