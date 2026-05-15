import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
        './resources/js/**/*.js',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
                syncopate: ['Syncopate', 'sans-serif'],
            },
            colors: {
                obsidian: '#0A0A0B',
                'cyan-glow': '#00F2FF',
                'orbit-purple': '#7000FF',
            },
            animation: {
                'float': 'float 3s ease-in-out infinite',
                'ticker': 'ticker 30s linear infinite',
                'ticker-vertical': 'ticker-vertical 20s linear infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-5px)' },
                },
                ticker: {
                    '0%': { transform: 'translateX(0)' },
                    '100%': { transform: 'translateX(-50%)' },
                },
                'ticker-vertical': {
                    '0%': { transform: 'translateY(0)' },
                    '100%': { transform: 'translateY(-50%)' },
                }
            },
            boxShadow: {
                'cyan-glow': '0 0 20px rgba(0, 242, 255, 0.3)',
                'purple-glow': '0 0 20px rgba(112, 0, 255, 0.3)',
                'neon-cyan': '0 0 30px rgba(0, 242, 255, 0.4)',
            }
        },
    },

    plugins: [forms],
};
