import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import ExerciseModal from './ExerciseModal';

export default function CustomProgramBuilder() {
    const [days, setDays] = useState([
        { id: 1, name: 'Day 1: Push', exercises: ['Barbell Bench Press', 'Overhead Press'] }
    ]);
    const [programName, setProgramName] = useState('My Custom Split');
    const [modalOpen, setModalOpen] = useState(false);
    const [activeDayId, setActiveDayId] = useState(null);

    const addDay = () => {
        setDays([...days, { id: Date.now(), name: `Day ${days.length + 1}: Focus`, exercises: [] }]);
    };

    const openExerciseModal = (dayId) => {
        setActiveDayId(dayId);
        setModalOpen(true);
    };

    const handleSelectExercise = (exercise) => {
        setDays(days.map(d => {
            if (d.id === activeDayId) {
                return { ...d, exercises: [...d.exercises, exercise.name] };
            }
            return d;
        }));
        setModalOpen(false);
        setActiveDayId(null);
    };

    const removeExercise = (dayId, exIdx) => {
        setDays(days.map(d => {
            if (d.id === dayId) {
                const newEx = [...d.exercises];
                newEx.splice(exIdx, 1);
                return { ...d, exercises: newEx };
            }
            return d;
        }));
    };

    return (
        <div className="max-w-5xl mx-auto">
            {/* Header */}
            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <input 
                    type="text" 
                    value={programName}
                    onChange={(e) => setProgramName(e.target.value)}
                    className="bg-transparent border-none text-3xl font-extrabold text-white focus:ring-0 p-0 outline-none w-full sm:w-auto"
                />
                <button className="bg-emerald-400 hover:bg-emerald-300 text-black px-6 py-2.5 rounded-full font-bold shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] transition-all">
                    Save Program
                </button>
            </div>

            {/* Days Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <AnimatePresence>
                    {days.map((day, idx) => (
                        <motion.div 
                            initial={{ opacity: 0, scale: 0.95 }}
                            animate={{ opacity: 1, scale: 1 }}
                            exit={{ opacity: 0, scale: 0.95 }}
                            key={day.id} 
                            className="bg-slate-950/80 border border-white/10 rounded-[2rem] p-6 backdrop-blur-xl flex flex-col h-full"
                        >
                            <div className="flex justify-between items-center mb-6 border-b border-white/5 pb-4">
                                <input 
                                    type="text" 
                                    value={day.name}
                                    onChange={(e) => {
                                        const newDays = [...days];
                                        newDays[idx].name = e.target.value;
                                        setDays(newDays);
                                    }}
                                    className="bg-transparent border-none text-lg font-bold text-emerald-400 focus:ring-0 p-0 outline-none w-full"
                                />
                                <button className="text-slate-500 hover:text-rose-400 transition ml-2">×</button>
                            </div>

                            <div className="flex-1 space-y-3">
                                {day.exercises.map((ex, exIdx) => (
                                    <div key={exIdx} className="group flex items-center gap-3 bg-slate-900 border border-white/5 p-3 rounded-xl cursor-grab hover:border-emerald-500/30 transition">
                                        <div className="text-slate-600 cursor-grab px-1">
                                            ⋮⋮
                                        </div>
                                        <div className="flex-1">
                                            <input 
                                                type="text" 
                                                value={ex}
                                                onChange={(e) => {
                                                    const newDays = [...days];
                                                    newDays[idx].exercises[exIdx] = e.target.value;
                                                    setDays(newDays);
                                                }}
                                                className="bg-transparent border-none text-sm text-slate-200 focus:ring-0 p-0 outline-none w-full font-medium"
                                            />
                                        </div>
                                        <button onClick={() => removeExercise(day.id, exIdx)} className="text-slate-600 hover:text-rose-400 opacity-0 group-hover:opacity-100 transition">
                                            ×
                                        </button>
                                    </div>
                                ))}
                                
                                <button 
                                    onClick={() => openExerciseModal(day.id)}
                                    className="w-full py-3 border border-dashed border-slate-700 rounded-xl text-slate-400 text-sm font-semibold hover:text-emerald-400 hover:border-emerald-500 hover:bg-emerald-500/5 transition mt-2"
                                >
                                    + Add Exercise
                                </button>
                            </div>
                        </motion.div>
                    ))}
                </AnimatePresence>

                {/* Add Day Button */}
                <motion.button 
                    whileHover={{ scale: 1.02 }}
                    whileTap={{ scale: 0.98 }}
                    onClick={addDay}
                    className="min-h-[300px] border-2 border-dashed border-slate-700/50 rounded-[2rem] flex flex-col items-center justify-center text-slate-500 hover:text-emerald-400 hover:border-emerald-500/50 hover:bg-emerald-500/5 transition gap-3 group"
                >
                    <div className="w-12 h-12 rounded-full bg-slate-800 group-hover:bg-emerald-500/20 flex items-center justify-center text-2xl transition">
                        +
                    </div>
                    <span className="font-bold tracking-wider uppercase text-sm">Add Workout Day</span>
                </motion.button>
            </div>

            <ExerciseModal 
                isOpen={modalOpen} 
                onClose={() => setModalOpen(false)} 
                onSelectExercise={handleSelectExercise} 
            />
        </div>
    );
}
