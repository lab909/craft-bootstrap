const plugin = require('tailwindcss/plugin');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./templates/**/*.{html,twig}", './src/**/*.{js,jsx,ts,tsx,svg}'],
  plugins: [
    plugin(function ({addUtilities}) {
      /*addUtilities({
        '.sticky-scroll': {
          'position': 'sticky',
          'top': '16px',
          'max-height': '100vh',
          'overflow-y': 'auto'
        },
        '.non-sticky-scroll': {
          'position': 'relative',
          'max-height': 'initial',
          'overflow-y': 'auto',
          'top': '0'
        }
      })*/
    })
  ],
}

