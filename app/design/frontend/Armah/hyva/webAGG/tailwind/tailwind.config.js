const { spacing } = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');
const hyvaModules = require('@hyva-themes/hyva-modules');

module.exports = hyvaModules.mergeTailwindConfig({
    mode: process.env.TAILWIND_COMPILE_MODE || 'jit', // either 'jit' or 'aot'
    content: [
        './**/*.phtml',
        './**/*.html',
        './**/*.js'
      ],
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
                primary: {
                    lighter: colors.blue['300'],
                    "DEFAULT": colors.blue['800'],
                    darker: colors.blue['900'],
                },
                secondary: {
                    lighter: colors.blue['100'],
                    "DEFAULT": colors.blue['200'],
                    darker: colors.blue['300'],
                },
                background: {
                    lighter: colors.blue['100'],
                    "DEFAULT": colors.blue['200'],
                    darker: colors.blue['300'],
                },
                rosso: {
                    50: "#fef4f3", 
                    100: "#fce8e7", 
                    200: "#f8c6c4", 
                    300: "#f4a3a1", 
                    400: "#ec5f5a", 
                    DEFAULT: "#ff2a07", // colore standard
                    600: "#cd1711", 
                    700: "#ab140e", 
                    800: "#89100b", 
                    900: "#700d09"
                },
                arancio: {
                    50: "#fef8f2", 
                    100: "#fdf2e6", 
                    200: "#fbdebf", 
                    300: "#f9c999", 
                    400: "#f4a14d", 
                    DEFAULT: "#ef7900", // colore standard
                    600: "#d76d00", 
                    700: "#b35b00", 
                    800: "#8f4900", 
                    900: "#753b00"
                },
            },
            textColor: {
                orange: colors.orange,
                red: {
                    ...colors.red,
                    "DEFAULT": colors.red['500']
                },

                primary: {
                    lighter: colors.gray['700'],
                    "DEFAULT": colors.gray['800'],
                    darker: colors.gray['900'],
                },
                secondary: {
                    lighter: colors.gray['400'],
                    "DEFAULT": colors.gray['600'],
                    darker: colors.gray['800'],
                },
                rosso: {
                    50: "#fef4f3", 
                    100: "#fce8e7", 
                    200: "#f8c6c4", 
                    300: "#f4a3a1", 
                    400: "#ec5f5a", 
                    DEFAULT: "#ff2a07", // colore standard
                    600: "#cd1711", 
                    700: "#ab140e", 
                    800: "#89100b", 
                    900: "#700d09"
                },
                turchese: {
                    50: "#f5fbfa", 
                    100: "#ebf7f4", 
                    200: "#ceece4", 
                    300: "#b0e1d3", 
                    400: "#75cab3", 
                    DEFAULT: "#3ab392",  // colore standard
                    600: "#34a183", 
                    700: "#2c866e", 
                    800: "#236b58", 
                    900: "#1c5848"
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
                arancio: {
                    50: "#fef8f2", 
                    100: "#fdf2e6", 
                    200: "#fbdebf", 
                    300: "#f9c999", 
                    400: "#f4a14d", 
                    DEFAULT: "#ef7900", // colore standard
                    600: "#d76d00", 
                    700: "#b35b00", 
                    800: "#8f4900", 
                    900: "#753b00"
                }
            },
            backgroundColor: {
                primary: {
                    lighter: colors.blue['600'],
                    "DEFAULT": colors.blue['700'],
                    darker: colors.blue['800'],
                },
                secondary: {
                    lighter: colors.blue['100'],
                    "DEFAULT": colors.blue['200'],
                    darker: colors.blue['300'],
                },
                container: {
                    lighter: '#ffffff',
                    "DEFAULT": '#fafafa',
                    darker: '#f5f5f5',
                },
                rosso: {
                    50: "#fef4f3", 
                    100: "#fce8e7", 
                    200: "#f8c6c4", 
                    300: "#f4a3a1", 
                    400: "#ec5f5a", 
                    DEFAULT: "#ff2a07", // colore standard
                    600: "#cd1711", 
                    700: "#ab140e", 
                    800: "#89100b", 
                    900: "#700d09"
                },
                turchese: {
                    50: "#f5fbfa", 
                    100: "#ebf7f4", 
                    200: "#ceece4", 
                    300: "#b0e1d3", 
                    400: "#75cab3", 
                    DEFAULT: "#3ab392",  // colore standard
                    600: "#34a183", 
                    700: "#2c866e", 
                    800: "#236b58", 
                    900: "#1c5848"
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
                arancio: {
                    50: "#fef8f2", 
                    100: "#fdf2e6", 
                    200: "#fbdebf", 
                    300: "#f9c999", 
                    400: "#f4a14d", 
                    DEFAULT: "#ef7900", // colore standard
                    600: "#d76d00", 
                    700: "#b35b00", 
                    800: "#8f4900", 
                    900: "#753b00"
                }
            },
            borderColor: {
                primary: {
                    lighter: colors.blue['600'],
                    "DEFAULT": colors.blue['700'],
                    darker: colors.blue['800'],
                },
                secondary: {
                    lighter: colors.blue['100'],
                    "DEFAULT": colors.blue['200'],
                    darker: colors.blue['300'],
                },
                container: {
                    lighter: '#f5f5f5',
                    "DEFAULT": '#e7e7e7',
                    darker: '#b6b6b6',
                },
                rosso: {
                    50: "#fef4f3", 
                    100: "#fce8e7", 
                    200: "#f8c6c4", 
                    300: "#f4a3a1", 
                    400: "#ec5f5a", 
                    DEFAULT: "#ff2a07", // colore standard
                    600: "#cd1711", 
                    700: "#ab140e", 
                    800: "#89100b", 
                    900: "#700d09"
                },
                turchese: {
                    50: "#f5fbfa", 
                    100: "#ebf7f4", 
                    200: "#ceece4", 
                    300: "#b0e1d3", 
                    400: "#75cab3", 
                    DEFAULT: "#3ab392",  // colore standard
                    600: "#34a183", 
                    700: "#2c866e", 
                    800: "#236b58", 
                    900: "#1c5848"
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
                arancio: {
                    50: "#fef8f2", 
                    100: "#fdf2e6", 
                    200: "#fbdebf", 
                    300: "#f9c999", 
                    400: "#f4a14d", 
                    DEFAULT: "#ef7900", // colore standard
                    600: "#d76d00", 
                    700: "#b35b00", 
                    800: "#8f4900", 
                    900: "#753b00"
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
    variants: {
        extend: {
            borderWidth: ['last', 'hover', 'focus'],
            margin: ['last'],
            opacity: ['disabled'],
            backgroundColor: ['even', 'odd'],
            ringWidth: ['active']
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
    purge: {
        // Examples for excluding patterns from purge
        // options: {
        //     safelist: [/^bg-opacity-/, /^-?[mp][trblxy]?-[4,8]$/, /^text-shadow/],
        // },
        content: [
            // this theme's phtml files
            '../../**/*.phtml',
            '../../*/layout/*.xml',
            // The theme-module templates are included automatically in the purge config since Hyvä 1.1.15, but
            // for themes based on earlier releases, enable the appropriate path to the theme-module below:
            // hyva theme-module templates (if this is the default theme in vendor/hyva-themes/magento2-default-theme)
            //'../../../magento2-theme-module/src/view/frontend/templates/**/*.phtml',
            // hyva theme-module templates (if this is a child theme)
            //'../../../../../../../vendor/hyva-themes/magento2-theme-module/src/view/frontend/templates/**/*.phtml',
            // parent theme in Vendor (if this is a child-theme)
            //'../../../../../../../vendor/hyva-themes/magento2-default-theme/**/*.phtml',
            // app/code phtml files (if need tailwind classes from app/code modules)
            //'../../../../../../../app/code/**/*.phtml',
            // react app src files (if Hyvä Checkout is installed in app/code)
            //'../../../../../../../app/code/**/src/**/*.jsx',
            // react app src files in vendor (If Hyvä Checkout is installed in vendor)
            //'../../../../../../../vendor/hyva-themes/magento2-hyva-checkout/src/reactapp/src/**/*.jsx',
            //'../../../../../../../vendor/hyva-themes/magento2-hyva-checkout/src/view/frontend/templates/react-container.phtml',
            // widget block classes from app/code
            //'../../../../../../../app/code/**/Block/Widget/**/*.php'
        ]
    }
})
