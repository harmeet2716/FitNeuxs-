import React, { useState, useMemo } from 'react';
import { 
    LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer, Area, AreaChart
} from 'recharts';
import { motion, AnimatePresence } from 'framer-motion';

const rawData = [
    { name: 'Jan', weight: 92, bodyFat: 28 },
    { name: 'Feb', weight: 89, bodyFat: 26 },
    { name: 'Mar', weight: 86, bodyFat: 24 },
    { name: 'Apr', weight: 84, bodyFat: 22 },
    { name: 'May', weight: 81, bodyFat: 20 },
];

const dataWithDifferences = rawData.map((data, index) => {
    if (index === 0) return { ...data, weightDiff: 0, bodyFatDiff: 0 };
    const prev = rawData[index - 1];
    return {
        ...data,
        weightDiff: (data.weight - prev.weight).toFixed(1),
        bodyFatDiff: (data.bodyFat - prev.bodyFat).toFixed(1)
    };
});

const CustomTooltip = ({ active, payload, label, unit }) => {
    if (active && payload && payload.length) {
        const data = payload[0].payload;
        const value = payload[0].value;
        const diffKey = payload[0].dataKey === 'weight' ? 'weightDiff' : 'bodyFatDiff';
        const diff = data[diffKey];
        const isNegative = diff <= 0;
        
        return (
            <div className="bg-white p-5 rounded-[1.5rem] shadow-2xl border border-black/5">
                <p className="text-slate-400 text-xs uppercase tracking-widest mb-3 font-bold">{label}</p>
                <div className="flex items-end gap-3">
                    <p className="text-3xl font-bold text-slate-900">
                        {value} <span className="text-sm font-medium text-slate-400">{unit}</span>
                    </p>
                    {diff != 0 && (
                        <div className={`flex items-center gap-1 text-xs font-bold mb-1.5 px-3 py-1 rounded-full ${isNegative ? 'bg-orange-50 text-orange-500' : 'bg-rose-50 text-rose-500'}`}>
                            <span>{isNegative ? '↓' : '↑'}</span>
                            <span>{Math.abs(diff)} {unit}</span>
                        </div>
                    )}
                </div>
            </div>
        );
    }
    return null;
};

const CustomizedDot = (props) => {
    const { cx, cy, stroke, value, minMax } = props;
    const isMin = value === minMax.min;
    const isMax = value === minMax.max;
    const isHighlighted = isMin || isMax;

    if (!isHighlighted) return null;

    return (
        <g>
            <circle cx={cx} cy={cy} r={10} fill={stroke} fillOpacity={0.15} className="animate-pulse" />
            <circle cx={cx} cy={cy} r={5} fill={stroke} stroke="white" strokeWidth={2} />
        </g>
    );
};

export default function AnalyticsGraph() {
    const [activeTab, setActiveTab] = useState('weight');
    const [filter, setFilter] = useState('6M');

    const displayData = useMemo(() => {
        if (filter === '3M') return dataWithDifferences.slice(-3);
        return dataWithDifferences;
    }, [filter]);

    const minMax = useMemo(() => {
        const values = displayData.map(d => d[activeTab]);
        return {
            min: Math.min(...values),
            max: Math.max(...values)
        };
    }, [displayData, activeTab]);

    const isWeight = activeTab === 'weight';
    const mainColor = '#FF8B3D';
    const gradientId = `color-${activeTab}`;

    return (
        <div className="w-full bg-white rounded-[3rem] p-8 lg:p-10 shadow-sm border border-black/5">
            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-8 mb-10">
                <div>
                    <h2 className="text-2xl font-bold text-slate-900 tracking-tight">Body Composition</h2>
                    <p className="text-slate-400 text-sm font-medium mt-1">Detailed tracking of your physical evolution</p>
                </div>
                
                <div className="flex flex-wrap items-center gap-4">
                    <div className="flex bg-slate-50 p-1.5 rounded-2xl border border-black/5">
                        <button 
                            onClick={() => setActiveTab('weight')}
                            className={`px-6 py-2.5 rounded-xl text-sm font-bold transition-all ${isWeight ? 'bg-white text-orange-500 shadow-sm' : 'text-slate-400 hover:text-slate-600'}`}
                        >
                            Weight
                        </button>
                        <button 
                            onClick={() => setActiveTab('bodyFat')}
                            className={`px-6 py-2.5 rounded-xl text-sm font-bold transition-all ${!isWeight ? 'bg-white text-orange-500 shadow-sm' : 'text-slate-400 hover:text-slate-600'}`}
                        >
                            Body Fat %
                        </button>
                    </div>

                    <select 
                        value={filter} 
                        onChange={(e) => setFilter(e.target.value)}
                        className="bg-white border border-black/5 text-slate-900 text-sm font-bold rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500/20 cursor-pointer shadow-sm"
                    >
                        <option value="3M">Last 3 Months</option>
                        <option value="6M">Last 6 Months</option>
                        <option value="1Y">Yearly View</option>
                    </select>
                </div>
            </div>

            <div className="h-[400px] w-full">
                <AnimatePresence mode="wait">
                    <motion.div
                        key={activeTab + filter}
                        initial={{ opacity: 0, x: 20 }}
                        animate={{ opacity: 1, x: 0 }}
                        exit={{ opacity: 0, x: -20 }}
                        transition={{ duration: 0.6, ease: "circOut" }}
                        className="w-full h-full"
                    >
                        <ResponsiveContainer width="100%" height="100%">
                            <AreaChart data={displayData} margin={{ top: 20, right: 10, left: -20, bottom: 0 }}>
                                <defs>
                                    <linearGradient id={gradientId} x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="5%" stopColor={mainColor} stopOpacity={0.2}/>
                                        <stop offset="95%" stopColor={mainColor} stopOpacity={0}/>
                                    </linearGradient>
                                </defs>
                                
                                <CartesianGrid strokeDasharray="3 3" vertical={false} stroke="#F1F5F9" />
                                <XAxis dataKey="name" axisLine={false} tickLine={false} tick={{ fill: '#94a3b8', fontSize: 13, fontWeight: 600 }} dy={15} />
                                <YAxis axisLine={false} tickLine={false} tick={{ fill: '#94a3b8', fontSize: 13, fontWeight: 600 }} domain={['dataMin - 2', 'dataMax + 2']} dx={-10} />
                                
                                <Tooltip content={<CustomTooltip unit={isWeight ? 'kg' : '%'} />} cursor={{ stroke: '#FF8B3D', strokeWidth: 2, strokeDasharray: '6 6' }} />
                                
                                <Area 
                                    type="monotone" 
                                    dataKey={activeTab} 
                                    stroke={mainColor} 
                                    strokeWidth={4}
                                    fillOpacity={1} 
                                    fill={`url(#${gradientId})`} 
                                    dot={<CustomizedDot minMax={minMax} stroke={mainColor} />}
                                    animationDuration={1500}
                                />
                            </AreaChart>
                        </ResponsiveContainer>
                    </motion.div>
                </AnimatePresence>
            </div>
        </div>
    );
}
