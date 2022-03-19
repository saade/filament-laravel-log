
const colors = require('tailwindcss/colors')

module.exports = {
    darkMode: 'class',
    content: [
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                success: colors.green,
                warning: colors.amber,
                primary: colors.yellow
            }
        },
    },
};
