import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Play, Clock, Flame, ChevronDown } from 'lucide-react';

const WorkoutCard = ({ title, time, calories, exercises, color = "cyan-glow" }) => {
    const [isExpanded, setIsExpanded] = useState(false);

    return (
        <motion.div
            layout
            onClick={() => setIsExpanded(!isExpanded)}
            whileHover={{ y: -10 }}
            className={`bg-white/5 backdrop-blur-3xl rounded-[2.5rem] p-8 border border-white/10 cursor-pointer relative overflow-hidden group transition-shadow duration-500 ${isExpanded ? 'shadow-cyan-glow z-20' : 'shadow-2xl'}`}
        >
            <div className="flex justify-between items-start mb-6">
                <div className="flex items-center gap-4">
                    <div className="w-12 h-12 rounded-2xl bg-cyan-glow text-black flex items-center justify-center shadow-[0_0_20px_rgba(0,242,255,0.4)] group-hover:scale-110 transition-transform">
                        <Play size={20} fill="currentColor" />
                    </div>
                    <div>
                        <h4 className="text-white font-black text-sm uppercase tracking-widest">{title}</h4>
                        <div className="flex items-center gap-3 mt-1">
                            <span className="flex items-center gap-1 text-[10px] font-black text-white/30 uppercase">
                                <Clock size={10} /> {time}m
                            </span>
                            <span className="flex items-center gap-1 text-[10px] font-black text-white/30 uppercase">
                                <Flame size={10} /> {calories} kcal
                            </span>
                        </div>
                    </div>
                </div>
                <motion.div
                    animate={{ rotate: isExpanded ? 180 : 0 }}
                    className="text-white/20 group-hover:text-cyan-glow"
                >
                    <ChevronDown size={20} />
                </motion.div>
            </div>

            <AnimatePresence>
                {isExpanded && (
                    <motion.div
                        initial={{ opacity: 0, height: 0 }}
                        animate={{ opacity: 1, height: 'auto' }}
                        exit={{ opacity: 0, height: 0 }}
                        className="space-y-4 pt-4 border-t border-white/5"
                    >
                        <p className="text-[10px] font-black text-cyan-glow uppercase tracking-[0.2em] mb-4">Sequence Breakdown</p>
                        {exercises.map((ex, i) => (
                            <div key={i} className="flex justify-between items-center p-4 bg-white/5 rounded-2xl border border-white/5 group/ex hover:border-cyan-glow/20 transition-colors">
                                <span className="text-xs font-bold text-white/60">{ex.name}</span>
                                <span className="text-[10px] font-black text-white/20 uppercase group-hover/ex:text-cyan-glow transition-colors">{ex.sets} x {ex.reps}</span>
                            </div>
                        ))}
                        <button className="w-full py-4 mt-4 bg-cyan-glow text-black rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-lg hover:shadow-cyan-glow/50 transition-all">
                            Initiate Sequence
                        </button>
                    </motion.div>
                )}
            </AnimatePresence>

            {/* Background Glow */}
            <div className="absolute -bottom-10 -right-10 w-32 h-32 bg-cyan-glow/5 blur-[60px] rounded-full group-hover:bg-cyan-glow/10 transition-colors"></div>
        </motion.div>
    );
};

export default WorkoutCard;
