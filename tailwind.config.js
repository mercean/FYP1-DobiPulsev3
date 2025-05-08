/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue"
    ],
    darkMode: 'class', // <--- this is important for your dark toggle
    theme: {
      extend: {},
    },
    plugins: [],
  }
  