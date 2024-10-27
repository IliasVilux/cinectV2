import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                black: "#1F1F1F",
                "dark-black": "#121212",
                purple: {
                    DEFAULT: "#8B5BF4",
                    light: "#A77BFF",
                },
                white: "#FFFFFF",
                gray: {
                    DEFAULT: "#D1D5DB",
                },
            },
        },
    },

    plugins: [forms],
};
