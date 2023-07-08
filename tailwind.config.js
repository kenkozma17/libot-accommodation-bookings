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
        './resources/js/**/*.vue',
    ],

    theme: {
      extend: {
        fontFamily: {
          'poppins': ['Poppins', 'sans-serif'],
          'montserrat': ['Montserrat', 'sans-serif']
        },
        colors: {
          'back-gray': '#EAEAEA',
          'light-gray': '#C6C6C6',
          'dark-green': '#313A2E',
          'light-blue': '#3A7E8D',
          'light-brown': '#AEA599',
        }
      }
    },

    plugins: [forms, typography],
};
