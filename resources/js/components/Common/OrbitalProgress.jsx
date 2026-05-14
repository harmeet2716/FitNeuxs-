import React from 'react';
import { motion } from 'framer-motion';

const OrbitalProgress = ({ progress = 0, size = 120, strokeWidth = 10, color = "#00F2FF", label = "PRO" }) => {
    const radius = (size - strokeWidth) / 2;
    const circumference = radius * 2 * Math.PI;
    const offset = circumference - (progress / 100) * circumference;

    return (
        <div className="relative flex items-center justify-center group" style={{ width: size, height: size }}>
            {/* Background Track with Inner Glow Effect */}
            <svg width={size} height={size} className="rotate-[-90deg]">
                <circle
                    cx={size / 2}
                    cy={size / 2}
                    r={radius}
                    fill="transparent"
                    stroke="rgba(255,255,255,0.05)"
                    strokeWidth={strokeWidth}
                />
                
                {/* 3D Depth Shadow Ring */}
                <circle
                    cx={size / 2}
                    cy={size / 2}
                    r={radius}
                    fill="transparent"
                    stroke="rgba(0,0,0,0.5)"
                    strokeWidth={strokeWidth / 2}
                    className="blur-[2px]"
                />

                {/* Main Progress Ring */}
                <motion.circle
                    cx={size / 2}
                    cy={size / 2}
                    r={radius}
                    fill="transparent"
                    stroke={color}
                    strokeWidth={strokeWidth}
                    strokeDasharray={circumference}
                    initial={{ strokeDashoffset: circumference }}
                    animate={{ strokeDashoffset: offset }}
                    transition={{ duration: 1.5, ease: "circOut" }}
                    strokeLinecap="round"
                    className="drop-shadow-[0_0_8px_var(--tw-shadow-color)]"
                    style={{ '--tw-shadow-color': color }}
                />

                {/* Orbital Particle (Glow at end of progress) */}
                {progress > 0 && (
                    <motion.circle
                        cx={size / 2}
                        cy={size / 2}
                        r={radius}
                        fill="transparent"
                        stroke="#fff"
                        strokeWidth={2}
                        strokeDasharray={`1 ${circumference}`}
                        initial={{ strokeDashoffset: circumference }}
                        animate={{ strokeDashoffset: offset }}
                        transition={{ duration: 1.5, ease: "circOut" }}
                        className="blur-[1px]"
                    />
                )}
            </svg>

            {/* Inner Content */}
            <div className="absolute inset-0 flex flex-col items-center justify-center">
                <span className="text-[10px] font-black tracking-[0.2em] text-white/30 uppercase mb-1">{label}</span>
                <span className="text-lg font-black text-white">{progress}%</span>
            </div>

            {/* Hover Outer Ring */}
            <div className="absolute inset-[-4px] border border-white/5 rounded-full scale-0 group-hover:scale-100 transition-transform duration-500 blur-[1px]"></div>
        </div>
    );
};

export default OrbitalProgress;
