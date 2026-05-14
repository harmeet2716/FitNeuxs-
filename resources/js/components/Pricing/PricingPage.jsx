import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Check, Zap, Rocket, Orbit, Sparkles } from 'lucide-react';

const PricingPage = () => {
    const [billingCycle, setBillingCycle] = useState('monthly');

    const plans = [
        {
            name: 'Astro',
            tier: 'Basic',
            price: billingCycle === 'monthly' ? '0' : '0',
            description: 'Essential protocols for those initiating their fitness journey.',
            icon: Rocket,
            color: 'slate',
            features: [
                'Unlimited Workout Logs',
                'Manual Nutrition Entry',
                'Basic Weight Tracking',
                'Community Support',
                'Standard Database'
            ],
            buttonText: 'Initiate Protocol',
            popular: false
        },
        {
            name: 'Orbit',
            tier: 'Pro',
            price: billingCycle === 'monthly' ? '9.99' : '99.99',
            description: 'Advanced biometric tracking and deep performance analysis.',
            icon: Orbit,
            color: 'cyan',
            features: [
                'Barcode & Photo Logging',
                'Custom Macro Goals',
                '1RM Graphs & Volume',
                'Template Library',
                'Priority Support'
            ],
            buttonText: 'Establish Link',
            popular: true
        },
        {
            name: 'Supernova',
            tier: 'Elite',
            price: billingCycle === 'monthly' ? '24.99' : '249.99',
            description: 'Total neural optimization and AI-driven growth protocols.',
            icon: Sparkles,
            color: 'purple',
            features: [
                'Personalized AI Coach',
                'AI Meal Generation',
                'Predictive Progress AI',
                'Custom Foods Library',
                'Early Access Features'
            ],
            buttonText: 'Reach Singularity',
            popular: false
        }
    ];

    return (
        <div className="min-h-screen py-20 px-6">
            <div className="max-w-7xl mx-auto">
                {/* Header */}
                <div className="text-center mb-20">
                    <motion.div 
                        initial={{ opacity: 0, y: 20 }}
                        animate={{ opacity: 1, y: 0 }}
                        className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-[0.4em] text-cyan-400 mb-8"
                    >
                        <Zap size={14} className="animate-pulse" />
                        Subscription Protocols
                    </motion.div>
                    
                    <h1 className="text-5xl md:text-7xl font-black text-white tracking-tighter mb-6 font-syncopate uppercase">
                        Select Your <span className="text-cyan-400">Orbit</span>
                    </h1>
                    <p className="text-slate-400 text-lg max-w-2xl mx-auto font-medium leading-relaxed">
                        Choose the tier of complexity required for your biological transformation. 
                        All plans include core anti-gravity synchronization.
                    </p>

                    {/* Toggle */}
                    <div className="mt-12 flex items-center justify-center gap-6">
                        <span className={`text-sm font-bold tracking-widest uppercase transition-colors ${billingCycle === 'monthly' ? 'text-white' : 'text-slate-500'}`}>Monthly</span>
                        <button 
                            onClick={() => setBillingCycle(billingCycle === 'monthly' ? 'yearly' : 'monthly')}
                            className="relative w-20 h-10 rounded-full bg-white/5 border border-white/10 p-1 transition-all"
                        >
                            <motion.div 
                                animate={{ x: billingCycle === 'monthly' ? 0 : 40 }}
                                className="w-8 h-8 rounded-full bg-cyan-400 shadow-[0_0_15px_rgba(0,242,255,0.6)]"
                            />
                        </button>
                        <span className={`text-sm font-bold tracking-widest uppercase transition-colors ${billingCycle === 'yearly' ? 'text-white' : 'text-slate-500'}`}>
                            Yearly <span className="text-emerald-400 text-[10px] ml-1">(-20%)</span>
                        </span>
                    </div>
                </div>

                {/* Grid */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {plans.map((plan, idx) => (
                        <motion.div
                            key={plan.name}
                            initial={{ opacity: 0, y: 40 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ delay: idx * 0.1 }}
                            whileHover={{ y: -16 }}
                            className={`relative p-10 rounded-[2.5rem] bg-white/5 backdrop-blur-xl border border-white/10 transition-all duration-500 flex flex-col ${
                                plan.popular ? 'shadow-[0_0_50px_rgba(0,242,255,0.15)] ring-2 ring-cyan-400/20' : 'shadow-2xl'
                            }`}
                        >
                            {plan.popular && (
                                <div className="absolute -top-5 left-1/2 -translate-x-1/2 px-6 py-2 rounded-full bg-cyan-400 text-black text-[10px] font-black uppercase tracking-[0.3em] shadow-[0_0_20px_rgba(0,242,255,0.5)]">
                                    Most Popular
                                </div>
                            )}

                            <div className="mb-10">
                                <div className={`w-14 h-14 rounded-2xl flex items-center justify-center bg-${plan.color === 'slate' ? 'white/10' : plan.color + '-400/10'} text-${plan.color === 'slate' ? 'white' : plan.color + '-400'} mb-8`}>
                                    <plan.icon size={28} />
                                </div>
                                <h3 className="text-sm font-black text-white/30 uppercase tracking-[0.4em] mb-2">{plan.tier} Tier</h3>
                                <h2 className="text-4xl font-black text-white tracking-tighter mb-4">{plan.name}</h2>
                                <p className="text-slate-400 text-sm font-medium leading-relaxed">{plan.description}</p>
                            </div>

                            <div className="mb-10 flex items-baseline gap-2">
                                <span className="text-6xl font-black text-white tracking-tighter">${plan.price}</span>
                                <span className="text-slate-500 font-bold uppercase tracking-widest text-xs">/ {billingCycle === 'monthly' ? 'mo' : 'yr'}</span>
                            </div>

                            <ul className="space-y-5 mb-12 flex-1">
                                {plan.features.map((feature, fIdx) => (
                                    <li key={fIdx} className="flex items-center gap-4 text-sm font-bold text-slate-300">
                                        <div className={`w-5 h-5 rounded-full flex items-center justify-center bg-${plan.color === 'slate' ? 'white/10' : plan.color + '-400/10'} text-${plan.color === 'slate' ? 'white' : plan.color + '-400'}`}>
                                            <Check size={12} strokeWidth={3} />
                                        </div>
                                        {feature}
                                    </li>
                                ))}
                            </ul>

                            <button className={`w-full py-5 rounded-2xl font-black text-xs uppercase tracking-[0.3em] transition-all transform hover:scale-[1.02] active:scale-[0.98] ${
                                plan.popular 
                                ? 'bg-cyan-400 text-black shadow-[0_0_30px_rgba(0,242,255,0.4)] hover:shadow-[0_0_50px_rgba(0,242,255,0.6)]' 
                                : 'bg-white/5 text-white border border-white/10 hover:bg-white/10'
                            }`}>
                                {plan.buttonText}
                            </button>
                        </motion.div>
                    ))}
                </div>

                {/* Footer Note */}
                <p className="text-center mt-20 text-slate-500 text-sm font-medium">
                    Neural encryption and biometric security included by default. <br />
                    <span className="text-white/20">Questions? Establish a link with our support core.</span>
                </p>
            </div>
        </div>
    );
};

export default PricingPage;
