/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eef2ff',
          100: '#dde4ff',
          200: '#c3cfff',
          300: '#9db1ff',
          400: '#7387fc',
          500: '#5364f6',
          600: '#3d42eb',
          700: '#3233d5',
          800: '#2b2dac',
          900: '#282d86',
          950: '#191b4c',
        },
        secondary: {
          50: '#f0fdfa',
          100: '#cbfcf2',
          200: '#98f7e8',
          300: '#5feada',
          400: '#35d5c8',
          500: '#18b7ae',
          600: '#129492',
          700: '#137477',
          800: '#155d61',
          900: '#164e52',
          950: '#07302f',
        },
        accent: {
          50: '#fff9eb',
          100: '#ffefc6',
          200: '#ffdb87',
          300: '#ffc14f',
          400: '#ffa524',
          500: '#ff8a0a',
          600: '#ff6700',
          700: '#cc4602',
          800: '#a1360b',
          900: '#82300c',
          950: '#461502',
        },
        dark: {
          50: '#f6f6f7',
          100: '#e0e2e7',
          200: '#c2c5cf',
          300: '#9da2b1',
          400: '#797f93',
          500: '#60667a',
          600: '#4d5264',
          700: '#404453',
          800: '#383b46',
          900: '#25272e',
          950: '#1a1c22',
        },
      },
      fontFamily: {
        sans: ['Montserrat', 'sans-serif'],
        heading: ['Poppins', 'sans-serif'],
      },
      borderRadius: {
        'xl': '1rem',
        '2xl': '1.5rem',
        '3xl': '2rem',
      },
      boxShadow: {
        'soft': '0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02)',
        'elegant': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-out forwards',
        'slide-up': 'slideUp 0.5s ease-out forwards',
        'slide-right': 'slideRight 0.5s ease-out forwards',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: 0 },
          '100%': { opacity: 1 },
        },
        slideUp: {
          '0%': { transform: 'translateY(20px)', opacity: 0 },
          '100%': { transform: 'translateY(0)', opacity: 1 },
        },
        slideRight: {
          '0%': { transform: 'translateX(-20px)', opacity: 0 },
          '100%': { transform: 'translateX(0)', opacity: 1 },
        },
      },
    },
  },
  plugins: [],
}
