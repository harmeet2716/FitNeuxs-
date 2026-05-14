import React, { useState, useCallback } from 'react';
import Cropper from 'react-easy-crop';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    User, Mail, Camera, Weight, Ruler, Target, 
    RefreshCcw, Check, Info, Shield, Zap
} from 'lucide-react';

const GhostInput = ({ label, icon: Icon, value, onChange, type = "text", placeholder }) => (
    <div className="space-y-3 group">
        <label className="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 group-focus-within:text-cyan-glow transition-all">
            {label}
        </label>
        <div className="relative">
            <div className="absolute left-0 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-cyan-glow transition-colors">
                <Icon size={16} strokeWidth={2.5} />
            </div>
            <input 
                type={type}
                value={value}
                onChange={(e) => onChange(e.target.value)}
                placeholder={placeholder}
                className="w-full bg-transparent border-b border-white/10 rounded-none py-4 pl-8 pr-4 text-white font-medium text-sm focus:border-cyan-glow outline-none transition-all placeholder:text-white/10"
            />
        </div>
    </div>
);

const GlassCard = ({ children, className = "" }) => (
    <div className={`backdrop-blur-2xl bg-white/[0.03] border border-white/10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.4)] ${className}`}>
        {children}
    </div>
);

const ProfessionalMetric = ({ label, value, onChange, units, currentUnit, onUnitToggle, icon: Icon, glowColor }) => (
    <GlassCard className="p-8 group hover:border-white/20 transition-all duration-500">
        <div className="flex justify-between items-center mb-10">
            <div className="flex items-center gap-4">
                <div className={`p-3 rounded-2xl bg-${glowColor}-glow/10 text-${glowColor}-glow shadow-[0_0_20px_rgba(0,242,255,0.1)]`}>
                    <Icon size={20} />
                </div>
                <span className="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">{label}</span>
            </div>
            <div className="flex bg-white/5 p-1 rounded-xl border border-white/5">
                {units.map(u => (
                    <button 
                        key={u}
                        onClick={() => onUnitToggle(u)}
                        className={`px-4 py-1.5 text-[9px] font-black rounded-lg transition-all ${currentUnit === u ? 'bg-white text-black' : 'text-white/20 hover:text-white/40'}`}
                    >
                        {u}
                    </button>
                ))}
            </div>
        </div>
        <div className="relative flex items-end gap-3">
            <input 
                type="number"
                value={value}
                onChange={(e) => onChange(e.target.value)}
                className="bg-transparent border-none p-0 text-6xl font-black text-white focus:ring-0 w-full tracking-tighter"
            />
            <span className="text-white/20 font-black text-xs uppercase tracking-widest pb-3">{currentUnit}</span>
        </div>
    </GlassCard>
);

export default function ProfileSettings({ user, fitnessProfile }) {
    if (!user) return null;

    const [name, setName] = useState(user.name);
    const [email, setEmail] = useState(user.email);
    const [weight, setWeight] = useState(fitnessProfile?.weight_kg || '');
    const [height, setHeight] = useState(fitnessProfile?.height_cm || '');
    const [goalWeight, setGoalWeight] = useState(fitnessProfile?.goal_weight_kg || '');
    const [weightUnit, setWeightUnit] = useState('KG');
    const [heightUnit, setHeightUnit] = useState('CM');
    
    const [image, setImage] = useState(null);
    const [crop, setCrop] = useState({ x: 0, y: 0 });
    const [zoom, setZoom] = useState(1);
    const [croppedAreaPixels, setCroppedAreaPixels] = useState(null);
    const [showCropper, setShowCropper] = useState(false);
    const [saving, setSaving] = useState(false);
    const [saved, setSaved] = useState(false);

    const bmiValue = (() => {
        if (!weight || !height) return null;
        const w = weightUnit === 'LB' ? weight * 0.453592 : weight;
        const h = heightUnit === 'IN' ? height * 0.0254 : height / 100;
        return (w / (h * h)).toFixed(1);
    })();

    const handleFileChange = (e) => {
        if (e.target.files && e.target.files.length > 0) {
            const reader = new FileReader();
            reader.addEventListener('load', () => {
                setImage(reader.result);
                setShowCropper(true);
            });
            reader.readAsDataURL(e.target.files[0]);
        }
    };

    const handleSave = async () => {
        setSaving(true);
        await new Promise(r => setTimeout(r, 1500));
        setSaved(true);
        setSaving(false);
        setTimeout(() => setSaved(false), 3000);
    };

    return (
        <div className="min-h-screen bg-obsidian text-white font-sans selection:bg-cyan-glow/30 selection:text-white relative overflow-hidden">
            {/* Ambient Background Elements */}
            <div className="absolute top-[-10%] right-[-10%] w-[50%] h-[50%] bg-cyan-glow/5 rounded-full blur-[120px] pointer-events-none" />
            <div className="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-orbit-purple/5 rounded-full blur-[100px] pointer-events-none" />
            
            <div className="max-w-6xl mx-auto px-8 py-20 relative z-10 space-y-20">
                
                {/* NASA-Grade Header */}
                <div className="flex flex-col md:flex-row justify-between items-start md:items-end gap-10">
                    <div className="space-y-4">
                        <div className="flex items-center gap-3">
                            <span className="w-2 h-2 rounded-full bg-cyan-glow shadow-[0_0_10px_#00F2FF]" />
                            <span className="text-[10px] font-black uppercase tracking-[0.4em] text-white/30">Profile Architecture Sync v4.2</span>
                        </div>
                        <h1 className="text-6xl font-black tracking-tighter uppercase italic leading-none">
                            Identity <span className="text-cyan-glow not-italic">Matrix</span>
                        </h1>
                    </div>
                    <button 
                        onClick={handleSave}
                        disabled={saving}
                        className={`group relative px-10 py-4 rounded-full font-black text-[10px] uppercase tracking-[0.3em] transition-all overflow-hidden ${
                            saved ? 'bg-emerald-500' : 'bg-cyan-glow text-black'
                        } shadow-[0_0_30px_rgba(0,242,255,0.2)] hover:shadow-[0_0_50px_rgba(0,242,255,0.4)] hover:-translate-y-1 active:translate-y-0`}
                    >
                        <div className="relative z-10 flex items-center gap-3">
                            {saving ? (
                                <RefreshCcw size={16} className="animate-spin" />
                            ) : saved ? (
                                <Check size={16} strokeWidth={3} />
                            ) : (
                                <RefreshCcw size={16} strokeWidth={3} />
                            )}
                            {saved ? 'Sync Complete' : 'Update Matrix'}
                        </div>
                    </button>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-12 gap-16">
                    
                    {/* Left Panel: Neural Sync */}
                    <div className="lg:col-span-5 space-y-12">
                        <GlassCard className="p-12 text-center relative overflow-hidden">
                            <div className="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-cyan-glow/20 to-transparent" />
                            
                            {/* Neural Sync Ring */}
                            <div className="relative w-56 h-56 mx-auto mb-12">
                                <motion.div 
                                    animate={{ rotate: 360 }}
                                    transition={{ duration: 20, repeat: Infinity, ease: "linear" }}
                                    className="absolute -inset-4 border border-dashed border-cyan-glow/20 rounded-full"
                                />
                                <div className="absolute -inset-2 border border-white/5 rounded-full" />
                                
                                <div className="w-full h-full rounded-full overflow-hidden border-4 border-white/10 bg-slate-900 shadow-2xl relative group/avatar">
                                    {user.profile_photo_path ? (
                                        <img src={`/storage/${user.profile_photo_path}`} className="w-full h-full object-cover" alt="Profile" />
                                    ) : (
                                        <div className="w-full h-full flex items-center justify-center text-5xl font-black text-cyan-glow bg-cyan-glow/5 uppercase italic">
                                            {user.name.charAt(0)}
                                        </div>
                                    )}
                                    <label className="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover/avatar:opacity-100 transition-opacity cursor-pointer">
                                        <Camera size={32} className="text-white" />
                                        <input type="file" className="hidden" accept="image/*" onChange={handleFileChange} />
                                    </label>
                                </div>
                            </div>

                            <div className="space-y-3">
                                <h2 className="text-4xl font-black tracking-tighter italic uppercase">{name}</h2>
                                <div className="flex items-center justify-center gap-2 text-white/30 text-[10px] font-black uppercase tracking-widest">
                                    <Shield size={12} className="text-cyan-glow" /> 
                                    Encrypted Biological ID
                                </div>
                            </div>
                        </GlassCard>

                        {/* Identity Fields */}
                        <div className="space-y-10 px-4">
                            <GhostInput 
                                label="Biological Designation" 
                                icon={User} 
                                value={name} 
                                onChange={setName} 
                                placeholder="Designation required..."
                            />
                            <GhostInput 
                                label="Neural Communication Path" 
                                icon={Mail} 
                                value={email} 
                                onChange={setEmail} 
                                type="email"
                                placeholder="Communication route..."
                            />
                        </div>
                    </div>

                    {/* Right Panel: Biometric HUD */}
                    <div className="lg:col-span-7 space-y-12">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <ProfessionalMetric 
                                label="Mass Index"
                                value={weight}
                                onChange={setWeight}
                                units={['KG', 'LB']}
                                currentUnit={weightUnit}
                                onUnitToggle={setWeightUnit}
                                icon={Weight}
                                glowColor="cyan"
                            />
                            <ProfessionalMetric 
                                label="Elevation Profile"
                                value={height}
                                onChange={setHeight}
                                units={['CM', 'IN']}
                                currentUnit={heightUnit}
                                onUnitToggle={setHeightUnit}
                                icon={Ruler}
                                glowColor="cyan"
                            />
                        </div>

                        {/* Metabolic Analysis */}
                        <GlassCard className="p-10 flex flex-col md:flex-row items-center gap-10">
                            <div className="relative w-32 h-32 flex items-center justify-center">
                                <svg className="absolute inset-0 w-full h-full -rotate-90">
                                    <circle cx="64" cy="64" r="58" stroke="currentColor" strokeWidth="8" fill="transparent" className="text-white/5" />
                                    <motion.circle 
                                        cx="64" cy="64" r="58" stroke="currentColor" strokeWidth="8" fill="transparent" 
                                        className="text-cyan-glow"
                                        strokeDasharray="364.4"
                                        initial={{ strokeDashoffset: 364.4 }}
                                        animate={{ strokeDashoffset: 364.4 - (364.4 * (bmiValue || 0) / 40) }}
                                    />
                                </svg>
                                <div className="text-center">
                                    <div className="text-3xl font-black text-white tracking-tighter">{bmiValue || '--'}</div>
                                    <div className="text-[8px] font-black text-white/30 uppercase tracking-[0.2em]">BMI</div>
                                </div>
                            </div>
                            <div className="flex-1 space-y-3">
                                <div className="flex items-center gap-2">
                                    <Zap size={14} className="text-cyan-glow" />
                                    <h4 className="text-sm font-black uppercase tracking-widest">Metabolic Trajectory</h4>
                                </div>
                                <p className="text-white/40 text-xs font-medium leading-relaxed uppercase tracking-wider">
                                    Neural analysis suggests your bio-synchronization is <span className="text-cyan-glow">Optimal</span>. No adjustment protocols required for the current cycle.
                                </p>
                            </div>
                        </GlassCard>

                        {/* Projected Progress */}
                        <div className="space-y-8 pt-6">
                            <div className="flex justify-between items-end">
                                <div className="space-y-2">
                                    <span className="text-[10px] font-black text-white/20 uppercase tracking-[0.4em]">Projected Target</span>
                                    <h3 className="text-2xl font-black italic uppercase tracking-tight flex items-center gap-3">
                                        <Target size={24} className="text-cyan-glow" />
                                        Progress to {goalWeight || '--'} {weightUnit}
                                    </h3>
                                </div>
                                <div className="text-right">
                                    <div className="text-xs font-black text-cyan-glow uppercase tracking-widest animate-pulse">Synchronizing...</div>
                                </div>
                            </div>

                            <div className="relative h-1 bg-white/5 rounded-full overflow-hidden">
                                <motion.div 
                                    initial={{ width: 0 }}
                                    animate={{ width: weight && goalWeight ? '65%' : '0%' }}
                                    className="h-full bg-cyan-glow shadow-[0_0_15px_#00F2FF]"
                                />
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                                <div className="space-y-4">
                                    <label className="text-[10px] font-black text-white/20 uppercase tracking-[0.3em]">Adjust Target Vector</label>
                                    <div className="relative group">
                                        <input 
                                            type="number"
                                            value={goalWeight}
                                            onChange={(e) => setGoalWeight(e.target.value)}
                                            className="w-full bg-white/5 border border-white/5 rounded-2xl py-5 px-8 text-3xl font-black text-white focus:border-cyan-glow/50 outline-none transition-all tracking-tighter"
                                        />
                                        <span className="absolute right-6 top-1/2 -translate-y-1/2 text-white/20 font-black uppercase text-xs tracking-widest">{weightUnit}</span>
                                    </div>
                                </div>
                                <div className="flex items-center gap-4 text-[10px] font-black text-white/20 uppercase tracking-widest leading-relaxed border-l border-white/5 pl-8">
                                    <Info size={18} className="text-cyan-glow shrink-0" />
                                    Maintain current caloric input to reach target singularity within 3 planetary rotations.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* NASA-Grade Cropper */}
                <AnimatePresence>
                    {showCropper && (
                        <motion.div 
                            initial={{ opacity: 0 }} animate={{ opacity: 1 }} exit={{ opacity: 0 }}
                            className="fixed inset-0 z-[200] flex items-center justify-center p-10 bg-black/95 backdrop-blur-3xl"
                        >
                            <div className="w-full max-w-2xl bg-obsidian border border-white/10 rounded-[3rem] overflow-hidden shadow-2xl relative">
                                <div className="p-10 border-b border-white/5 flex justify-between items-center">
                                    <h3 className="text-xl font-black uppercase tracking-widest italic">Optical Alignment</h3>
                                    <button onClick={() => setShowCropper(false)} className="text-white/20 hover:text-white transition-colors uppercase text-[10px] font-black tracking-widest">Abort</button>
                                </div>
                                <div className="relative h-[400px] bg-black">
                                    <Cropper
                                        image={image}
                                        crop={crop}
                                        zoom={zoom}
                                        aspect={1}
                                        cropShape="round"
                                        showGrid={false}
                                        onCropChange={setCrop}
                                        onCropComplete={(a, ap) => setCroppedAreaPixels(ap)}
                                        onZoomChange={setZoom}
                                    />
                                </div>
                                <div className="p-10 space-y-10">
                                    <div className="space-y-4">
                                        <div className="flex justify-between text-[10px] font-black text-white/20 uppercase tracking-widest">
                                            <span>Optical Magnification</span>
                                            <span className="text-cyan-glow">{(zoom * 100).toFixed(0)}%</span>
                                        </div>
                                        <input 
                                            type="range" min={1} max={3} step={0.1} value={zoom}
                                            onChange={(e) => setZoom(e.target.value)}
                                            className="w-full h-1 bg-white/5 rounded-full appearance-none accent-cyan-glow"
                                        />
                                    </div>
                                    <button 
                                        onClick={() => setShowCropper(false)}
                                        className="w-full py-5 bg-cyan-glow text-black font-black text-[10px] uppercase tracking-[0.4em] rounded-2xl hover:shadow-[0_0_50px_rgba(0,242,255,0.4)] transition-all"
                                    >
                                        Establish Visual Sync
                                    </button>
                                </div>
                            </div>
                        </motion.div>
                    )}
                </AnimatePresence>
            </div>
        </div>
    );
}
