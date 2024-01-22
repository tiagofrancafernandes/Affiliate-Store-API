/** @type {import('tailwindcss').Config} */
// npx tailwindcss -i ./src/input.css -o ./dist/output.css --watch
module.exports = {
  content: [
    "./src/**/*.{html,js,vue}",
    "./*.{html,js,vue}",
],
  darkMode: 'media', // false|'media'|'class'
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
