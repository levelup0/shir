/** @type {import('tailwindcss').Config} */
module.exports = {
  corePlugins: {
    preflight: false,
  },
  content: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    fontFamily: {
      interbold: ['inter-bold', 'sans-serif'],
      intermedium: ['inter-medium', 'sans-serif'],
      interthin: ['inter-thin', 'sans-serif'],
      interlight: ['inter-light', 'sans-serif'],
    },
    extend: {
      keyframes: {
        wiggle1: {
          bottom: 0,
          height: '496px',
          left: 'auto',
          position: 'fixed',
          right: 'auto',
          width: '336px',
          zIndex: '2147483646',
        },

        wiggle2: {
          bottom: 0,
          height: '496px',
          left: 'auto',
          position: 'fixed',
          right: 'auto',
          width: '336px',
          zIndex: '2147483646',
        },

        wiggle3: {
          '0%, 100%': { transform: 'rotate(-3deg)' },
          '50%': { transform: 'rotate(3deg)' },
        },
      },
    },
  },
  plugins: [],


}

