/* eslint-env node */
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        primary: "#00C966",
        danger: "#ff005a",
        secondary: "#928c9e",
        hollow: {
          DEFAULT: "#261b3c",
          light: "#3c2a5f",
        },
        darkest: "#020016",
        darker: "#0d0a16",
        dark: "#100a1f",
      },
      keyframes: {
        "ping-sm": {
          "75%, 100%": { transform: " scale(1.05)", opacity: 0 },
        },
      },
      animation: {
        "ping-sm": "ping-sm 1.5s ease-in-out infinite",
      },
    },
  },
  plugins: [],
};
