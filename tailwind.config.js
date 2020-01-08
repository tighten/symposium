module.exports = {
  theme: {
    colors: {
      indigo: {
        default: '#4b72D9',
        '100': '#F6F9FC',
        '500': '#6A96FE',
        '800': '#4B72D9',
      },
      black: '#222222',
      white: '#fff',
    },
    extend: {},
    fontFamily: {
      sans: ['Work Sans', 'sans-serif'],
    },
  },
  variants: {},
  plugins: [
    function({ addComponents }) {
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
