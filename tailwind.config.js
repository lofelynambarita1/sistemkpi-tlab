/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/views/**/*.php",
    "./public/**/*.html",
    "./public/js/**/*.js",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        'sip-sidebar':     '#7F1D1D',
        'sip-sidebar-sec': '#991B1B',
        'sip-sidebar-act': '#B91C1C',
      }
    },
  },
  plugins: [],
}
