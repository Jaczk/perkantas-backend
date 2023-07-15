const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.js',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        fontFamily: {
          poppins: 'Poppins, sans-serif',
          'sans': ['ui-sans-serif', 'system-ui', '"Exo 2"'],
          montserrat: ["Montserrat", "sans-serif"]
        },
        extend: {
          colors: {
            primary: '#2b3a8f',
            primary_hover:'#3ed1e9',
            secondary: '#f89223',
            button: '#99DBF5',
            other: '#98DFD6',
            btn_warn: '#B70404',
            grey: '#ABB3C4',
            dark: '#121F3E',
            page: '#F8F8FA',
            success: '#2ED16C',
          },

        },
      },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'),require('flowbite/plugin')],
};
