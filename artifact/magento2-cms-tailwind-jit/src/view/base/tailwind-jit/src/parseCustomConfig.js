// eslint-disable-next-line no-unused-vars
const colors = require("tailwindcss/colors");
// eslint-disable-next-line no-unused-vars
const { spacing } = require('tailwindcss/defaultTheme');

export default (customConfig) => {
  let userConfig = {};
  try {
    userConfig = eval(`(${customConfig.trim() !== '' ? customConfig : '{}'})`) || {};
    if (userConfig.purge) {
        delete(userConfig.purge)
    }
  } catch (err) {
    console.error('Error parsing tailwind config:', '"' + customConfig + '"');
    console.error(err);
  }

  return userConfig;
};
