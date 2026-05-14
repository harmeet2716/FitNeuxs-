import React, { useState } from 'react';
import { motion } from 'framer-motion';

// Mock Data for Muscle Fatigue / Activation
const muscleData = {
    chest: { level: 90, name: 'Chest', warning: true },
    shoulders: { level: 60, name: 'Shoulders', warning: false },
    arms: { level: 75, name: 'Arms', warning: false },
    abs: { level: 30, name: 'Core', warning: false },
    legs: { level: 100, name: 'Legs', warning: true },
};

const getGlowColor = (level, warning) => {
    if (warning) return '#ef4444'; // Rose/Red for overtraining
    if (level > 70) return '#00FF66'; // Neon Green for high activation
    if (level > 30) return '#0ea5e9'; // Neon Blue for medium
    return 'transparent'; // Low activation
};

const getOpacity = (level) => {
    if (level < 10) return 0.1;
    return (level / 100) * 0.8 + 0.2;
};

export default function AnatomyHeatmap() {
    const [hoveredMuscle, setHoveredMuscle] = useState(null);

    return (
        <div className="bg-slate-950/80 backdrop-blur-2xl border border-white/10 rounded-[2rem] p-8 shadow-2xl relative overflow-hidden flex flex-col md:flex-row gap-8 items-center justify-between min-h-[500px]">
            {/* Background Effects */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-emerald-500/10 blur-[100px] rounded-full pointer-events-none"></div>
            
            {/* Left Info Panel */}
            <div className="flex-1 space-y-6 z-10 w-full">
                <div>
                    <h3 className="text-2xl font-bold text-white mb-2">Muscle Activation Heatmap</h3>
                    <p className="text-slate-400 text-sm">Visualizing training volume and recovery status based on your recent sessions.</p>
                </div>

                <div className="space-y-4">
                    {Object.entries(muscleData).map(([key, data]) => (
                        <div 
                            key={key} 
                            className="bg-slate-900/50 border border-white/5 p-4 rounded-xl flex items-center justify-between cursor-pointer hover:bg-slate-800 transition"
                            onMouseEnter={() => setHoveredMuscle(key)}
                            onMouseLeave={() => setHoveredMuscle(null)}
                        >
                            <div className="flex items-center gap-3">
                                <div className="w-3 h-3 rounded-full shadow-[0_0_10px_currentColor]" style={{ color: getGlowColor(data.level, data.warning), backgroundColor: getGlowColor(data.level, data.warning) || '#334155' }}></div>
                                <span className="font-semibold text-slate-200">{data.name}</span>
                            </div>
                            <div className="flex items-center gap-4">
                                <div className="w-24 h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                    <div 
                                        className="h-full rounded-full" 
                                        style={{ width: `${data.level}%`, backgroundColor: getGlowColor(data.level, data.warning) || '#475569' }}
                                    ></div>
                                </div>
                                {data.warning && (
                                    <span className="text-xs font-bold text-rose-400 bg-rose-500/10 px-2 py-0.5 rounded uppercase tracking-wider">Warning</span>
                                )}
                            </div>
                        </div>
                    ))}
                </div>
            </div>

            {/* Right SVG Anatomy Model */}
            <div className="flex-1 flex justify-center items-center z-10 w-full relative h-[400px]">
                {/* Simplified Abstract Body SVG */}
                <svg viewBox="0 0 200 400" className="w-auto h-full max-h-[400px] drop-shadow-2xl overflow-visible">
                    <defs>
                        <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                            <feGaussianBlur stdDeviation="6" result="blur" />
                            <feMerge>
                                <feMergeNode in="blur" />
                                <feMergeNode in="SourceGraphic" />
                            </feMerge>
                        </filter>
                    </defs>

                    {/* Base Body Outline (Abstract) */}
                    <path d="M100 20 C110 20, 115 30, 115 40 C115 50, 110 60, 100 60 C90 60, 85 50, 85 40 C85 30, 90 20, 100 20 Z" fill="#1e293b" stroke="#334155" strokeWidth="2" /> {/* Head */}
                    <path d="M70 70 L130 70 L140 180 L60 180 Z" fill="#1e293b" stroke="#334155" strokeWidth="2" /> {/* Torso */}
                    <path d="M60 70 L30 150 L40 160 L65 90 Z" fill="#1e293b" stroke="#334155" strokeWidth="2" /> {/* L Arm */}
                    <path d="M140 70 L170 150 L160 160 L135 90 Z" fill="#1e293b" stroke="#334155" strokeWidth="2" /> {/* R Arm */}
                    <path d="M70 180 L50 350 L70 350 L95 180 Z" fill="#1e293b" stroke="#334155" strokeWidth="2" /> {/* L Leg */}
                    <path d="M130 180 L150 350 L130 350 L105 180 Z" fill="#1e293b" stroke="#334155" strokeWidth="2" /> {/* R Leg */}

                    {/* Chest Area */}
                    <motion.path 
                        d="M75 80 L125 80 L120 110 L80 110 Z" 
                        fill={getGlowColor(muscleData.chest.level, muscleData.chest.warning)} 
                        opacity={hoveredMuscle === 'chest' ? 1 : getOpacity(muscleData.chest.level)}
                        style={{ filter: hoveredMuscle === 'chest' ? 'url(#glow)' : 'none', transition: 'all 0.3s ease' }}
                    />

                    {/* Shoulders Area */}
                    <motion.path 
                        d="M60 70 L75 80 L65 100 Z" 
                        fill={getGlowColor(muscleData.shoulders.level, muscleData.shoulders.warning)} 
                        opacity={hoveredMuscle === 'shoulders' ? 1 : getOpacity(muscleData.shoulders.level)}
                        style={{ filter: hoveredMuscle === 'shoulders' ? 'url(#glow)' : 'none', transition: 'all 0.3s ease' }}
                    />
                    <motion.path 
                        d="M140 70 L125 80 L135 100 Z" 
                        fill={getGlowColor(muscleData.shoulders.level, muscleData.shoulders.warning)} 
                        opacity={hoveredMuscle === 'shoulders' ? 1 : getOpacity(muscleData.shoulders.level)}
                        style={{ filter: hoveredMuscle === 'shoulders' ? 'url(#glow)' : 'none', transition: 'all 0.3s ease' }}
                    />

                    {/* Arms Area */}
                    <motion.path 
                        d="M35 120 L55 90 L60 140 Z" 
                        fill={getGlowColor(muscleData.arms.level, muscleData.arms.warning)} 
                        opacity={hoveredMuscle === 'arms' ? 1 : getOpacity(muscleData.arms.level)}
                        style={{ filter: hoveredMuscle === 'arms' ? 'url(#glow)' : 'none', transition: 'all 0.3s ease' }}
                    />
                    <motion.path 
                        d="M165 120 L145 90 L140 140 Z" 
                        fill={getGlowColor(muscleData.arms.level, muscleData.arms.warning)} 
                        opacity={hoveredMuscle === 'arms' ? 1 : getOpacity(muscleData.arms.level)}
                        style={{ filter: hoveredMuscle === 'arms' ? 'url(#glow)' : 'none', transition: 'all 0.3s ease' }}
                    />

                    {/* Core/Abs Area */}
                    <motion.path 
                        d="M80 120 L120 120 L115 170 L85 170 Z" 
                        fill={getGlowColor(muscleData.abs.level, muscleData.abs.warning)} 
                        opacity={hoveredMuscle === 'abs' ? 1 : getOpacity(muscleData.abs.level)}
                        style={{ filter: hoveredMuscle === 'abs' ? 'url(#glow)' : 'none', transition: 'all 0.3s ease' }}
                    />

                    {/* Legs (Quads) Area */}
                    <motion.path 
                        d="M75 190 L90 190 L80 270 L60 270 Z" 
                        fill={getGlowColor(muscleData.legs.level, muscleData.legs.warning)} 
                        opacity={hoveredMuscle === 'legs' ? 1 : getOpacity(muscleData.legs.level)}
                        style={{ filter: hoveredMuscle === 'legs' ? 'url(#glow)' : 'none', transition: 'all 0.3s ease' }}
                    />
                    <motion.path 
                        d="M125 190 L110 190 L120 270 L140 270 Z" 
                        fill={getGlowColor(muscleData.legs.level, muscleData.legs.warning)} 
                        opacity={hoveredMuscle === 'legs' ? 1 : getOpacity(muscleData.legs.level)}
                        style={{ filter: hoveredMuscle === 'legs' ? 'url(#glow)' : 'none', transition: 'all 0.3s ease' }}
                    />
                </svg>

                {/* Floating Tooltip if hovering over SVG directly */}
                <AnimatePresence>
                    {hoveredMuscle && (
                        <motion.div 
                            initial={{ opacity: 0, y: 10 }}
                            animate={{ opacity: 1, y: 0 }}
                            exit={{ opacity: 0 }}
                            className="absolute top-10 right-0 bg-slate-900 border border-white/10 p-3 rounded-lg shadow-xl backdrop-blur-md"
                        >
                            <p className="text-white font-bold text-sm">{muscleData[hoveredMuscle].name}</p>
                            <p className="text-slate-400 text-xs mt-1">Activation: {muscleData[hoveredMuscle].level}%</p>
                            {muscleData[hoveredMuscle].warning && <p className="text-rose-400 text-xs font-bold mt-1">High Fatigue Detected</p>}
                        </motion.div>
                    )}
                </AnimatePresence>
            </div>
        </div>
    );
}
