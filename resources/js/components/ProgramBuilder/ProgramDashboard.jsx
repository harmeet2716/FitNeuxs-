import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Search, Mic, Settings, ChevronRight } from 'lucide-react';
import DefaultPrograms from './DefaultPrograms';
import CustomProgramBuilder from './CustomProgramBuilder';

export default function ProgramDashboard() {
    const [activeTab, setActiveTab] = useState('default');
    const [filter, setFilter] = useState('all');

    return (
        <div className="w-full max-w-[1200px] mx-auto px-4 py-8 space-y-10">
            {/* Header with Search and Settings */}
            <div className="flex flex-col gap-8">
                <div className="flex justify-between items-center">
                    <button className="w-12 h-12 rounded-full bg-white border border-black/5 flex items-center justify-center shadow-sm">
                        <ChevronRight className="rotate-180" size={20} />
                    </button>
                    <h1 className="text-2xl font-bold text-slate-900">Programs</h1>
                    <button className="w-12 h-12 rounded-full bg-white border border-black/5 flex items-center justify-center shadow-sm">
                        <Settings size={20} className="text-slate-400" />
                    </button>
                </div>

                <div className="relative group">
                    <input 
                        type="text" 
                        placeholder="Asked anything about your programs" 
                        className="w-full bg-white border border-black/5 rounded-full py-5 pl-8 pr-14 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all shadow-sm font-medium"
                    />
                    <button className="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center">
                        <Mic size={18} />
                    </button>
                </div>
            </div>

            {/* Content Filters */}
            <div className="flex justify-between items-center">
                <h2 className="text-xl font-bold text-slate-900">Choose a plan</h2>
                <button className="text-slate-400 font-bold text-sm hover:text-orange-500">View All</button>
            </div>

            <div className="flex gap-4 overflow-x-auto pb-4 no-scrollbar">
                {[
                    { id: 'all', name: 'All Program' },
                    { id: 'intermediate', name: 'Intermediate' },
                    { id: 'advanced', name: 'Advanced' }
                ].map((item) => (
                    <button
                        key={item.id}
                        onClick={() => setFilter(item.id)}
                        className={`px-8 py-3.5 rounded-full font-bold text-sm whitespace-nowrap transition-all ${
                            filter === item.id 
                            ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/25' 
                            : 'bg-white text-slate-400 border border-black/5'
                        }`}
                    >
                        {item.name}
                    </button>
                ))}
            </div>

            {/* Featured Card */}
            <motion.div 
                whileHover={{ y: -10 }}
                className="relative rounded-[3rem] overflow-hidden min-h-[380px] shadow-2xl group cursor-pointer"
            >
                <img 
                    src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&q=80&w=2070" 
                    className="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                    alt="Featured"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                <div className="absolute top-6 right-6">
                    <div className="w-12 h-12 rounded-full bg-white/20 backdrop-blur-md border border-white/20 flex items-center justify-center text-white">
                        <ChevronRight className="-rotate-45" size={24} />
                    </div>
                </div>
                <div className="absolute bottom-10 left-10 right-10">
                    <h3 className="text-3xl font-bold text-white mb-3">30-Day Full Body Challenge</h3>
                    <p className="text-white/60 text-sm mb-6 max-w-md">Build strength, burn fat, and improve endurance with our expert-guided program.</p>
                    <div className="flex items-center gap-6 text-white/80 text-xs font-bold uppercase tracking-widest mb-8">
                        <span className="flex items-center gap-2"><div className="w-1.5 h-1.5 rounded-full bg-orange-500"></div> 30 Days</span>
                        <span className="flex items-center gap-2"><div className="w-1.5 h-1.5 rounded-full bg-orange-500"></div> Intermediate</span>
                    </div>
                    <button className="btn-primary px-10">
                        Start Program
                    </button>
                </div>
            </motion.div>

            {/* Program List Section */}
            <div className="space-y-6 pb-20">
                <div className="flex justify-between items-center">
                    <h2 className="text-xl font-bold text-slate-900">Program List</h2>
                </div>
                <AnimatePresence mode="wait">
                    <motion.div
                        key="default"
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                    >
                        <DefaultPrograms />
                    </motion.div>
                </AnimatePresence>
            </div>
        </div>
    );
}
