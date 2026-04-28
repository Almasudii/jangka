import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class', // 🌙 Gunakan class <html class="dark"> untuk dark mode
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue', // pastikan file Vue ikut dipindai
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        // Kamu bisa tambahkan warna tema khusus di sini kalau mau
        primary: {
          light: '#4B5563', // abu-abu muda
          DEFAULT: '#1F2937', // abu tua
          dark: '#111827', // hitam keabu
        },
      },
    },
  },

  plugins: [forms],
}
