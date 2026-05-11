/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/css/**/*.css',
  ],

  darkMode: 'class',

  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', ...defaultTheme.fontFamily.sans],
      },

      // WARNA PRIMARY (sumber utama warna UI & glow)
      colors: {
        primary: {
          50:  '#fafafa',
          100: '#f4f4f5',
          200: '#e4e4e7',
          300: '#d4d4d8',
          400: '#a1a1aa',
          500: '#71717a',
          600: '#52525b',
          700: '#3f3f46',
          800: '#27272a',
          900: '#ff7f00', // main accent (light mode)
          950: '#09090b',
        },
      },

      keyframes: {
        fadeUp: {
          '0%': { opacity: '0', transform: 'translateY(12px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },

      animation: {
        'fade-up': 'fadeUp 0.6s ease-out forwards',
      },
    },
  },

  plugins: [],
};
