import React from 'react';
import { 
    Radar, RadarChart, PolarGrid, PolarAngleAxis, PolarRadiusAxis, ResponsiveContainer,
    BarChart, Bar, XAxis, YAxis, Tooltip, CartesianGrid
} from 'recharts';

const radarData = [
    { subject: 'Chest', A: 120, fullMark: 150 },
    { subject: 'Back', A: 98, fullMark: 150 },
    { subject: 'Legs', A: 140, fullMark: 150 },
    { subject: 'Arms', A: 85, fullMark: 150 },
    { subject: 'Shoulders', A: 65, fullMark: 150 },
    { subject: 'Core', A: 45, fullMark: 150 },
];

const volumeData = [
    { name: 'Mon', volume: 4000 },
    { name: 'Tue', volume: 3000 },
    { name: 'Wed', volume: 0 },
    { name: 'Thu', volume: 5500 },
    { name: 'Fri', volume: 4200 },
    { name: 'Sat', volume: 0 },
    { name: 'Sun', volume: 2000 },
];

export default function WeeklyAnalyticsDashboard() {
    return (
        <div className="grid gap-8 md:grid-cols-2 mt-10">
            {/* Radar Chart: Muscle Distribution */}
            <div className="bg-white rounded-[2.5rem] p-8 shadow-sm border border-black/5">
                <h3 className="text-xl font-bold text-slate-900 mb-2">Muscle Focus Balance</h3>
                <p className="text-slate-400 text-sm mb-8">Distribution of training volume across muscle groups.</p>
                
                <div className="h-[320px] w-full">
                    <ResponsiveContainer width="100%" height="100%">
                        <RadarChart cx="50%" cy="50%" outerRadius="80%" data={radarData}>
                            <PolarGrid stroke="#F1F5F9" />
                            <PolarAngleAxis dataKey="subject" tick={{ fill: '#64748b', fontSize: 13, fontWeight: 600 }} />
                            <PolarRadiusAxis angle={30} domain={[0, 150]} tick={false} axisLine={false} />
                            <Radar 
                                name="Volume" 
                                dataKey="A" 
                                stroke="#FF8B3D" 
                                fill="#FF8B3D" 
                                fillOpacity={0.4} 
                                strokeWidth={3}
                            />
                        </RadarChart>
                    </ResponsiveContainer>
                </div>
            </div>

            {/* Bar Chart: Weekly Volume */}
            <div className="bg-white rounded-[2.5rem] p-8 shadow-sm border border-black/5">
                <div className="flex justify-between items-start mb-8">
                    <div>
                        <h3 className="text-xl font-bold text-slate-900 mb-2">Total Lifted Volume</h3>
                        <p className="text-slate-400 text-sm">Weight × Reps × Sets (KG)</p>
                    </div>
                    <div className="text-right">
                        <span className="block text-3xl font-bold text-orange-500">18.7k</span>
                        <span className="text-xs text-slate-400 uppercase font-bold tracking-wider">This Week</span>
                    </div>
                </div>

                <div className="h-[320px] w-full">
                    <ResponsiveContainer width="100%" height="100%">
                        <BarChart data={volumeData} margin={{ top: 20, right: 0, left: -20, bottom: 0 }}>
                            <CartesianGrid strokeDasharray="3 3" vertical={false} stroke="#F1F5F9" />
                            <XAxis dataKey="name" axisLine={false} tickLine={false} tick={{ fill: '#94a3b8', fontSize: 13, fontWeight: 600 }} dy={10} />
                            <YAxis axisLine={false} tickLine={false} tick={{ fill: '#94a3b8', fontSize: 13, fontWeight: 600 }} dx={-10} />
                            <Tooltip 
                                cursor={{ fill: '#F8FAFC' }}
                                contentStyle={{ borderRadius: '20px', border: 'none', boxShadow: '0 10px 30px rgba(0,0,0,0.05)', padding: '15px' }}
                                itemStyle={{ color: '#FF8B3D', fontWeight: 'bold' }}
                            />
                            <Bar dataKey="volume" fill="#FF8B3D" radius={[12, 12, 12, 12]} barSize={24} />
                        </BarChart>
                    </ResponsiveContainer>
                </div>
            </div>
        </div>
    );
}
