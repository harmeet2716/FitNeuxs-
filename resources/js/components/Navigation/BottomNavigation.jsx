import React from 'react';
import { motion } from 'framer-motion';
import { Home, Dumbbell, Utensils, User, Zap } from 'lucide-react';

const BottomNavigation = ({ activeTab, onTabChange }) => {
    const tabs = [
        { id: 'dashboard', icon: Home, label: 'Orbit' },
        { id: 'workout', icon: Dumbbell, label: 'Pulse' },
        { id: 'coach', icon: Zap, label: 'Neural' },
        { id: 'nutrition', icon: Utensils, label: 'Bio' },
        { id: 'profile', icon: User, label: 'Link' },
    ];

    return (
        <div className="fixed bottom-8 left-1/2 -translate-x-1/2 z-[90] w-auto lg:hidden">
            <nav className="bg-white/5 backdrop-blur-3xl border border-white/10 rounded-[2rem] px-4 py-3 flex items-center gap-2 shadow-2xl">
                {tabs.map((tab) => {
                    const isActive = activeTab === tab.id;
                    const Icon = tab.icon;

                    return (
                        <button
                            key={tab.id}
                            onClick={() => onTabChange(tab.id)}
                            className="relative group p-4 rounded-2xl transition-all duration-500"
                        >
                            {isActive && (
                                <motion.div
                                    layoutId="activeTab"
                                    className="absolute inset-0 bg-cyan-glow rounded-2xl shadow-[0_0_20px_rgba(0,242,255,0.4)]"
                                    transition={{ type: "spring", bounce: 0.2, duration: 0.6 }}
                                />
                            )}
                            
                            <div className={`relative z-10 flex flex-col items-center gap-1 transition-colors duration-500 ${isActive ? 'text-black' : 'text-white/40 group-hover:text-white'}`}>
                                <Icon size={22} strokeWidth={isActive ? 2.5 : 2} />
                                <span className={`text-[8px] font-black uppercase tracking-[0.2em] transition-opacity duration-300 ${isActive ? 'opacity-100' : 'opacity-0 group-hover:opacity-100'}`}>
                                    {tab.label}
                                </span>
                            </div>

                            {!isActive && (
                                <div className="absolute -top-1 left-1/2 -translate-x-1/2 w-1 h-1 bg-cyan-glow rounded-full scale-0 group-hover:scale-100 transition-transform shadow-[0_0_8px_#00F2FF]"></div>
                            )}
                        </button>
                    );
                })}
            </nav>
        </div>
    );
};

export default BottomNavigation;
