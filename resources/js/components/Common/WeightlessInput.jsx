import React from 'react';

const WeightlessInput = ({ label, type = "text", placeholder, value, onChange, ...props }) => {
    return (
        <div className="w-full mb-6">
            {label && (
                <label className="block text-[10px] font-black uppercase tracking-[0.3em] text-white/40 mb-2 ml-1">
                    {label}
                </label>
            )}
            <input
                type={type}
                placeholder={placeholder}
                value={value}
                onChange={onChange}
                className="w-full bg-transparent border-0 border-b border-white/10 py-4 px-1 text-white placeholder-white/20 focus:outline-none focus:border-cyan-glow focus:ring-0 transition-all duration-300 shadow-[0_1px_0_0_transparent] focus:shadow-cyan-glow"
                {...props}
            />
        </div>
    );
};

export default WeightlessInput;
