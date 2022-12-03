/* eslint-env node */
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        success: {
          DEFAULT: "#12C903",
          50: "#109206"
        },
        danger: {
          DEFAULT: "#FF3333",
          50: "#C90F0F"
        },
        warning: {
          DEFAULT: "#EC8F05",
          50: "#CD7003"
        },
        primary: {
          DEFAULT: "#4F2FB0"
        },
        dark: {
          DEFAULT: "#291F47",
          50: "#150D30",
          40: "#140C2E"
        }
      }
    }
  },
  plugins: []
};
