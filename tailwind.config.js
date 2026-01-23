/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                // Primary Colors
                gold: {
                    DEFAULT: '#E6C200',
                    dark: '#C9A400',
                    light: '#F5D800',
                },
                brown: {
                    DEFAULT: '#4A3B00',
                    dark: '#3A2E00',
                    light: '#5A4B10',
                },
                cream: {
                    DEFAULT: '#FFFCF2',
                    dark: '#FFF8E5',
                },
                // Status Colors
                success: '#16A34A',
                warning: '#F59E0B',
                danger: '#DC2626',
                // Text Colors
                dark: '#1F2937',
                muted: '#6B7280',
            },
            fontFamily: {
                display: ['Space Grotesk', 'Plus Jakarta Sans', 'sans-serif'],
                body: ['Plus Jakarta Sans', 'sans-serif'],
            },
            boxShadow: {
                'soft': '0 2px 15px rgba(0, 0, 0, 0.04)',
                'premium': '0 10px 40px rgba(0, 0, 0, 0.08)',
                'gold': '0 8px 30px rgba(230, 194, 0, 0.3)',
                'gold-lg': '0 15px 50px rgba(230, 194, 0, 0.4)',
            },
            borderRadius: {
                '4xl': '2rem',
            },
            spacing: {
                '18': '4.5rem',
            },
            animation: {
                'fade-in': 'fadeIn 0.6s ease-out forwards',
                'slide-down': 'slideDown 0.4s ease-out',
                'pulse-gold': 'pulse-gold 2s ease-in-out infinite',
                'shimmer': 'shimmer 1.5s ease-in-out infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideDown: {
                    '0%': { transform: 'translateY(-100%)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                'pulse-gold': {
                    '0%, 100%': { boxShadow: '0 0 0 0 rgba(230, 194, 0, 0.4)' },
                    '50%': { boxShadow: '0 0 0 10px rgba(230, 194, 0, 0)' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
            },
            backgroundImage: {
                'gradient-gold': 'linear-gradient(135deg, #E6C200 0%, #C9A400 100%)',
                'gradient-gold-dark': 'linear-gradient(135deg, #C9A400 0%, #4A3B00 100%)',
                'gradient-brown': 'linear-gradient(135deg, #4A3B00 0%, #3A2E00 100%)',
                'gradient-hero': 'linear-gradient(135deg, #FFFCF2 0%, rgba(230, 194, 0, 0.08) 50%, #FFFCF2 100%)',
            },
        },
    },
    plugins: [],
}