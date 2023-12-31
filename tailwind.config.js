const { scopedPreflightStyles } = require('tailwindcss-scoped-preflight');

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  prefix: 'tw-',
  theme: {
    extend: {},
  },
  plugins: [        
    scopedPreflightStyles({
    cssSelector: '.WPReact'
  }),
],
}

