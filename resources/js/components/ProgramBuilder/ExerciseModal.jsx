import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Search, X, Dumbbell, Activity, Flame, ChevronRight } from 'lucide-react';

export default function ExerciseModal({ isOpen, onClose, onSelectExercise }) {
    const [searchQuery, setSearchQuery] = useState('');
    const [exercises, setExercises] = useState([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    const defaultExercises = [
        { id: '1', name: 'Barbell Bench Press', target: 'Chest', equipment: 'Barbell', gifUrl: '' },
        { id: '2', name: 'Dumbbell Incline Press', target: 'Chest', equipment: 'Dumbbell', gifUrl: '' },
        { id: '3', name: 'Cable Crossover', target: 'Chest', equipment: 'Cable', gifUrl: '' },
        { id: '4', name: 'Barbell Squat', target: 'Legs', equipment: 'Barbell', gifUrl: '' },
        { id: '5', name: 'Leg Press', target: 'Legs', equipment: 'Machine', gifUrl: '' },
    ];

    useEffect(() => {
        if (!isOpen) return;

        const fetchExercises = async () => {
            setLoading(true);
            setError(null);
            try {
                let url = 'https://exercise-db-fitness-workout-gym.p.rapidapi.com/exercises?limit=20';
                if (searchQuery) {
                    url = `https://exercise-db-fitness-workout-gym.p.rapidapi.com/exercises/name/${searchQuery}?limit=20`;
                }

                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'x-rapidapi-key': 'a9931bd4abmshf80a226cdde0fe6p171cbcjsn0e3db25093d2',
                        'x-rapidapi-host': 'exercise-db-fitness-workout-gym.p.rapidapi.com'
                    }
                });

                if (!response.ok) throw new Error('API Error');
                const data = await response.json();
                setExercises(Array.isArray(data) ? data : defaultExercises);
            } catch (err) {
                setExercises(searchQuery ? defaultExercises.filter(e => e.name.toLowerCase().includes(searchQuery.toLowerCase())) : defaultExercises);
            } finally {
                setLoading(false);
            }
        };

        const timeoutId = setTimeout(fetchExercises, 500);
        return () => clearTimeout(timeoutId);
    }, [isOpen, searchQuery]);

    if (!isOpen) return null;

    return (
        <AnimatePresence>
            <motion.div 
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                exit={{ opacity: 0 }}
                className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/40 backdrop-blur-md"
            >
                <motion.div 
                    initial={{ scale: 0.9, opacity: 0 }}
                    animate={{ scale: 1, opacity: 1 }}
                    exit={{ scale: 0.9, opacity: 0 }}
                    className="w-full max-w-2xl bg-white rounded-[3rem] overflow-hidden shadow-2xl flex flex-col h-[75vh] border border-black/5"
                >
                    {/* Header */}
                    <div className="p-8 border-b border-black/5 flex justify-between items-center bg-slate-50/50">
                        <div>
                            <h2 className="text-2xl font-bold text-slate-900 flex items-center gap-3">
                                <div className="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center shadow-lg shadow-orange-500/20">
                                    <Dumbbell size={20} />
                                </div>
                                Select Exercise
                            </h2>
                            <p className="text-slate-400 text-sm font-medium mt-1">Browse the premium database</p>
                        </div>
                        <button onClick={onClose} className="w-10 h-10 rounded-full border border-black/5 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-colors">
                            <X size={20} />
                        </button>
                    </div>

                    {/* Search */}
                    <div className="p-8 pb-4">
                        <div className="relative group">
                            <Search className="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors" size={20} />
                            <input 
                                type="text" 
                                placeholder="Search e.g. Bench Press"
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                                className="w-full bg-slate-50 border border-black/5 rounded-2xl py-4 pl-14 pr-4 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all font-medium"
                            />
                        </div>
                    </div>

                    {/* Results */}
                    <div className="flex-1 overflow-y-auto px-8 pb-8 space-y-4 no-scrollbar">
                        {loading ? (
                            <div className="flex flex-col items-center justify-center h-full gap-4">
                                <div className="w-10 h-10 border-4 border-orange-500 border-t-transparent rounded-full animate-spin"></div>
                                <p className="text-slate-400 font-bold text-sm">Searching AI Library...</p>
                            </div>
                        ) : exercises.length > 0 ? (
                            exercises.map((ex) => (
                                <motion.div 
                                    whileHover={{ x: 5 }}
                                    key={ex.id}
                                    onClick={() => onSelectExercise(ex)}
                                    className="bg-white border border-black/5 p-4 rounded-3xl flex items-center justify-between cursor-pointer hover:bg-slate-50 hover:border-orange-500/20 transition-all group shadow-sm"
                                >
                                    <div className="flex items-center gap-5">
                                        <div className="w-16 h-16 rounded-2xl bg-slate-50 overflow-hidden flex items-center justify-center border border-black/5">
                                            {ex.gifUrl ? (
                                                <img src={ex.gifUrl} alt={ex.name} className="w-full h-full object-cover mix-blend-multiply" />
                                            ) : (
                                                <Dumbbell className="text-slate-300" size={24} />
                                            )}
                                        </div>
                                        <div>
                                            <h3 className="font-bold text-slate-900 capitalize group-hover:text-orange-500 transition-colors">{ex.name}</h3>
                                            <div className="flex items-center gap-3 mt-1.5">
                                                <span className="text-[10px] font-bold uppercase tracking-widest text-orange-500 bg-orange-50 px-2.5 py-1 rounded-full">{ex.target || 'General'}</span>
                                                <span className="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                                    <Activity size={12} /> {ex.equipment || 'Bodyweight'}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="w-10 h-10 rounded-full border border-black/5 flex items-center justify-center text-slate-400 group-hover:bg-orange-500 group-hover:text-white group-hover:border-orange-500 transition-all">
                                        <ChevronRight size={18} />
                                    </div>
                                </motion.div>
                            ))
                        ) : (
                            <div className="flex flex-col items-center justify-center h-full text-slate-400 text-sm font-bold">
                                <Flame size={40} className="mb-4 text-slate-200" />
                                <p>No results found</p>
                            </div>
                        )}
                    </div>
                </motion.div>
            </motion.div>
        </AnimatePresence>
    );
}
