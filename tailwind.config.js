const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        colors: {
            current: 'currentColor',
            black: '#000',
            white: '#fff',
            indigo: {
                DEFAULT: '#4b72D9',
                100: '#F6F9FC',
                150: '#EAF0FF',
                300: '#a3bffa',
                500: '#6A96FE',
                800: '#4B72D9',
                900: '#4C51BF',
            },
            gray: {
                100: '#f7fafc',
                200: '#edf2f7',
                300: '#D8D8D8',
                400: '#cbd5e0',
                500: '#9B9B9B',
                600: '#828080',
                700: '#4a5568',
            },
            red: {
                500: '#f56565',
            },
            form: {
                200: '#e2e8f0',
                400: '#a0aec0',
            },
        },
        fontSize: {
            xs: '0.75rem',
            sm: '0.875rem',
            base: '1rem',
            lg: '1.125rem',
            xl: '1.25rem',
            '2xl': '1.5rem',
            '3xl': '1.875rem',
            '4xl': '2.25rem',
            '5xl': '3rem',
            '6xl': '4.3rem',
        },
        fontFamily: {
            sans: [
                'Work Sans',
                ...defaultTheme.fontFamily.sans,
            ],
        },
        extend: {
            spacing: {
                '0.5': '2px',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms')({
           strategy: 'class',
        }),
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
