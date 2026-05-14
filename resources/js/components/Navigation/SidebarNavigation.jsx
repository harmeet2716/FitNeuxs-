import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Dumbbell, BarChart3, Apple, Sparkles, CreditCard, 
    User, Settings, LogOut, ChevronRight
} from 'lucide-react';

const SidebarNavigation = ({ currentPath = '/dashboard' }) => {
    const [isHovered, setIsHovered] = useState(false);

    const navGroups = [
        {
            title: 'Core Logs',
            items: [
                { name: 'Workout Dashboard', icon: Dumbbell, href: '/dashboard' },
                { name: 'Metrics', icon: BarChart3, href: '/progress' },
                { name: 'Nutrition', icon: Apple, href: '/nutrition' },
            ]
        },
        {
            title: 'Premium',
            items: [
                { name: 'AI Coach', icon: Sparkles, href: '/ai-coach', pulse: true },
                { name: 'Pricing', icon: CreditCard, href: '/pricing' },
            ]
        },
        {
            title: 'User Sync',
            items: [
                { name: 'Profile', icon: User, href: '/profile' },
                { name: 'Settings', icon: Settings, href: '/settings' },
            ]
        }
    ];

    return (
        <motion.aside 
            initial={false}
            onMouseEnter={() => setIsHovered(true)}
            onMouseLeave={() => setIsHovered(false)}
            animate={{ width: isHovered ? '280px' : '88px' }}
            className="fixed left-0 top-0 h-screen bg-black/20 backdrop-blur-xl border-r border-white/10 flex flex-col p-6 shadow-[10px_0_30px_rgba(0,0,0,0.5)] z-[100] transition-all duration-500 ease-out overflow-hidden"
        >
            {/* Brand Logo */}
            <div className="flex items-center gap-4 mb-12 px-2 h-12">
                <div className="min-w-[40px] h-10 rounded-xl bg-cyan-glow flex items-center justify-center shadow-[0_0_20px_rgba(0,242,255,0.4)]">
                    <span className="font-black text-black text-sm tracking-tighter">FN</span>
                </div>
                <AnimatePresence>
                    {isHovered && (
                        <motion.span 
                            initial={{ opacity: 0, x: -10 }}
                            animate={{ opacity: 1, x: 0 }}
                            exit={{ opacity: 0, x: -10 }}
                            className="text-white font-black text-lg tracking-widest whitespace-nowrap font-syncopate"
                        >
                            FITNEXUS
                        </motion.span>
                    )}
                </AnimatePresence>
            </div>

            {/* Navigation Groups */}
            <div className="flex flex-col gap-10 flex-1 overflow-y-auto no-scrollbar">
                {navGroups.map((group, gIdx) => (
                    <div key={gIdx} className="space-y-4">
                        <AnimatePresence>
                            {isHovered && (
                                <motion.h3 
                                    initial={{ opacity: 0 }}
                                    animate={{ opacity: 1 }}
                                    exit={{ opacity: 0 }}
                                    className="px-4 text-[10px] font-black text-white/20 uppercase tracking-[0.3em] whitespace-nowrap"
                                >
                                    {group.title}
                                </motion.h3>
                            )}
                        </AnimatePresence>
                        
                        <div className="space-y-2">
                            {group.items.map((item) => {
                                const isActive = currentPath === item.href;
                                const Icon = item.icon;

                                return (
                                    <a 
                                        key={item.name}
                                        href={item.href}
                                        className={`relative flex items-center gap-4 p-4 rounded-2xl group transition-all duration-300 ${
                                            isActive 
                                            ? 'text-cyan-glow' 
                                            : 'text-white/40 hover:text-white hover:bg-white/5 hover:translate-x-1'
                                        }`}
                                    >
                                        {/* Active Indicator Line */}
                                        {isActive && (
                                            <motion.div 
                                                layoutId="activeIndicator"
                                                className="absolute left-0 w-1 h-6 bg-cyan-glow rounded-full shadow-[0_0_15px_#00F2FF]"
                                                initial={{ opacity: 0 }}
                                                animate={{ opacity: 1 }}
                                            />
                                        )}

                                        <div className={`relative min-w-[24px] flex items-center justify-center ${item.pulse ? 'group-hover:animate-pulse' : ''}`}>
                                            <Icon 
                                                size={22} 
                                                strokeWidth={isActive ? 2.5 : 2}
                                                className={isActive ? 'drop-shadow-[0_0_8px_#00F2FF]' : ''}
                                            />
                                        </div>

                                        <AnimatePresence>
                                            {isHovered && (
                                                <motion.span 
                                                    initial={{ opacity: 0, x: -10 }}
                                                    animate={{ opacity: 1, x: 0 }}
                                                    exit={{ opacity: 0, x: -10 }}
                                                    className="whitespace-nowrap font-bold text-sm tracking-tight"
                                                >
                                                    {item.name}
                                                </motion.span>
                                            )}
                                        </AnimatePresence>

                                        {isActive && isHovered && (
                                            <motion.div 
                                                initial={{ opacity: 0 }}
                                                animate={{ opacity: 1 }}
                                                className="ml-auto"
                                            >
                                                <ChevronRight size={14} className="text-cyan-glow" />
                                            </motion.div>
                                        )}
                                    </a>
                                );
                            })}
                        </div>
                    </div>
                ))}
            </div>

            {/* Logout - Pinned to Bottom */}
            <div className="mt-auto pt-6 border-t border-white/5">
                <form method="POST" action="/logout" id="logout-form">
                    <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')} />
                    <button 
                        type="submit"
                        className="w-full flex items-center gap-4 p-4 rounded-2xl text-rose-500/60 hover:text-rose-400 hover:bg-rose-500/5 transition-all group"
                    >
                        <div className="min-w-[24px] flex items-center justify-center">
                            <LogOut size={22} />
                        </div>
                        <AnimatePresence>
                            {isHovered && (
                                <motion.span 
                                    initial={{ opacity: 0, x: -10 }}
                                    animate={{ opacity: 1, x: 0 }}
                                    exit={{ opacity: 0, x: -10 }}
                                    className="whitespace-nowrap font-bold text-sm tracking-tight"
                                >
                                    Logout Session
                                </motion.span>
                            )}
                        </AnimatePresence>
                    </button>
                </form>
            </div>
        </motion.aside>
    );
};

export default SidebarNavigation;
