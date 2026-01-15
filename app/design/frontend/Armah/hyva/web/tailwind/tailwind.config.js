const {
  spacing
} = require('tailwindcss/defaultTheme');

const colors = require('tailwindcss/colors');

const hyvaModules = require('@hyva-themes/hyva-modules');

const rosso = {
  50: "#fef4f3",
  100: "#fce8e7",
  200: "#f8c6c4",
  300: "#f4a3a1",
  400: "#ec5f5a",
  lighter: "#ec5f5a",
  DEFAULT: "#ff2a07",
  darker: "#cd1711",
  600: "#cd1711",
  700: "#ab140e",
  800: "#89100b",
  900: "#700d09"
};

const arancio = {
  50: "#fef8f2",
  100: "#fdf2e6",
  200: "#fbdebf",
  300: "#f9c999",
  lighter: "#f9c999",
  400: "#f4a14d",
  DEFAULT: "#ef7900",
  darker: "#d76d00",
  600: "#d76d00",
  700: "#b35b00",
  800: "#8f4900",
  900: "#753b00"
};


module.exports = hyvaModules.mergeTailwindConfig({
  theme: {
    extend: {
      screens: {
        'sm': '640px',
        // => @media (min-width: 640px) { ... }
        'md': '768px',
        // => @media (min-width: 768px) { ... }
        'lg': '1024px',
        // => @media (min-width: 1024px) { ... }
        'xl': '1280px',
        // => @media (min-width: 1280px) { ... }
        '2xl': '1536px',
        // => @media (min-width: 1536px) { ... }
      },
      fontFamily: {
        sans: ["Hind Siliguri", "Roboto", "Arial", "sans-serif"]
      },
      colors: {
        rosso,
        arancio,
        primary: rosso,
        secondary: arancio,
        background: {
          lighter: colors.blue['100'],
          "DEFAULT": colors.blue['200'],
          darker: colors.blue['300'],
        },
      },
      textColor: {

        rosso,
        arancio,

        primary: rosso,
        secondary: arancio,

        background: {
          lighter: colors.blue['100'],
          "DEFAULT": colors.blue['200'],
          darker: colors.blue['300'],
        },
      
        giallo: {
          50: "#fffdf2",
          100: "#fefbe6",
          200: "#fdf5bf",
          300: "#fcef99",
          400: "#f9e34d",
          DEFAULT: "#f7d700", // colore standard
          600: "#dec200",
          700: "#b9a100",
          800: "#948100",
          900: "#796900"
        }
      },
      backgroundColor: {

        rosso,
        arancio,

        primary: rosso,
        secondary: arancio,

        background: {
          lighter: colors.blue['100'],
          "DEFAULT": colors.blue['200'],
          darker: colors.blue['300'],
        },
      
        giallo: {
          50: "#fffdf2",
          100: "#fefbe6",
          200: "#fdf5bf",
          300: "#fcef99",
          400: "#f9e34d",
          DEFAULT: "#f7d700", // colore standard
          600: "#dec200",
          700: "#b9a100",
          800: "#948100",
          900: "#796900"
        },
        container: {
          lighter: '#ffffff',
          "DEFAULT": '#fafafa',
          darker: '#f5f5f5',
        }
      },
      borderColor: {
        rosso,
        arancio,

        primary: rosso,
        secondary: arancio,

        background: {
          lighter: colors.blue['100'],
          "DEFAULT": colors.blue['200'],
          darker: colors.blue['300'],
        },
      
        giallo: {
          50: "#fffdf2",
          100: "#fefbe6",
          200: "#fdf5bf",
          300: "#fcef99",
          400: "#f9e34d",
          DEFAULT: "#f7d700", // colore standard
          600: "#dec200",
          700: "#b9a100",
          800: "#948100",
          900: "#796900"
        },
        container: {
          lighter: '#f5f5f5',
          "DEFAULT": '#e7e7e7',
          darker: '#b6b6b6',
        }
      },
      minWidth: {
        8: spacing["8"],
        20: spacing["20"],
        40: spacing["40"],
        48: spacing["48"],
      },
      minHeight: {
        14: spacing["14"],
        'screen-25': '25vh',
        'screen-50': '50vh',
        'screen-75': '75vh',
      },
      maxHeight: {
        '0': '0',
        'screen-25': '25vh',
        'screen-50': '50vh',
        'screen-75': '75vh',
      },
      container: {
        center: true,
        padding: '.5rem'
      }
    },
  },
  plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
  // Examples for excluding patterns from purge
  content: [
    // this theme's phtml and layout XML files
    '../../**/*.phtml',
    '../../*/layout/*.xml',
    '../../*/page_layout/override/base/*.xml',
    // parent theme in Vendor (if this is a child-theme)
    //'../../../../../../../vendor/hyva-themes/magento2-default-theme/**/*.phtml',
    //'../../../../../../../vendor/hyva-themes/magento2-default-theme/*/layout/*.xml',
    //'../../../../../../../vendor/hyva-themes/magento2-default-theme/*/page_layout/override/base/*.xml',
    // app/code phtml files (if need tailwind classes from app/code modules)
    //'../../../../../../../app/code/**/*.phtml',
  ]
});
