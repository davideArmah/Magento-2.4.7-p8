import tailwindcss from "tailwindcss";
import postcss from "postcss";
import parseCustomConfig from "./parseCustomConfig";

export default async function (htmlContent, customConfig, customCss) {

    const defaultConfig = {
      mode: "jit",
      content: [
        {raw: htmlContent, extension: 'html'}
      ],
      corePlugins: {preflight: false},
      theme: {},
      plugins: [
        require("@tailwindcss/typography"),
      ],
    };

    const userConfig = parseCustomConfig(customConfig);
    const userCss = customCss || '';

    const result = await postcss([
        tailwindcss({...defaultConfig, ...userConfig}),
    ]).process(
      `
      @tailwind base;
      @tailwind components;
      ${userCss}
      @tailwind utilities;
      `,
      {
        from: "/sourcePath"
      }
    );

    return result.css;
}
