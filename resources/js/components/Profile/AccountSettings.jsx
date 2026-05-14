import React from 'react';
import { motion } from 'framer-motion';
import { 
    CreditCard, ShieldAlert, Trash2, Globe, 
    Info, ExternalLink, ChevronRight, Zap, 
    Key, Bell, Database
} from 'lucide-react';

const SettingsRow = ({ icon: Icon, title, subtitle, action, danger = false, warning = false }) => (
    <div className="group flex items-center justify-between p-6 rounded-2xl hover:bg-white/[0.02] transition-all cursor-pointer border border-transparent hover:border-white/5">
        <div className="flex items-center gap-5">
            <div className={`w-12 h-12 rounded-xl flex items-center justify-center transition-all ${
                danger ? 'bg-rose-500/10 text-rose-500 group-hover:shadow-[0_0_20px_rgba(244,63,94,0.2)]' : 
                warning ? 'bg-amber-500/10 text-amber-500 group-hover:shadow-[0_0_20px_rgba(245,158,11,0.2)]' :
                'bg-white/5 text-slate-400 group-hover:text-cyan-glow group-hover:bg-cyan-glow/10'
            }`}>
                <Icon size={20} strokeWidth={2.5} />
            </div>
            <div>
                <h4 className={`text-sm font-bold tracking-tight ${danger ? 'text-rose-400' : 'text-white'}`}>{title}</h4>
                <p className="text-[10px] font-medium text-slate-500 uppercase tracking-widest mt-1">{subtitle}</p>
            </div>
        </div>
        <div className="flex items-center gap-4">
            {action}
            <ChevronRight size={16} className="text-white/10 group-hover:text-white/40 transition-colors" />
        </div>
    </div>
);

const SectionHeader = ({ title }) => (
    <h3 className="px-6 text-[10px] font-black text-slate-600 uppercase tracking-[0.4em] mb-4 mt-8 first:mt-0">
        {title}
    </h3>
);

export default function AccountSettings({ user }) {
    if (!user) return null;

    return (
        <div className="max-w-4xl mx-auto px-6 py-20 space-y-16 pb-40">
            {/* Page Title */}
            <div className="space-y-4">
                <div className="flex items-center gap-3">
                    <span className="text-[10px] font-black uppercase tracking-[0.4em] text-white/20">System Configuration</span>
                    <div className="h-px flex-1 bg-white/5" />
                </div>
                <h1 className="text-5xl font-black tracking-tighter uppercase italic">
                    Account <span className="text-cyan-glow not-italic">Terminal</span>
                </h1>
            </div>

            {/* Subscription Module */}
            <div className="relative group">
                <div className="absolute -inset-1 bg-gradient-to-r from-cyan-glow/20 to-orbit-purple/20 rounded-[2.5rem] blur opacity-25 group-hover:opacity-50 transition duration-1000" />
                <div className="relative p-10 rounded-[2.5rem] bg-white/[0.03] border border-white/10 backdrop-blur-3xl flex flex-col md:flex-row items-center justify-between gap-8 shadow-2xl">
                    <div className="flex items-center gap-8">
                        <div className="w-20 h-20 rounded-[2rem] bg-cyan-glow/10 flex items-center justify-center text-cyan-glow shadow-[0_0_30px_rgba(0,242,255,0.15)]">
                            <Zap size={32} strokeWidth={2.5} />
                        </div>
                        <div>
                            <div className="flex items-center gap-3 mb-2">
                                <h2 className="text-2xl font-black tracking-tight text-white uppercase italic">Neural Sync Plus</h2>
                                <span className="px-3 py-1 rounded-full bg-cyan-glow text-black text-[8px] font-black uppercase tracking-widest shadow-[0_0_15px_rgba(0,242,255,0.4)]">Active Tier</span>
                            </div>
                            <p className="text-slate-500 text-xs font-bold uppercase tracking-widest">Next Synchronization: June 14, 2026</p>
                        </div>
                    </div>
                    <div className="flex flex-col items-center gap-4 w-full md:w-auto">
                        <button className="w-full md:w-auto px-10 py-4 bg-white text-black rounded-xl font-black text-[10px] uppercase tracking-[0.3em] hover:bg-cyan-glow transition-all shadow-xl hover:shadow-cyan-glow/20">
                            Update Protocol
                        </button>
                        <button className="text-[9px] font-black text-white/20 hover:text-rose-500 uppercase tracking-[0.3em] transition-colors">
                            Deactivate Subscription
                        </button>
                    </div>
                </div>
            </div>

            {/* List Settings Hierarchy */}
            <div className="space-y-12">
                
                {/* Security & Access */}
                <div className="space-y-4">
                    <SectionHeader title="Access Protocols" />
                    <div className="space-y-1">
                        <SettingsRow 
                            icon={Key} 
                            title="Authentication Matrix" 
                            subtitle="Update password and security tokens"
                        />
                        <SettingsRow 
                            icon={Bell} 
                            title="Neural Notifications" 
                            subtitle="Configure system alerts and telemetry"
                        />
                        <SettingsRow 
                            icon={CreditCard} 
                            title="Billing Archetype" 
                            subtitle="Manage payment methods and invoices"
                        />
                    </div>
                </div>

                {/* Data & Privacy */}
                <div className="space-y-4">
                    <SectionHeader title="Data & Core Safety" />
                    <div className="space-y-1">
                        <SettingsRow 
                            icon={Database} 
                            title="Export Neural Data" 
                            subtitle="Download a copy of your biological logs"
                        />
                        <SettingsRow 
                            icon={ShieldAlert} 
                            title="Reset Bio-Matrix" 
                            subtitle="Permanently erase all performance history"
                            warning
                        />
                        <SettingsRow 
                            icon={Trash2} 
                            title="Deactivate Neural Link" 
                            subtitle="Irreversibly delete your FitNexus identity"
                            danger
                        />
                    </div>
                </div>

                {/* System Info */}
                <div className="space-y-4">
                    <SectionHeader title="System Information" />
                    <div className="space-y-1">
                        <SettingsRow 
                            icon={Globe} 
                            title="Community Nexus" 
                            subtitle="Access global forums and social channels"
                            action={<ExternalLink size={14} className="text-white/20" />}
                        />
                        <SettingsRow 
                            icon={Info} 
                            title="About FitNexus Core" 
                            subtitle="System Version 4.2.0-Alpha (NASA-Grade)"
                        />
                    </div>
                </div>
            </div>

            {/* Footer Links */}
            <div className="flex justify-center gap-10 pt-10 border-t border-white/5">
                {['Legal Protocol', 'Privacy Terms', 'Service Level Agreement'].map(link => (
                    <button key={link} className="text-[9px] font-black text-slate-600 hover:text-white uppercase tracking-[0.2em] transition-colors">
                        {link}
                    </button>
                ))}
            </div>
        </div>
    );
}
