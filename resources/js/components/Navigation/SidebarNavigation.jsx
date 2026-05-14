import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Home, LayoutDashboard, Dumbbell, Activity, LineChart, 
    Apple, Bot, Users, Settings, LogOut, FileText, LayoutGrid
} from 'lucide-react';
import { Heart } from 'lucide-react';

const navItems = [
    { name: 'Dashboard', icon: LayoutGrid, href: '/dashboard' },
    { name: 'Programs', icon: FileText, href: '/programs' },
    { name: 'Workouts', icon: Dumbbell, href: '/workout/1' },
    { name: 'Progress', icon: Activity, href: '/progress' },
    { name: 'Wellness', icon: Heart, href: '/wellness' },
    { name: 'Nutrition', icon: Apple, href: '#' },
    { name: 'AI Coach', icon: Bot, href: '/ai-coach' },
    { name: 'Settings', icon: Settings, href: '/profile' },
];

export default function SidebarNavigation({ currentPath = '/dashboard' }) {
    const [isHovered, setIsHovered] = useState(false);

    return (
        <>
            {/* Desktop Sidebar (Floating) */}
            <motion.div 
                className="fixed left-6 top-1/2 -translate-y-1/2 z-50 hidden lg:flex flex-col gap-2 bg-obsidian/40 backdrop-blur-3xl border border-white/5 rounded-[2.5rem] p-4 shadow-[0_0_50px_rgba(0,0,0,0.5)] transition-all duration-300"
                onMouseEnter={() => setIsHovered(true)}
                onMouseLeave={() => setIsHovered(false)}
                animate={{ width: isHovered ? 260 : 88 }}
            >
                <div className="flex items-center gap-4 mb-8 px-2 py-4 overflow-hidden">
                    <div className="min-w-12 h-12 rounded-full bg-cyan-glow shadow-[0_0_20px_rgba(0,242,255,0.4)] flex items-center justify-center font-black text-black text-xl tracking-tighter font-syncopate">
                        FN
                    </div>
                    <AnimatePresence>
                        {isHovered && (
                            <motion.span 
                                initial={{ opacity: 0, x: -10 }}
                                animate={{ opacity: 1, x: 0 }}
                                exit={{ opacity: 0, x: -10 }}
                                className="text-white font-black text-xl tracking-widest whitespace-nowrap font-syncopate uppercase"
                            >
                                FitNexus
                            </motion.span>
                        )}
                    </AnimatePresence>
                </div>

                <div className="flex flex-col gap-3 flex-1 overflow-y-auto no-scrollbar pb-4">
                    {navItems.map((item) => {
                        const isActive = currentPath.includes(item.href) && item.href !== '#';
                        const Icon = item.icon;
                        
                        return (
                            <a 
                                key={item.name} 
                                href={item.href}
                                className={`relative flex items-center gap-4 p-4 rounded-[1.5rem] group transition-all duration-300 overflow-hidden ${
                                    isActive 
                                    ? 'bg-cyan-glow text-black shadow-[0_0_30px_rgba(0,242,255,0.3)]' 
                                    : 'text-white/30 hover:bg-white/5 hover:text-white'
                                }`}
                            >
                                <div className="relative min-w-10 flex items-center justify-center z-10">
                                    <Icon size={24} strokeWidth={isActive ? 2.5 : 2} />
                                </div>

                                <AnimatePresence>
                                    {isHovered && (
                                        <motion.span 
                                            initial={{ opacity: 0, x: -10 }}
                                            animate={{ opacity: 1, x: 0 }}
                                            exit={{ opacity: 0, x: -10 }}
                                            className="whitespace-nowrap z-10 font-bold text-sm"
                                        >
                                            {item.name}
                                        </motion.span>
                                    )}
                                </AnimatePresence>
                            </a>
                        );
                    })}
                </div>

                <div className="mt-auto pt-6 border-t border-slate-50 overflow-hidden">
                    <form method="POST" action="/logout" id="logout-form">
                        <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')} />
                        <button type="submit" className="w-full flex items-center gap-4 p-4 rounded-[1.5rem] text-rose-500 hover:bg-rose-50 transition-colors group">
                            <div className="min-w-10 flex items-center justify-center">
                                <LogOut size={24} />
                            </div>
                            <AnimatePresence>
                                {isHovered && (
                                    <motion.span 
                                        initial={{ opacity: 0, x: -10 }}
                                        animate={{ opacity: 1, x: 0 }}
                                        exit={{ opacity: 0, x: -10 }}
                                        className="whitespace-nowrap font-bold text-sm"
                                    >
                                        Log Out
                                    </motion.span>
                                )}
                            </AnimatePresence>
                        </button>
                    </form>
                </div>
            </motion.div>

            {/* Mobile Bottom Navigation */}
            <div className="fixed bottom-6 left-6 right-6 z-50 lg:hidden bg-obsidian/80 backdrop-blur-3xl border border-white/5 px-8 py-5 flex justify-between items-center rounded-[2.5rem] shadow-2xl pb-6">
                {navItems.slice(0, 5).map((item) => {
                    const isActive = currentPath.includes(item.href) && item.href !== '#';
                    const Icon = item.icon;
                    return (
                        <a key={item.name} href={item.href} className={`relative flex flex-col items-center gap-1 transition-all ${isActive ? 'text-cyan-glow' : 'text-white/30'}`}>
                            <Icon size={26} strokeWidth={isActive ? 2.5 : 2} />
                            {isActive && (
                                <motion.div 
                                    layoutId="bubble"
                                    className="absolute -bottom-2 w-1.5 h-1.5 rounded-full bg-cyan-glow shadow-[0_0_10px_rgba(0,242,255,1)]"
                                    transition={{ type: 'spring', stiffness: 380, damping: 30 }}
                                />
                            )}
                        </a>
                    );
                })}
            </div>
        </>
    );
}
