import React, { useState, useCallback, useEffect } from 'react';
import Cropper from 'react-easy-crop';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    User, Mail, Camera, Weight, Ruler, Target, 
    Activity, ChevronRight, Save, LogOut, Check
} from 'lucide-react';
import axios from 'axios';

const MetricCard = ({ label, value, unit, icon: Icon, color, onChange, units, currentUnit, onUnitToggle, footer }) => (
    <div className="p-8 rounded-[2rem] bg-white/5 border border-white/10 backdrop-blur-xl hover:border-cyan-500/30 transition-all group shadow-2xl">
        <div className="flex justify-between items-center mb-8">
            <div className="flex items-center gap-3">
                <div className={`w-10 h-10 rounded-xl bg-${color}-500/10 flex items-center justify-center text-${color}-500`}>
                    <Icon size={20} />
                </div>
                <label className="text-white/40 text-[10px] font-black uppercase tracking-[0.3em]">{label}</label>
            </div>
            <div className="flex bg-black/40 rounded-full p-1 border border-white/5">
                {units.map(u => (
                    <button 
                        key={u}
                        onClick={() => onUnitToggle(u)}
                        className={`px-4 py-1.5 text-[9px] font-black rounded-full transition-all uppercase tracking-widest ${currentUnit === u ? 'bg-cyan-glow text-black shadow-lg shadow-cyan-500/20' : 'text-white/20'}`}
                    >
                        {u}
                    </button>
                ))}
            </div>
        </div>
        
        <div className="relative group/input">
            <input 
                type="number" 
                value={value}
                onChange={(e) => onChange(e.target.value)}
                className="w-full bg-transparent border-none text-5xl font-black text-white focus:ring-0 outline-none transition-colors p-0 tracking-tighter" 
                placeholder="00.0"
            />
            <span className="absolute right-0 bottom-2 text-cyan-400/30 font-black uppercase text-xs tracking-widest">{currentUnit}</span>
            <div className="absolute bottom-0 left-0 w-full h-px bg-white/5 group-hover/input:bg-cyan-500/30 transition-all"></div>
        </div>

        {footer && (
            <div className="mt-6 pt-6 border-t border-white/5">
                {footer}
            </div>
        )}
    </div>
);

export default function ProfileSettings({ user, fitnessProfile }) {
    if (!user) {
        return (
            <div className="flex items-center justify-center min-h-[400px]">
                <div className="animate-pulse text-cyan-400 font-black tracking-widest uppercase">Initializing Neural Link...</div>
            </div>
        );
    }

    // Account Info
    const [name, setName] = useState(user.name);
    const [email, setEmail] = useState(user.email);
    
    // Biometrics
    const [weight, setWeight] = useState(fitnessProfile?.weight_kg || '');
    const [height, setHeight] = useState(fitnessProfile?.height_cm || '');
    const [goalWeight, setGoalWeight] = useState(fitnessProfile?.goal_weight_kg || '');
    const [weightUnit, setWeightUnit] = useState('KG');
    const [heightUnit, setHeightUnit] = useState('CM');

    // Avatar
    const [image, setImage] = useState(null);
    const [crop, setCrop] = useState({ x: 0, y: 0 });
    const [zoom, setZoom] = useState(1);
    const [croppedAreaPixels, setCroppedAreaPixels] = useState(null);
    const [showCropper, setShowCropper] = useState(false);
    
    // Status
    const [saving, setSaving] = useState(false);
    const [saved, setSaved] = useState(false);

    // BMI Calculation
    const calculateBMI = useCallback(() => {
        if (!weight || !height) return null;
        const w = weightUnit === 'LB' ? weight * 0.453592 : weight;
        const h = heightUnit === 'IN' ? height * 0.0254 : height / 100;
        const bmi = (w / (h * h)).toFixed(1);
        return parseFloat(bmi);
    }, [weight, height, weightUnit, heightUnit]);

    const bmiValue = calculateBMI();
    
    const getBMIGlow = (bmi) => {
        if (!bmi) return 'text-white/20';
        if (bmi < 18.5) return 'text-yellow-400 drop-shadow-[0_0_8px_rgba(250,204,21,0.5)]';
        if (bmi < 25) return 'text-cyan-400 drop-shadow-[0_0_8px_rgba(34,211,238,0.5)]';
        if (bmi < 30) return 'text-orange-400 drop-shadow-[0_0_8px_rgba(251,146,60,0.5)]';
        return 'text-rose-400 drop-shadow-[0_0_8px_rgba(251,113,133,0.5)]';
    };

    const getBMILabel = (bmi) => {
        if (!bmi) return 'Incomplete Data';
        if (bmi < 18.5) return 'Underweight Protocol';
        if (bmi < 25) return 'Optimal Bio-State';
        if (bmi < 30) return 'Systemic Overload';
        return 'Critical Mass Warning';
    };

    const onCropComplete = useCallback((croppedArea, croppedAreaPixels) => {
        setCroppedAreaPixels(croppedAreaPixels);
    }, []);

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
        setSaved(false);

        const formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('weight_kg', weightUnit === 'LB' ? weight * 0.453592 : weight);
        formData.append('height_cm', heightUnit === 'IN' ? height * 2.54 : height);
        formData.append('goal_weight_kg', goalWeight);
        
        if (croppedAreaPixels) {
            formData.append('crop_data', JSON.stringify(croppedAreaPixels));
            // In a real app, you'd also send the raw image or a blob
        }

        try {
            // Simulated save for UI feedback
            await new Promise(r => setTimeout(r, 1500));
            setSaved(true);
            setTimeout(() => setSaved(false), 3000);
        } catch (error) {
            console.error(error);
        } finally {
            setSaving(false);
        }
    };

    return (
        <div className="max-w-6xl mx-auto px-6 py-12 space-y-12 pb-32">
            {/* Page Header */}
            <div className="flex flex-col md:flex-row justify-between items-end gap-8">
                <div>
                    <div className="flex items-center gap-3 mb-4">
                        <span className="px-4 py-1 bg-cyan- glow/20 text-cyan-400 rounded-full text-[10px] font-black uppercase tracking-[0.3em] border border-cyan-400/20 shadow-[0_0_15px_rgba(0,242,255,0.2)]">Identity Sync</span>
                        <span className="text-white/20 text-xs font-black uppercase tracking-[0.2em]">Profile Architecture v4.2</span>
                    </div>
                    <h1 className="text-7xl font-black text-white tracking-tighter leading-none italic">
                        Neural <span className="text-cyan-glow not-italic">Sync</span>
                    </h1>
                </div>
                <div className="flex gap-4">
                    <button 
                        onClick={handleSave}
                        disabled={saving}
                        className={`px-12 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.3em] transition-all flex items-center gap-3 ${
                            saved ? 'bg-emerald-500 text-white' : 'bg-white text-black hover:scale-105 active:scale-95'
                        } shadow-2xl`}
                    >
                        {saving ? 'Syncing...' : saved ? (
                            <><Check size={18} /> Protocol Updated</>
                        ) : (
                            <><Save size={18} /> Update Matrix</>
                        )}
                    </button>
                </div>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                {/* Left Column: Identity & Account */}
                <div className="lg:col-span-4 space-y-8">
                    {/* Avatar Panel */}
                    <div className="bg-white/5 backdrop-blur-3xl border border-white/10 rounded-[3rem] p-10 text-center relative overflow-hidden group shadow-2xl">
                        <div className="absolute inset-0 bg-gradient-to-b from-cyan-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <div className="relative z-10">
                            <div className="relative w-48 h-48 mx-auto mb-10">
                                <div className="absolute inset-0 rounded-full border-2 border-dashed border-white/10 group-hover:border-cyan-400/50 group-hover:rotate-180 transition-all duration-1000"></div>
                                <div className="absolute -inset-4 rounded-full border border-white/5 animate-pulse"></div>
                                
                                <div className="w-full h-full rounded-full overflow-hidden border-4 border-white/10 bg-black shadow-[0_0_50px_rgba(0,0,0,0.5)]">
                                    {user.profile_photo_path ? (
                                        <img src={`/storage/${user.profile_photo_path}`} className="w-full h-full object-cover" alt="Profile" />
                                    ) : (
                                        <div className="w-full h-full flex items-center justify-center bg-cyan-950 text-cyan-400 text-6xl font-black italic">
                                            {user.name.charAt(0)}
                                        </div>
                                    )}
                                </div>

                                <label className="absolute bottom-0 right-0 w-14 h-14 bg-white text-black rounded-2xl flex items-center justify-center cursor-pointer shadow-2xl hover:scale-110 transition-transform active:scale-90 z-20">
                                    <Camera size={24} />
                                    <input type="file" className="hidden" accept="image/*" onChange={handleFileChange} />
                                </label>
                            </div>

                            <div className="space-y-2">
                                <h2 className="text-3xl font-black text-white tracking-tighter italic">{name}</h2>
                                <p className="text-white/20 font-bold text-xs uppercase tracking-widest">{email}</p>
                            </div>
                        </div>
                    </div>

                    {/* Account Settings */}
                    <div className="bg-white/5 backdrop-blur-3xl border border-white/10 rounded-[3rem] p-10 space-y-8 shadow-2xl">
                        <h3 className="text-[10px] font-black uppercase tracking-[0.4em] text-white/30 border-b border-white/5 pb-6">Account Credentials</h3>
                        
                        <div className="space-y-6">
                            <div className="space-y-3">
                                <label className="text-[9px] font-black uppercase tracking-widest text-cyan-400/50">Full Identity Name</label>
                                <div className="relative group">
                                    <User className="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-cyan-400 transition-colors" size={18} />
                                    <input 
                                        type="text" 
                                        value={name}
                                        onChange={(e) => setName(e.target.value)}
                                        className="w-full bg-white/5 border border-white/5 rounded-2xl py-4 pl-12 pr-6 text-white font-bold text-sm focus:ring-1 focus:ring-cyan-400/30 focus:bg-white/10 transition-all outline-none"
                                    />
                                </div>
                            </div>

                            <div className="space-y-3">
                                <label className="text-[9px] font-black uppercase tracking-widest text-cyan-400/50">Neural Communication Path</label>
                                <div className="relative group">
                                    <Mail className="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-cyan-400 transition-colors" size={18} />
                                    <input 
                                        type="email" 
                                        value={email}
                                        onChange={(e) => setEmail(e.target.value)}
                                        className="w-full bg-white/5 border border-white/5 rounded-2xl py-4 pl-12 pr-6 text-white font-bold text-sm focus:ring-1 focus:ring-cyan-400/30 focus:bg-white/10 transition-all outline-none"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Right Column: Biometrics */}
                <div className="lg:col-span-8 space-y-10">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {/* Weight Input */}
                        <MetricCard 
                            label="Current Mass" 
                            value={weight}
                            onChange={setWeight}
                            unit={weightUnit}
                            units={['KG', 'LB']}
                            currentUnit={weightUnit}
                            onUnitToggle={setWeightUnit}
                            icon={Weight}
                            color="cyan"
                            footer={
                                <div className="flex justify-between items-center">
                                    <span className="text-white/20 text-[10px] font-black uppercase tracking-widest">Calculated BMI</span>
                                    <div className="flex items-center gap-3">
                                        <span className={`text-xl font-black ${getBMIGlow(bmiValue)}`}>{bmiValue || '--'}</span>
                                        <span className="text-white/20 text-[9px] font-bold uppercase tracking-widest">({getBMILabel(bmiValue)})</span>
                                    </div>
                                </div>
                            }
                        />

                        {/* Height Input */}
                        <MetricCard 
                            label="Elevation Profile" 
                            value={height}
                            onChange={setHeight}
                            unit={heightUnit}
                            units={['CM', 'IN']}
                            currentUnit={heightUnit}
                            onUnitToggle={setHeightUnit}
                            icon={Ruler}
                            color="purple"
                            footer={
                                <div className="flex gap-2">
                                    {[0.8, 0.5, 0.9, 0.4, 0.7, 0.3, 0.6, 0.8, 0.5, 0.9].map((h, i) => (
                                        <div key={i} className="flex-1 bg-white/5 rounded-full h-8 overflow-hidden">
                                            <motion.div 
                                                animate={{ height: `${h * 100}%` }}
                                                className="w-full bg-purple-500/20 bottom-0 absolute"
                                            />
                                        </div>
                                    ))}
                                </div>
                            }
                        />
                    </div>

                    {/* Goal Progress Section */}
                    <div className="bg-white/5 backdrop-blur-3xl border border-white/10 rounded-[3rem] p-12 shadow-2xl space-y-12">
                        <div className="flex justify-between items-center">
                            <div className="flex items-center gap-4">
                                <div className="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                                    <Target size={28} />
                                </div>
                                <div>
                                    <h3 className="text-2xl font-black text-white tracking-tight">Projected Target</h3>
                                    <p className="text-white/20 text-[10px] font-black uppercase tracking-widest">Bio-Synchronization Goal</p>
                                </div>
                            </div>
                            <div className="text-right">
                                <span className="text-white/20 text-[10px] font-black uppercase tracking-widest block mb-2">Distance to Goal</span>
                                <span className="text-3xl font-black text-white italic">{weight && goalWeight ? Math.abs(weight - goalWeight).toFixed(1) : '--'} <span className="text-sm font-bold opacity-30">KG</span></span>
                            </div>
                        </div>

                        <div className="space-y-6">
                            <div className="relative h-6 bg-black/40 rounded-full border border-white/5 overflow-hidden p-1">
                                <motion.div 
                                    initial={{ width: 0 }}
                                    animate={{ width: weight && goalWeight ? '65%' : '0%' }}
                                    className="h-full bg-gradient-to-r from-cyan-glow to-emerald-500 rounded-full shadow-[0_0_20px_rgba(0,242,255,0.4)]"
                                />
                                <div className="absolute top-0 left-[65%] w-0.5 h-full bg-white/20"></div>
                            </div>
                            <div className="flex justify-between text-[10px] font-black uppercase tracking-widest text-white/20">
                                <span>Current: {weight || '--'} KG</span>
                                <span className="text-cyan-400">Optimal Sync: 65%</span>
                                <span>Target: {goalWeight || '--'} KG</span>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-white/5">
                            <div className="space-y-4">
                                <label className="text-[10px] font-black uppercase tracking-[0.3em] text-white/30">Target Mass (KG)</label>
                                <input 
                                    type="number"
                                    value={goalWeight}
                                    onChange={(e) => setGoalWeight(e.target.value)}
                                    className="w-full bg-white/5 border border-white/5 rounded-2xl py-5 px-8 text-2xl font-black text-white focus:ring-1 focus:ring-emerald-400/30 transition-all outline-none"
                                />
                            </div>
                            <div className="bg-emerald-500/5 rounded-[2rem] p-8 border border-emerald-500/10 flex items-center gap-6">
                                <Activity className="text-emerald-500" size={32} />
                                <p className="text-xs font-bold text-white/40 leading-relaxed uppercase tracking-widest">Your metabolic trajectory is currently <span className="text-emerald-500">Accelerating</span> towards the target singularity.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* Cropper Modal */}
            <AnimatePresence>
                {showCropper && (
                    <motion.div 
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        className="fixed inset-0 z-[200] flex items-center justify-center p-10 backdrop-blur-3xl bg-black/80"
                    >
                        <div className="w-full max-w-2xl bg-[#0D0D0D] rounded-[3rem] border border-white/10 overflow-hidden shadow-[0_0_100px_rgba(0,0,0,1)]">
                            <div className="p-10 border-b border-white/5 flex justify-between items-center">
                                <h3 className="text-2xl font-black text-white tracking-tighter italic">Image Optimization</h3>
                                <button onClick={() => setShowCropper(false)} className="text-white/20 hover:text-white transition-colors uppercase text-[10px] font-black tracking-widest">Cancel Sync</button>
                            </div>
                            
                            <div className="relative h-[400px] w-full bg-black">
                                <Cropper
                                    image={image}
                                    crop={crop}
                                    zoom={zoom}
                                    aspect={1}
                                    cropShape="round"
                                    showGrid={false}
                                    onCropChange={setCrop}
                                    onCropComplete={onCropComplete}
                                    onZoomChange={setZoom}
                                />
                            </div>

                            <div className="p-10 space-y-10">
                                <div className="space-y-4">
                                    <div className="flex justify-between text-[10px] font-black uppercase tracking-widest text-white/20">
                                        <span>Optical Zoom</span>
                                        <span className="text-cyan-400">{(zoom * 100).toFixed(0)}%</span>
                                    </div>
                                    <input 
                                        type="range"
                                        min={1}
                                        max={3}
                                        step={0.1}
                                        value={zoom}
                                        onChange={(e) => setZoom(e.target.value)}
                                        className="w-full h-1 bg-white/10 rounded-full appearance-none cursor-pointer accent-cyan-400"
                                    />
                                </div>

                                <button 
                                    onClick={() => setShowCropper(false)}
                                    className="w-full py-5 bg-cyan-glow text-black rounded-2xl font-black text-xs uppercase tracking-[0.3em] shadow-[0_0_30px_rgba(0,242,255,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all"
                                >
                                    Confirm Visual Data
                                </button>
                            </div>
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>
        </div>
    );
}
