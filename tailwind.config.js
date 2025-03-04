import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        typography,
        function ({ addComponents }) {
            addComponents({
                '.btn': {
                    '@apply flex w-full items-center justify-center gap-1 px-4 py-2 text-center font-medium transition duration-200 sm:w-auto': {},
                },
                '.btn-white': {
                    '@apply border-2 border-transparent bg-purple-50 text-purple-800 hover:border-purple-600': {},
                },
                '.btn-purple': {
                    '@apply border-2 border-transparent bg-purple-600 text-white hover:bg-purple-700': {},
                },
                '.btn-outline-purple': {
                    '@apply border-2 border-purple-600 text-purple-700 hover:bg-purple-600 hover:text-white': {},
                },
                '.btn-pink': {
                    '@apply border-2 border-transparent bg-pink-600 text-white hover:bg-pink-700': {},
                },
                '.btn-outline-pink': {
                    '@apply border-2 border-pink-600 text-pink-600 hover:bg-pink-600 hover:text-white': {},
                },
                '.btn-purple-to-pink': {
                    '@apply bg-gradient-to-r from-purple-600 to-pink-500 py-2.5 text-white hover:from-purple-700 hover:to-pink-600': {},
                },
                '.btn-pink-to-purple': {
                    '@apply bg-gradient-to-r from-pink-500 to-purple-600 py-2.5 text-white hover:from-pink-600 hover:to-purple-700': {},
                },
            });
        },
    ],
};
