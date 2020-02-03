const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  theme: {
    colors: {
      indigo: {
        default: '#4b72D9',
        '100': '#F6F9FC',
        '150': '#EAF0FF',
        '200': '#c3dafe',
        '300': '#a3bffa',
        '500': '#6A96FE',
        '800': '#4B72D9',
      },
      black: '#222222',
      white: '#fff',
      gray: {
        '200': '#edf2f7',
        '300': '#D8D8D8',
        '500': '#9B9B9B',
        '700': '#4a5568',
      },
    },
    fontSize: {
      ...defaultTheme.fontSize,
      '6xl': '4.3rem',
    },
    extend: {},
    fontFamily: {
      sans: [
        'Work Sans',
        ...defaultTheme.fontFamily.sans,
      ],
    },
  },
  variants: {
    margin: ['responsive', 'first', 'last'],
    borderWidth: ['responsive', 'first', 'last']
  },
  plugins: [
    require('@tailwindcss/custom-forms'),
    function ({ addComponents }) {
      const buttons = {
        '.btn-github-login': {
          margin: '.25rem 0',
          padding: '.5rem',
          display: 'inline-block',
          borderRadius: '.25rem',
          borderWidth: '1px',
          borderColor: '#2d3748',
          textDecoration: 'none',
          color: '#2d3748',
          fontSize: '1.125rem',
          '&:hover': {
            backgroundColor: '#4299e1',
            borderColor: '#4299e1',
            color: '#ffffff',
            textDecoration: 'none'
          },
        },
      }

      addComponents(buttons)
    }
  ]
}
