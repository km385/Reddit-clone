import type { Config } from 'tailwindcss'
declare let require: any

export default {
  content: [
      "./home.html",
      "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
        colors: {
            'main-bg': '#0b1416',
            'hover-light': '#131f23',
            'hover-dark': '#223237',
            'text-blue': '#a7ccff',
        }
    },
  },
  plugins: [
      require('tailwind-scrollbar')
  ],
} satisfies Config

