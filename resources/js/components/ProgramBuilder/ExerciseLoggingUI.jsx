import React, { useState } from 'react';
import { motion } from 'framer-motion';

export default function ExerciseLoggingUI({ exerciseName = "Barbell Bench Press", targetSets = 3, targetReps = "8-10" }) {
    const [unit, setUnit] = useState('KG');
    const [sets, setSets] = useState([{ id: 1, weight: '', reps: '', rpe: '', tempo: '2-0-2-0', rest: '90s', completed: false }]);
    const [notes, setNotes] = useState('');

    const addSet = () => {
        const lastSet = sets[sets.length - 1];
        setSets([...sets, { 
            id: sets.length + 1, 
            weight: lastSet?.weight || '', 
            reps: lastSet?.reps || '', 
            rpe: lastSet?.rpe || '', 
            tempo: lastSet?.tempo || '2-0-2-0', 
            rest: lastSet?.rest || '90s',
            completed: false 
        }]);
    };

    const updateSet = (id, field, value) => {
        setSets(sets.map(s => s.id === id ? { ...s, [field]: value } : s));
    };

    const toggleComplete = (id) => {
        setSets(sets.map(s => s.id === id ? { ...s, completed: !s.completed } : s));
    };

    return (
        <div className="bg-slate-950 border border-white/5 rounded-2xl p-6 shadow-xl w-full max-w-3xl">
            {/* Header */}
            <div className="flex justify-between items-start mb-6">
                <div>
                    <h3 className="text-xl font-bold text-white tracking-tight">{exerciseName}</h3>
                    <p className="text-sm text-emerald-400 mt-1 font-medium">Target: {targetSets} Sets × {targetReps} Reps</p>
                </div>
                
                {/* Unit Toggle */}
                <div className="flex bg-slate-900 rounded-lg p-1 border border-white/10">
                    <button 
                        onClick={() => setUnit('KG')}
                        className={`px-3 py-1 rounded-md text-xs font-bold transition ${unit === 'KG' ? 'bg-emerald-500 text-black shadow-md' : 'text-slate-400 hover:text-white'}`}
                    >
                        KG
                    </button>
                    <button 
                        onClick={() => setUnit('LB')}
                        className={`px-3 py-1 rounded-md text-xs font-bold transition ${unit === 'LB' ? 'bg-emerald-500 text-black shadow-md' : 'text-slate-400 hover:text-white'}`}
                    >
                        LB
                    </button>
                </div>
            </div>

            {/* Previous Performance Auto-fill Hint */}
            <div className="mb-4 px-4 py-2 bg-sky-900/20 border border-sky-500/20 rounded-lg flex items-center justify-between">
                <span className="text-xs text-sky-300 font-medium">Previous: 80 {unit} × 8 reps @ RPE 8</span>
                <button className="text-xs bg-sky-500/20 hover:bg-sky-500/40 text-sky-300 px-3 py-1 rounded-full transition">Auto-fill</button>
            </div>

            {/* Set Headers */}
            <div className="grid grid-cols-12 gap-2 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 px-2 hidden sm:grid">
                <div className="col-span-1 text-center">Set</div>
                <div className="col-span-2">Weight</div>
                <div className="col-span-2">Reps</div>
                <div className="col-span-2">RPE</div>
                <div className="col-span-2">Tempo</div>
                <div className="col-span-2">Rest</div>
                <div className="col-span-1 text-center">✓</div>
            </div>

            {/* Sets Rows */}
            <div className="space-y-3">
                {sets.map((set, index) => (
                    <motion.div 
                        initial={{ opacity: 0, y: -10 }}
                        animate={{ opacity: 1, y: 0 }}
                        key={set.id} 
                        className={`grid grid-cols-1 sm:grid-cols-12 gap-2 items-center p-3 sm:p-2 rounded-xl transition-all duration-300 ${set.completed ? 'bg-emerald-900/10 border border-emerald-500/20' : 'bg-slate-900 border border-white/5'}`}
                    >
                        <div className="col-span-1 flex justify-between sm:justify-center items-center mb-2 sm:mb-0">
                            <span className="sm:hidden text-xs text-slate-500 uppercase font-bold">Set</span>
                            <div className="w-6 h-6 rounded-full bg-slate-800 flex items-center justify-center text-xs font-bold text-slate-300">
                                {index + 1}
                            </div>
                        </div>

                        {/* Weight */}
                        <div className="col-span-1 sm:col-span-2 relative">
                            <span className="sm:hidden text-xs text-slate-500 block mb-1">Weight ({unit})</span>
                            <input 
                                type="number" 
                                value={set.weight}
                                onChange={(e) => updateSet(set.id, 'weight', e.target.value)}
                                className={`w-full bg-slate-950 border ${set.completed ? 'border-emerald-500/30 text-emerald-400' : 'border-slate-700 text-white'} rounded-lg px-3 py-2 text-sm font-semibold focus:ring-1 focus:ring-emerald-500 outline-none`}
                                placeholder={`0`}
                                disabled={set.completed}
                            />
                        </div>

                        {/* Reps */}
                        <div className="col-span-1 sm:col-span-2">
                            <span className="sm:hidden text-xs text-slate-500 block mb-1">Reps</span>
                            <input 
                                type="number" 
                                value={set.reps}
                                onChange={(e) => updateSet(set.id, 'reps', e.target.value)}
                                className={`w-full bg-slate-950 border ${set.completed ? 'border-emerald-500/30 text-emerald-400' : 'border-slate-700 text-white'} rounded-lg px-3 py-2 text-sm font-semibold focus:ring-1 focus:ring-emerald-500 outline-none`}
                                placeholder="0"
                                disabled={set.completed}
                            />
                        </div>

                        {/* RPE */}
                        <div className="col-span-1 sm:col-span-2">
                            <span className="sm:hidden text-xs text-slate-500 block mb-1">RPE (1-10)</span>
                            <input 
                                type="number" 
                                value={set.rpe}
                                onChange={(e) => updateSet(set.id, 'rpe', e.target.value)}
                                className="w-full bg-slate-950 border border-slate-700 text-white rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-emerald-500 outline-none"
                                placeholder="e.g. 8"
                                disabled={set.completed}
                            />
                        </div>

                        {/* Tempo */}
                        <div className="col-span-1 sm:col-span-2">
                            <span className="sm:hidden text-xs text-slate-500 block mb-1">Tempo</span>
                            <input 
                                type="text" 
                                value={set.tempo}
                                onChange={(e) => updateSet(set.id, 'tempo', e.target.value)}
                                className="w-full bg-slate-950 border border-slate-700 text-slate-400 rounded-lg px-3 py-2 text-xs focus:ring-1 focus:ring-emerald-500 outline-none"
                                disabled={set.completed}
                            />
                        </div>

                        {/* Rest */}
                        <div className="col-span-1 sm:col-span-2">
                            <span className="sm:hidden text-xs text-slate-500 block mb-1">Rest</span>
                            <select 
                                value={set.rest}
                                onChange={(e) => updateSet(set.id, 'rest', e.target.value)}
                                className="w-full bg-slate-950 border border-slate-700 text-slate-400 rounded-lg px-2 py-2 text-xs focus:ring-1 focus:ring-emerald-500 outline-none cursor-pointer"
                                disabled={set.completed}
                            >
                                <option value="60s">60s</option>
                                <option value="90s">90s</option>
                                <option value="120s">120s</option>
                                <option value="180s">180s</option>
                            </select>
                        </div>

                        {/* Complete Button */}
                        <div className="col-span-1 flex justify-end sm:justify-center mt-3 sm:mt-0">
                            <button 
                                onClick={() => toggleComplete(set.id)}
                                className={`w-8 h-8 rounded-lg flex items-center justify-center transition-all ${set.completed ? 'bg-emerald-500 text-black shadow-[0_0_15px_rgba(16,185,129,0.5)]' : 'bg-slate-800 text-slate-500 hover:bg-slate-700'}`}
                            >
                                ✓
                            </button>
                        </div>
                    </motion.div>
                ))}
            </div>

            {/* Actions */}
            <div className="mt-4 flex gap-3">
                <button 
                    onClick={addSet}
                    className="flex-1 py-2 rounded-xl border border-dashed border-slate-600 text-slate-400 text-sm font-semibold hover:border-emerald-500 hover:text-emerald-400 transition"
                >
                    + Add Set
                </button>
            </div>

            {/* Notes Section */}
            <div className="mt-6">
                <input 
                    type="text" 
                    value={notes}
                    onChange={(e) => setNotes(e.target.value)}
                    placeholder="Add workout notes, technique cues, or how it felt..."
                    className="w-full bg-slate-900 border border-white/5 rounded-xl px-4 py-3 text-sm text-slate-300 focus:border-emerald-500/50 outline-none transition"
                />
            </div>
        </div>
    );
}
