import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                tactical: {
                    bg: '#0a0f1f',
                    surface: '#131b33',
                    primary: '#1e4d8c',
                    accent: '#e2b007',
                    text: '#e0e0e0',
                    'text-muted': '#a0a0a0',
                    border: 'rgba(30, 77, 140, 0.5)',
                },
            },
            fontFamily: {
                sans: ['Roboto', 'Figtree', ...defaultTheme.fontFamily.sans],
                orbitron: ['Orbitron', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'tactical': '0 0 15px rgba(226, 176, 7, 0.3)',
                'tactical-glow': '0 0 15px rgba(226, 176, 7, 0.6)',
            },
            animation: {
                'pulse-glow': 'pulse-glow 3s infinite',
            },
            keyframes: {
                'pulse-glow': {
                    '0%, 100%': { 'box-shadow': '0 0 5px rgba(226, 176, 7, 0.3)' },
                    '50%': { 'box-shadow': '0 0 15px rgba(226, 176, 7, 0.6)' },
                },
            },
        },
    },

    plugins: [
        forms,
        function({ addComponents }) {
            addComponents({
                '.input-field': {
                    '@apply w-full px-4 py-2 bg-tactical-surface/50 border border-tactical-border rounded-md text-tactical-text focus:ring-2 focus:ring-tactical-primary focus:border-tactical-primary outline-none transition-all duration-200': {},
                },
                '.input-label': {
                    '@apply block text-sm font-medium text-tactical-text mb-1 flex items-center': {},
                },
                '.btn': {
                    '@apply inline-flex items-center justify-center px-4 py-2 rounded-md font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tactical-primary': {},
                },
                '.btn-primary': {
                    '@apply bg-tactical-primary hover:bg-opacity-90 text-white border border-tactical-primary hover:border-tactical-accent': {},
                },
                '.card': {
                    '@apply bg-tactical-surface/80 backdrop-blur-sm rounded-xl border border-tactical-border shadow-lg transition-all duration-300 hover:shadow-xl hover:border-tactical-accent/50': {},
                },
            });
        },
    ],
};
