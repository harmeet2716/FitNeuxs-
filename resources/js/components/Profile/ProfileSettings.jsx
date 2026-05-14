import React, { useState, useCallback } from 'react';
import Cropper from 'react-easy-crop';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    User, Mail, Camera, Weight, Ruler, Target, 
    Activity, Save, Check, AlertCircle, Info
} from 'lucide-react';

const SegmentedControl = ({ options, value, onChange }) => (
    <div className="flex bg-slate-900/50 p-1 rounded-lg border border-white/5">
        {options.map((opt) => (
            <button
                key={opt}
                onClick={() => onChange(opt)}
                className={`px-3 py-1 text-[10px] font-bold rounded-md transition-all ${
                    value === opt 
                    ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' 
                    : 'text-slate-500 hover:text-slate-300'
                }`}
            >
                {opt}
            </button>
        ))}
    </div>
);

const ProfessionalInput = ({ label, icon: Icon, value, onChange, type = "text", placeholder }) => (
    <div className="space-y-2 group">
        <label className="text-[11px] font-bold uppercase tracking-wider text-slate-400 group-focus-within:text-emerald-400 transition-colors">
            {label}
        </label>
        <div className="relative">
            <div className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-emerald-400 transition-colors">
                <Icon size={18} />
            </div>
            <input 
                type={type}
                value={value}
                onChange={(e) => onChange(e.target.value)}
                placeholder={placeholder}
                className="w-full bg-slate-900/40 border border-white/5 rounded-xl py-3.5 pl-12 pr-4 text-white font-medium focus:ring-1 focus:ring-emerald-500/30 focus:border-emerald-500/50 outline-none transition-all"
            />
        </div>
    </div>
);

const RedesignedMetricCard = ({ label, value, onChange, units, currentUnit, onUnitToggle, icon: Icon, colorClass }) => (
    <div className="bg-slate-900/40 border border-white/5 rounded-2xl p-6 hover:border-emerald-500/20 transition-all">
        <div className="flex justify-between items-center mb-6">
            <div className="flex items-center gap-3">
                <div className={`p-2 rounded-lg bg-${colorClass}-500/10 text-${colorClass}-500`}>
                    <Icon size={18} />
                </div>
                <span className="text-xs font-bold text-slate-400 uppercase tracking-widest">{label}</span>
            </div>
            <SegmentedControl options={units} value={currentUnit} onChange={onUnitToggle} />
        </div>
        <div className="relative flex items-baseline gap-2">
            <input 
                type="number"
                value={value}
                onChange={(e) => onChange(e.target.value)}
                className="bg-transparent border-none p-0 text-4xl font-bold text-white focus:ring-0 w-full"
            />
            <span className="text-slate-500 font-bold text-sm uppercase">{currentUnit}</span>
        </div>
    </div>
);

export default function ProfileSettings({ user, fitnessProfile }) {
    if (!user) return null;

    // State
    const [name, setName] = useState(user.name);
    const [email, setEmail] = useState(user.email);
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
        // Add save logic here...
        await new Promise(r => setTimeout(r, 1000));
        setSaved(true);
        setSaving(false);
        setTimeout(() => setSaved(false), 3000);
    };

    return (
        <div className="min-h-screen bg-[#0B0F1A] text-white font-inter selection:bg-emerald-500/30">
            <div className="max-w-5xl mx-auto px-6 py-12 space-y-12">
                
                {/* Header Section */}
                <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 pb-8 border-b border-white/5">
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight mb-2">Profile Settings</h1>
                        <p className="text-slate-400 text-sm">Manage your account credentials and biometric synchronization.</p>
                    </div>
                    <button 
                        onClick={handleSave}
                        disabled={saving}
                        className={`px-8 py-3 rounded-xl font-bold text-sm transition-all flex items-center gap-2 shadow-lg shadow-emerald-500/10 ${
                            saved ? 'bg-emerald-600 text-white' : 'bg-emerald-500 text-white hover:bg-emerald-400'
                        }`}
                    >
                        {saving ? (
                            <div className="w-4 h-4 border-2 border-white/20 border-t-white rounded-full animate-spin" />
                        ) : saved ? <Check size={18} /> : <Save size={18} />}
                        {saved ? 'Changes Saved' : 'Update Profile'}
                    </button>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-12 gap-12">
                    
                    {/* Account Section */}
                    <div className="lg:col-span-4 space-y-10">
                        
                        {/* Profile Image */}
                        <div className="flex flex-col items-center group">
                            <div className="relative w-40 h-40 rounded-full p-1 border-2 border-slate-800 group-hover:border-emerald-500/50 transition-colors duration-500">
                                <div className="w-full h-full rounded-full overflow-hidden bg-slate-900 border border-white/5">
                                    {user.profile_photo_path ? (
                                        <img src={`/storage/${user.profile_photo_path}`} alt="Profile" className="w-full h-full object-cover" />
                                    ) : (
                                        <div className="w-full h-full flex items-center justify-center text-3xl font-bold text-slate-500 bg-slate-800">
                                            {user.name.charAt(0)}
                                        </div>
                                    )}
                                </div>
                                <label className="absolute bottom-1 right-1 p-2.5 bg-emerald-500 text-white rounded-xl shadow-xl cursor-pointer hover:bg-emerald-400 transition-colors border-2 border-[#0B0F1A]">
                                    <Camera size={18} />
                                    <input type="file" className="hidden" accept="image/*" onChange={handleFileChange} />
                                </label>
                            </div>
                            <h3 className="mt-6 text-xl font-bold">{name}</h3>
                            <p className="text-slate-500 text-xs font-medium uppercase tracking-widest mt-1">{email}</p>
                        </div>

                        {/* Account Fields */}
                        <div className="space-y-6 pt-6 border-t border-white/5">
                            <h4 className="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-4">Account Credentials</h4>
                            <ProfessionalInput 
                                label="Display Name" 
                                icon={User} 
                                value={name} 
                                onChange={setName} 
                                placeholder="Your full name"
                            />
                            <ProfessionalInput 
                                label="Email Address" 
                                icon={Mail} 
                                value={email} 
                                onChange={setEmail} 
                                type="email"
                                placeholder="name@example.com"
                            />
                        </div>
                    </div>

                    {/* Biometrics Section */}
                    <div className="lg:col-span-8 space-y-8">
                        <h4 className="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Physical Matrix</h4>
                        
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <RedesignedMetricCard 
                                label="Current Weight"
                                value={weight}
                                onChange={setWeight}
                                units={['KG', 'LB']}
                                currentUnit={weightUnit}
                                onUnitToggle={setWeightUnit}
                                icon={Weight}
                                colorClass="emerald"
                            />
                            <RedesignedMetricCard 
                                label="Height"
                                value={height}
                                onChange={setHeight}
                                units={['CM', 'IN']}
                                currentUnit={heightUnit}
                                onUnitToggle={setHeightUnit}
                                icon={Ruler}
                                colorClass="blue"
                            />
                        </div>

                        {/* BMI & Analysis */}
                        <div className="bg-slate-900/40 border border-white/5 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-8">
                            <div className="flex items-center gap-6">
                                <div className="p-4 rounded-2xl bg-white/5 border border-white/10">
                                    <div className="text-3xl font-bold text-emerald-400">{bmiValue || '--'}</div>
                                    <div className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1 text-center">BMI</div>
                                </div>
                                <div>
                                    <h5 className="font-bold text-lg">Metabolic State</h5>
                                    <p className="text-slate-400 text-sm">Your synchronization is currently <span className="text-emerald-400 font-bold">Stable</span>.</p>
                                </div>
                            </div>
                            <div className="flex items-center gap-2 text-xs font-bold text-slate-500 bg-white/5 px-4 py-2 rounded-lg">
                                <Info size={14} />
                                BMI data is calculated in real-time.
                            </div>
                        </div>

                        {/* Goal Progress */}
                        <div className="space-y-6 pt-4">
                            <div className="flex justify-between items-end">
                                <div>
                                    <h4 className="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-2">Target Trajectory</h4>
                                    <h3 className="text-2xl font-bold flex items-center gap-3">
                                        <Target className="text-emerald-500" size={24} />
                                        Progress to {goalWeight || '--'} {weightUnit}
                                    </h3>
                                </div>
                                <div className="text-right">
                                    <span className="text-slate-500 text-[10px] font-bold uppercase tracking-widest block mb-1">Status</span>
                                    <span className="text-emerald-400 font-bold">On Track</span>
                                </div>
                            </div>

                            <div className="relative h-2 bg-slate-800 rounded-full overflow-hidden">
                                <motion.div 
                                    initial={{ width: 0 }}
                                    animate={{ width: weight && goalWeight ? '72%' : '0%' }}
                                    className="h-full bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.4)]"
                                />
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                                <div className="space-y-2">
                                    <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Adjust Target</label>
                                    <input 
                                        type="number"
                                        value={goalWeight}
                                        onChange={(e) => setGoalWeight(e.target.value)}
                                        className="w-full bg-slate-900/40 border border-white/5 rounded-xl py-3 px-4 text-xl font-bold text-white focus:border-emerald-500/50 outline-none transition-all"
                                    />
                                </div>
                                <div className="p-5 rounded-xl bg-emerald-500/5 border border-emerald-500/10 flex items-start gap-4">
                                    <AlertCircle className="text-emerald-500 shrink-0 mt-0.5" size={18} />
                                    <p className="text-xs text-slate-400 leading-relaxed">
                                        Your metabolic trajectory is optimized. Maintain current protocols to reach your target by the projected cycle.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Cropper Modal */}
                <AnimatePresence>
                    {showCropper && (
                        <motion.div 
                            initial={{ opacity: 0 }} animate={{ opacity: 1 }} exit={{ opacity: 0 }}
                            className="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-950/90 backdrop-blur-md"
                        >
                            <div className="w-full max-w-xl bg-[#0F172A] rounded-2xl border border-white/10 overflow-hidden shadow-2xl">
                                <div className="p-6 border-b border-white/5 flex justify-between items-center">
                                    <h3 className="font-bold text-lg">Adjust Profile Image</h3>
                                    <button onClick={() => setShowCropper(false)} className="text-slate-500 hover:text-white transition-colors"><Save size={18} /></button>
                                </div>
                                <div className="relative h-[350px] bg-black">
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
                                <div className="p-8 space-y-8">
                                    <div className="space-y-4">
                                        <div className="flex justify-between text-xs font-bold text-slate-500">
                                            <span>Zoom Level</span>
                                            <span className="text-emerald-400">{(zoom * 100).toFixed(0)}%</span>
                                        </div>
                                        <input 
                                            type="range" min={1} max={3} step={0.1} value={zoom}
                                            onChange={(e) => setZoom(e.target.value)}
                                            className="w-full h-1.5 bg-slate-800 rounded-full appearance-none accent-emerald-500"
                                        />
                                    </div>
                                    <button 
                                        onClick={() => setShowCropper(false)}
                                        className="w-full py-4 bg-emerald-500 text-white font-bold rounded-xl hover:bg-emerald-400 transition-colors shadow-lg shadow-emerald-500/20"
                                    >
                                        Apply Changes
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
