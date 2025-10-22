import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./app/Filament/**/*.php",
    ],

    darkMode: "class",

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "Figtree", ...defaultTheme.fontFamily.sans],
                poppins: ["Poppins", "sans-serif"],
            },
            colors: {
                hastana: {
                    blue: "#1e40af",
                    red: "#dc2626",
                    black: "#1a1a1a",
                    gray: "#6b7280",
                    "light-gray": "#f3f4f6",
                },
            },
            animation: {
                float: "float 6s ease-in-out infinite",
                "fade-in": "fadeIn 0.6s ease-out",
                "slide-in-up": "slideInUp 0.6s ease-out",
                "slide-in-down": "slideInDown 0.3s ease-out",
            },
            keyframes: {
                float: {
                    "0%, 100%": { transform: "translateY(0px)" },
                    "50%": { transform: "translateY(-10px)" },
                },
                fadeIn: {
                    from: { opacity: "0" },
                    to: { opacity: "1" },
                },
                slideInUp: {
                    from: {
                        opacity: "0",
                        transform: "translateY(20px)",
                    },
                    to: {
                        opacity: "1",
                        transform: "translateY(0)",
                    },
                },
                slideInDown: {
                    from: {
                        opacity: "0",
                        transform: "translateY(-10px)",
                    },
                    to: {
                        opacity: "1",
                        transform: "translateY(0)",
                    },
                },
            },
            backdropBlur: {
                xs: "2px",
            },
            boxShadow: {
                card: "0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)",
                "card-hover":
                    "0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)",
            },
        },
    },

    plugins: [
        forms,
        function ({ addUtilities }) {
            const newUtilities = {
                ".text-hastana-blue": {
                    color: "#1e40af",
                },
                ".text-hastana-red": {
                    color: "#dc2626",
                },
                ".bg-hastana-blue": {
                    backgroundColor: "#1e40af",
                },
                ".bg-hastana-red": {
                    backgroundColor: "#dc2626",
                },
                ".border-hastana-blue": {
                    borderColor: "#1e40af",
                },
                ".border-hastana-red": {
                    borderColor: "#dc2626",
                },
                ".gradient-text": {
                    background: "linear-gradient(135deg, #1e40af, #dc2626)",
                    "-webkit-background-clip": "text",
                    "-webkit-text-fill-color": "transparent",
                    "background-clip": "text",
                },
                ".line-clamp-1": {
                    display: "-webkit-box",
                    "-webkit-line-clamp": "1",
                    "-webkit-box-orient": "vertical",
                    overflow: "hidden",
                },
                ".line-clamp-2": {
                    display: "-webkit-box",
                    "-webkit-line-clamp": "2",
                    "-webkit-box-orient": "vertical",
                    overflow: "hidden",
                },
                ".line-clamp-3": {
                    display: "-webkit-box",
                    "-webkit-line-clamp": "3",
                    "-webkit-box-orient": "vertical",
                    overflow: "hidden",
                },
            };
            addUtilities(newUtilities);
        },
    ],
};
