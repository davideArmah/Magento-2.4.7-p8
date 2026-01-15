const { postcssImportHyvaModules } = require("@hyva-themes/hyva-modules");

module.exports = {
    plugins: {
      'postcss-import': {},
      'postcss-nesting': {},  // Usa postcss-nesting invece di tailwindcss/nesting
      'tailwindcss': {},
      'autoprefixer': {}
    }
  };
  