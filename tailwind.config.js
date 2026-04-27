import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Google Sans"],
            },
            colors: {
                primary: "#323986",
                secondary: "#3e426b",
                tertiary: "#2ac4ea",
                accent: "#ecc25c",
                info: "#c9b27e",
            },
        },
    },

    plugins: [forms],
};
