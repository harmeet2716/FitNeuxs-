import React from 'react';
import { motion } from 'framer-motion';
import ExerciseLoggingUI from '../ProgramBuilder/ExerciseLoggingUI';
import { Play, Pause, Square, Timer, ChevronLeft } from 'lucide-react';

export default function WorkoutPage({ programName = "Custom PPL Split", dayName = "Day 1: Heavy Push" }) {
    return (
        <div className="w-full max-w-[1200px] mx-auto px-4 py-8 space-y-8">
            {/* Header Section */}
            <div className="bg-white rounded-[2.5rem] p-8 shadow-sm border border-black/5 relative overflow-hidden">
                <div className="absolute top-0 right-0 w-64 h-64 bg-orange-500/5 blur-[80px] rounded-full pointer-events-none"></div>
                
                <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative z-10">
                    <div className="flex items-center gap-6">
                        <button className="w-12 h-12 rounded-full bg-slate-50 border border-black/5 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-colors">
                            <ChevronLeft size={24} />
                        </button>
                        <div>
                            <div className="flex items-center gap-3 mb-2">
                                <span className="px-3 py-1 bg-orange-500 text-white rounded-full text-[10px] font-bold uppercase tracking-widest">
                                    Live Session
                                </span>
                                <span className="text-slate-400 text-xs font-bold uppercase tracking-widest">{programName}</span>
                            </div>
                            <h1 className="text-3xl font-bold text-slate-900 tracking-tight">{dayName}</h1>
                        </div>
                    </div>

                    <div className="flex items-center gap-6 bg-slate-50 border border-black/5 p-3 pl-8 rounded-full shadow-inner">
                        <div className="flex items-center gap-3 text-slate-900 font-mono text-2xl font-bold">
                            <Timer size={24} className="text-orange-500" />
                            <span>00:45:12</span>
                        </div>
                        <div className="flex gap-3 border-l border-black/5 pl-6">
                            <button className="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center hover:bg-orange-50 text-orange-500 transition-colors">
                                <Pause size={20} fill="currentColor" />
                            </button>
                            <button className="w-12 h-12 rounded-full bg-slate-900 shadow-lg flex items-center justify-center hover:bg-slate-800 text-white transition-all">
                                <Square size={18} fill="currentColor" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {/* Exercise Logger Wrapper */}
            <motion.div 
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.2 }}
                className="space-y-6"
            >
                <div className="flex justify-between items-end px-2">
                    <div>
                        <h2 className="text-2xl font-bold text-slate-900">Current Exercise</h2>
                        <p className="text-slate-400 text-sm font-medium mt-1">Focus on form and controlled movements</p>
                    </div>
                    <span className="text-orange-500 text-sm font-bold bg-orange-50 px-4 py-1.5 rounded-full">1 of 6 Exercises</span>
                </div>
                
                <div className="bg-white rounded-[3rem] p-4 shadow-sm border border-black/5">
                    <ExerciseLoggingUI />
                </div>

                <div className="flex justify-center gap-4">
                    <button className="px-10 py-4 bg-white border border-black/5 rounded-full text-slate-400 font-bold hover:text-slate-900 transition-colors">
                        Skip Exercise
                    </button>
                    <button className="btn-primary px-10 py-4">
                        Finish Workout
                    </button>
                </div>
            </motion.div>
        </div>
    );
}
