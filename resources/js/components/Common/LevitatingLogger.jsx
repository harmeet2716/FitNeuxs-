import React from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { X } from 'lucide-react';

const LevitatingLogger = ({ isOpen, onClose, title, children }) => {
    return (
        <AnimatePresence>
            {isOpen && (
                <>
                    {/* Backdrop */}
                    <motion.div
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        onClick={onClose}
                        className="fixed inset-0 bg-black/40 backdrop-blur-sm z-[100]"
                    />

                    {/* Levitating Modal */}
                    <motion.div
                        initial={{ y: "100%", opacity: 0 }}
                        animate={{ y: 0, opacity: 1 }}
                        exit={{ y: "100%", opacity: 0 }}
                        transition={{ type: "spring", damping: 25, stiffness: 200 }}
                        className="fixed bottom-[20px] left-[20px] right-[20px] max-w-[600px] mx-auto z-[101] bg-white/5 backdrop-blur-3xl border border-white/10 rounded-[2.5rem] shadow-cyan-glow overflow-hidden"
                    >
                        {/* Header */}
                        <div className="p-8 border-b border-white/5 flex justify-between items-center">
                            <div>
                                <h3 className="text-xl font-black text-white tracking-widest font-syncopate uppercase">{title}</h3>
                                <div className="flex items-center gap-2 mt-1">
                                    <span className="w-1.5 h-1.5 rounded-full bg-cyan-glow animate-pulse"></span>
                                    <span className="text-[9px] font-black text-white/20 uppercase tracking-[0.3em]">Quantum Logger Active</span>
                                </div>
                            </div>
                            <button 
                                onClick={onClose}
                                className="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/10 transition-all"
                            >
                                <X size={20} />
                            </button>
                        </div>

                        {/* Content */}
                        <div className="p-8 max-h-[70vh] overflow-y-auto no-scrollbar">
                            {children}
                        </div>

                        {/* Footer / Gradient Base */}
                        <div className="h-4 bg-gradient-to-t from-cyan-glow/10 to-transparent"></div>
                    </motion.div>
                </>
            )}
        </AnimatePresence>
    );
};

export default LevitatingLogger;
