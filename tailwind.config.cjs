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
            success: '#18BC9C',
            warning: '#F39C12',
            danger: '#E74C3C',
            info: '#3498DB',
            indigo: {
                DEFAULT: '#4b72D9',
                100: '#F6F9FC',
                150: '#EAF0FF',
                300: '#a3bffa',
                500: '#6A96FE',
                600: '#4F46E5',
                700: '#4338CA',
                800: '#4B72D9',
                900: '#4C51BF',
            },
            gray: {
                100: '#f7fafc',
                200: '#edf2f7',
                300: '#D1D5DB',
                400: '#9CA3AF',
                500: '#6B7280',
                600: '#828080',
                700: '#4a5568',
                900: '#111827',
            },
            red: {
                500: '#f56565',
            },
            green: {
                100: '#D1FAE5',
                500: '#10B981',
                800: '#065F46',
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
                'Inter var',
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
