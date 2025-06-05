const defaultTheme = require('tailwindcss/defaultTheme');
const forms = require('@tailwindcss/forms');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        screens: {
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xlg: '1200px', 
            xl: '1280px',
            '2xl': '1536px',
            'md-custom': '1000px',
        },
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            zIndex: {
                250: '250',
                1000: '1000',
            },
        },
    },

    plugins: [forms],
};
