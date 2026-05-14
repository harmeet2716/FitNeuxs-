import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Send, Bot, User, Sparkles, Mic, Paperclip, ChevronLeft, Zap } from 'lucide-react';

export default function AICoach() {
    const [messages, setMessages] = useState([
        { id: 1, role: 'ai', text: "Neural Link established. I am your FitNexus AI Protocol. How shall we optimize your biological performance today?" }
    ]);
    const [input, setInput] = useState('');

    const handleSend = (e) => {
        e.preventDefault();
        if (!input.trim()) return;

        const userMsg = { id: Date.now(), role: 'user', text: input };
        setMessages([...messages, userMsg]);
        setInput('');

        // Mock AI response
        setTimeout(() => {
            setMessages(prev => [...prev, { 
                id: Date.now() + 1, 
                role: 'ai', 
                text: "Data point received. Analyzing metabolic flux... I recommend initiating a Neural Recovery protocol within 60 minutes to sustain peak HRV levels. Shall I sync this to your Protocol Hub?" 
            }]);
        }, 1500);
    };

    return (
        <div className="w-full max-w-[1000px] mx-auto h-[calc(100vh-160px)] flex flex-col space-y-8 bg-obsidian/20">
            {/* Minimal Dark Header */}
            <div className="flex justify-between items-center bg-white/5 backdrop-blur-3xl rounded-[2rem] p-8 shadow-2xl border border-white/10 relative overflow-hidden group">
                <div className="absolute top-0 right-0 w-32 h-32 bg-cyan-glow/10 blur-[60px] rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                
                <div className="flex items-center gap-6 relative z-10">
                    <div className="w-16 h-16 rounded-2xl bg-cyan-glow text-black flex items-center justify-center shadow-[0_0_30px_rgba(0,242,255,0.4)]">
                        <Bot size={28} />
                    </div>
                    <div>
                        <h2 className="text-xl font-black text-white tracking-widest uppercase font-syncopate">Neural Link v4.0</h2>
                        <div className="flex items-center gap-2 mt-1">
                            <span className="w-2 h-2 rounded-full bg-cyan-glow animate-pulse shadow-[0_0_8px_#00F2FF]"></span>
                            <span className="text-white/20 text-[9px] font-black uppercase tracking-[0.4em]">Zero-G Sync Active</span>
                        </div>
                    </div>
                </div>
                <div className="flex gap-4">
                    <button className="w-12 h-12 rounded-xl border border-white/5 bg-white/5 flex items-center justify-center text-white/40 hover:text-white transition-all">
                        <Sparkles size={20} />
                    </button>
                    <button className="w-12 h-12 rounded-xl border border-white/5 bg-white/5 flex items-center justify-center text-white/40 hover:text-white transition-all">
                        <Zap size={20} />
                    </button>
                </div>
            </div>

            {/* Futuristic Chat Area */}
            <div className="flex-1 bg-white/5 backdrop-blur-3xl rounded-[3rem] shadow-2xl border border-white/10 overflow-hidden flex flex-col">
                <div className="flex-1 overflow-y-auto p-10 space-y-8 no-scrollbar">
                    <AnimatePresence>
                        {messages.map((msg) => (
                            <motion.div 
                                key={msg.id}
                                initial={{ opacity: 0, x: msg.role === 'user' ? 20 : -20, y: 10 }}
                                animate={{ opacity: 1, x: 0, y: 0 }}
                                className={`flex ${msg.role === 'user' ? 'justify-end' : 'justify-start'}`}
                            >
                                <div className={`max-w-[75%] flex gap-5 ${msg.role === 'user' ? 'flex-row-reverse' : 'flex-row'}`}>
                                    <div className={`w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center shadow-lg transition-transform hover:scale-110 ${
                                        msg.role === 'user' ? 'bg-cyan-glow text-black shadow-[0_0_15px_#00F2FF]' : 'bg-white/5 text-white/40 border border-white/10 backdrop-blur-xl'
                                    }`}>
                                        {msg.role === 'user' ? <User size={20} /> : <Bot size={20} />}
                                    </div>
                                    <div className={`p-6 rounded-[2rem] text-sm leading-relaxed font-bold shadow-2xl ${
                                        msg.role === 'user' 
                                        ? 'bg-cyan-glow text-black rounded-tr-none shadow-cyan-glow/10' 
                                        : 'bg-white/5 text-white/80 rounded-tl-none border border-white/10 backdrop-blur-xl'
                                    }`}>
                                        {msg.text}
                                        <div className={`text-[9px] mt-3 font-black uppercase tracking-widest opacity-30 ${msg.role === 'user' ? 'text-right' : 'text-left'}`}>
                                            {msg.role === 'user' ? 'Bio-Signal Sent' : 'Neural Response'}
                                        </div>
                                    </div>
                                </div>
                            </motion.div>
                        ))}
                    </AnimatePresence>
                </div>

                {/* Cyberpunk Input Area */}
                <div className="p-10 pt-0">
                    <form onSubmit={handleSend} className="relative group">
                        <input 
                            type="text" 
                            placeholder="Enter neural command..."
                            value={input}
                            onChange={(e) => setInput(e.target.value)}
                            className="w-full bg-white/5 border border-white/10 rounded-2xl py-6 pl-10 pr-40 text-white placeholder-white/20 focus:outline-none focus:ring-2 focus:ring-cyan-glow/20 focus:border-cyan-glow/50 transition-all font-bold shadow-inner backdrop-blur-xl"
                        />
                        <div className="absolute right-4 top-1/2 -translate-y-1/2 flex items-center gap-3">
                            <button type="button" className="w-10 h-10 rounded-xl text-white/20 hover:text-white transition-colors">
                                <Mic size={20} />
                            </button>
                            <button type="button" className="w-10 h-10 rounded-xl text-white/20 hover:text-white transition-colors">
                                <Paperclip size={20} />
                            </button>
                            <button 
                                type="submit" 
                                className="px-6 h-12 rounded-xl bg-cyan-glow text-black flex items-center justify-center hover:scale-105 transition-all shadow-[0_0_20px_rgba(0,242,255,0.3)] font-black text-[10px] uppercase tracking-widest font-syncopate"
                            >
                                <Send size={18} className="mr-2" />
                                Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
