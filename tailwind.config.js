const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue"
    ],
    safelist: [
        "w-64",
        "w-1/2",
        "rounded-l-lg",
        "rounded-r-lg",
        "bg-gray-200",
        "grid-cols-4",
        "grid-cols-7",
        "h-6",
        "leading-6",
        "h-9",
        "leading-9",
        "shadow-lg"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans]
            },
            borderCollapse: ["hover", "focus"],
            transitionProperty: ["hover", "focus"],
            borderColor: ["active"],
            cursor: ['hover', 'focus'],

        }
    },

    variants: {
        fill: [],
        extend: {
          borderColor: ['focus-visible'],
          opacity: ['disabled'],
        }
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@themesberg/flowbite/plugin")
    ]
};
