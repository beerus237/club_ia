import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Brand palette derived from the club logo (sky blue -> deep blue, on white)
                brand: {
                    50: '#f0f8ff',
                    100: '#e0f1fe',
                    200: '#bae3fd',
                    300: '#7ccdfb',
                    400: '#36b3f5',
                    500: '#0c9ce6',
                    600: '#0079c4',
                    700: '#02609f',
                    800: '#075183',
                    900: '#0c446c',
                    950: '#082b48',
                },
            },
            boxShadow: {
                soft: '0 2px 10px rgba(8, 65, 130, 0.06)',
                card: '0 10px 30px -8px rgba(8, 65, 130, 0.12)',
                'card-hover': '0 20px 45px -12px rgba(8, 65, 130, 0.22)',
                glow: '0 0 0 4px rgba(12, 156, 230, 0.12)',
            },
            backgroundImage: {
                'brand-gradient': 'linear-gradient(135deg, #36b3f5 0%, #0079c4 100%)',
                'brand-gradient-soft': 'linear-gradient(135deg, #f0f8ff 0%, #e0f1fe 100%)',
                'brand-mesh':
                    'radial-gradient(circle at 0% 0%, rgba(54,179,245,0.16), transparent 40%), radial-gradient(circle at 100% 100%, rgba(0,121,196,0.12), transparent 38%)',
            },
            keyframes: {
                fadeInUp: {
                    '0%': { opacity: 0, transform: 'translateY(24px)' },
                    '100%': { opacity: 1, transform: 'translateY(0)' },
                },
                fadeIn: {
                    '0%': { opacity: 0 },
                    '100%': { opacity: 1 },
                },
                floatSlow: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-12px)' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-700px 0' },
                    '100%': { backgroundPosition: '700px 0' },
                },
                scaleIn: {
                    '0%': { opacity: 0, transform: 'scale(0.96)' },
                    '100%': { opacity: 1, transform: 'scale(1)' },
                },
            },
            animation: {
                'fade-in-up': 'fadeInUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) both',
                'fade-in': 'fadeIn 0.5s ease-out both',
                'float-slow': 'floatSlow 6s ease-in-out infinite',
                shimmer: 'shimmer 2s infinite linear',
                'scale-in': 'scaleIn 0.3s cubic-bezier(0.22, 1, 0.36, 1) both',
            },
            transitionTimingFunction: {
                smooth: 'cubic-bezier(0.22, 1, 0.36, 1)',
            },
        },
    },

    plugins: [forms],
};
