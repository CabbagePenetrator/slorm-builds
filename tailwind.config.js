const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Berlin Sans FB', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                gray: {
                    900: '#090909',
                    800: '#101010',
                    700: '#100E0E',
                    600: '#2A2821',
                },
                red: {
                    400: '#A73007',
                    500: '#6C1D10',
                    600: '#3D171B',
                },
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
