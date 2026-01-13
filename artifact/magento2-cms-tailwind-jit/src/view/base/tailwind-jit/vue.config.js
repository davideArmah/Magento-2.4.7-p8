const { createLoader } = require("simple-functional-loader");
const webpack = require("webpack");
const path = require("path");
const fs = require("fs");

const externals = {
    resolve: "self.resolve",
    chokidar: "self.chokidar",
    purgecss: "self.purgecss",
    tmp: "self.tmp",
};

const moduleOverrides = {
    fs: path.resolve(__dirname, "src/modules/fs.js"),
    path: require.resolve("path-browserify"),
    perf_hooks: path.resolve(__dirname, "src/modules/dummy-module.js"),
    module: path.resolve(__dirname, "src/modules/dummy-module.js"),
    v8: path.resolve(__dirname, "src/modules/dummy-module.js"),
};

function getExternal(context, request, callback) {
    if (/node_modules/.test(context) && externals[request]) {
        return callback(null, externals[request]);
    }
    callback();
}

const files = [
    {
        pattern: /modern-normalize/,
        file: require.resolve("modern-normalize"),
    },
    {
        pattern: /normalize/,
        file: require.resolve("normalize.css"),
    },
    {
        pattern: /preflight/,
        file: path.resolve(
            __dirname,
            "node_modules/tailwindcss/lib/css/preflight.css"
        ),
    },
];

module.exports = {
    productionSourceMap: false,
    configureWebpack: (config) => {

        config.resolve.alias = { ...config.resolve.alias, ...moduleOverrides };

        config.resolve.extensions = ['*', '.mjs', '.js', '.json'];

        config.plugins.push(
            new webpack.DefinePlugin({
                "process.env.TAILWIND_MODE": JSON.stringify("build"),
                "process.env.TAILWIND_DISABLE_TOUCH": true,
                "process.versions.node": "'v16.20.1'",
                "window.document": {},
                document: {
                    location: { href: { replace: () => "" } },
                    getElementsByTagName: () => [],
                },
            })
        );

        config.module.rules.push({
            test: /\.mjs$/,
            include: /node_modules/,
            type: 'javascript/auto',
        });

        config.module.rules.push({
            test: require.resolve("tailwindcss/lib/processTailwindFeatures.js"),
            use: createLoader(function(source) {
                return source.replace(`let warned = false;`, `let warned = true;`);
            }),
        });

        config.module.rules.push({
            test: require.resolve("tailwindcss/lib/corePlugins.js"),
            use: createLoader(function(source) {
                return source.replace(
                    /_fs\.default\.readFileSync\(.*?["']utf8["']\)/g,
                    (m) => {
                        for (let i = 0; i < files.length; i++) {
                            if (
                                files[i].pattern.test(m)
                            ) {
                                return (
                                    "`" +
                                    fs.readFileSync(files[i].file, "utf8").replace(/`/g, "\\`") +
                                    "`"
                                );
                            }
                        }
                        return m;
                    }
                );
            }),
        });

        config.output.globalObject = "self";

        if (config.externals) {
            config.externals.push(getExternal);
        } else {
            config.externals = [getExternal];
        }
    },
};
