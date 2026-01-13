# Hyvä Themes - CMS Tailwind JIT

[![Hyvä Themes](https://hyva.io/media/wysiwyg/logo-compact.png)](https://hyva.io/)

Automatic TailwindCSS styles for CMS content in Hyvä Themes.  

It currently features tailwind JIT compilation and adminhtml previews for

* CMS Blocks
* CMS Pages
* Product Description + Short Description
* Category Description

This module works with both TinyMCE and Magento_PageBuilder.  
In PageBuilder the Content Preview works for CMS Block content and HTML Code content.

## hyva-themes/magento2-cms-tailwind-jit

![Supported Magento Versions][ico-compatibility]

Compatible with Magento 2.4.0 and higher, supporting both TinyMCE and Magento_PageBuilder.

## Installation

### For Hyvä license holders

1. Install via composer
    ```
    composer require hyva-themes/magento2-cms-tailwind-jit
    ```
2. Enable module and run apply database changes
    ```
    bin/magento setup:upgrade
    ```

### For contributions

1. Install via composer
    ```
    composer config repositories.hyva-themes/magento2-cms-tailwind-jit git git@gitlab.hyva.io:hyva-themes/magento2-cms-tailwind-jit.git
    composer require hyva-themes/magento2-cms-tailwind-jit:dev-main --prefer-source
    ```
2. Enable module and run apply database changes
    ```
    bin/magento setup:upgrade
    ```

## Disabling PageBuilder

If the PageBuilder modules are disabled on an instance, a JS mixin for the admin scope needs to be disabled.  
Create a file `view/adminhtml/requirejs-config.js` in a module with the following entry:

```js
var config = {
    config: {
        mixins: {
            'Magento_Ui/js/form/form': {
                'Hyva_CmsTailwindJit/js/form/pagebuilder-form-submit-mixin': false
            }
        }
    }
};
```

Next, be sure to add `Hyva_CmsTailwindJit` as a dependency in the modules `etc/module.xml` sequence, so it is loaded with a higher priority:

```xml
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="My_Module">
        <sequence>
            <module name="Hyva_CmsTailwindJit"/>
        </sequence>
    </module>
</config>
```

Then flush the cache and - if in productionmode - run static-content:deploy.

## Using tailwind classes containing single quotes in Alpine :class attributes

In this case the single quotes in the class name have to be quoted, because they are part of a JS string.  

For example:
```html
<div :class="{'after:content-[\'bar\']': activeTab === 0}"></div>
```

A bug in Tailwind causes the generated CSS to include the quotes in the generated styles.
To work around the issue, add the **unquoted** class name in a HTML comment, like so:

```html
<!-- after:content-['bar'] -->
<div :class="{'after:content-[\'bar\']': activeTab === 0}"></div>
```

This way the generated CSS will contain both versions of the class, but the result will work as expected.


## How it works

When a CMS block, a CMS page, a category description, or a product description is edited in the adminhtml area, the CMS contents are passed to an embedded Tailwind JIT compiler running in the browser.
Tailwind then compiles a list of styles used in the CMS content. The styles are compiled for each store view that uses a Hyvä theme and is assigned to the CMS entity.

When the entity is saved, the compiled CSS is persisted in the tables `hyva_cms_block_tailwindcss`, `hyva_cms_page_tailwindcss`, `hyva_catalog_product_tailwindcss` and `hyva_catalog_category_tailwindcss`.

When an entity is rendered in a Hyvä theme on the frontend, the compiled styles for that bit of content are rendered inline in a `<style>` tag before each block or page content.

## Custom Tailwind Configuration

You may specify a custom configuration in a `web/tailwind/tailwind.browser-jit-config.js` file.  
You can override this file name for a theme by creating a file `etc/cms-tailwind-jit-theme-config.json` in a theme:
```json
{
  "tailwindBrowserJitConfigPath": "../../../../../app/design/frontend/My/theme/web/tailwind/tailwind.browser-jit-config.js"
}
```
A relative path will be evaluated based on the themes directory. An absolute path is evaluated as specified.
If the path begins with a `/` character, it is treated as an absolute path. Any other character will cause the path
to be treated as relative.  
If a specified file doesn't exist or can't be read, it is silently ignored, and no custom tailwind config will be used for that theme.

**Only a subset of the regular tailwind configuration is supported because it will be evaluated in the browser context.**

First, only `module.exports.theme` may be specified.  
No calls to `require()` or `resolveConfig()` are allowed inside the `module.exports` object.  

Two plugins are available during the config processing in the browser (with exactly these constant names):
```js
const { spacing } = require('tailwindcss/defaultTheme');                                                
const colors = require('tailwindcss/colors');
```
Supporting other plugins would require a custom cms-tailwind-jit module build.


### Example tailwind.browser-jit-config.js

```js
const { spacing } = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
  theme: {
    container: {
      center: true
    },
    extend: {
        colors: {
            'my-gray': '#888877',
            primary: {
                lighter: colors.purple['300'],
                "DEFAULT": colors.purple['800'],
                darker: colors.purple['900'],
            },
        }
    },
  }
}
```

### Merging tailwind configs

To avoid declaring the same theme extends in both the `tailwind.config.js` and the `tailwind.browser-jit-config.js`, the 
jit-config can be merged into the regular config by appending the following snippet to the end of the
`tailwind.config.js` file:

```js
if (require('fs').existsSync('./tailwind.browser-jit-config.js')) {

    function isObject(item) {
        return (item && typeof item === 'object' && !Array.isArray(item));
    }

    function mergeDeep(target, ...sources) {
        if (!sources.length) return target;
        const source = sources.shift();

        if (isObject(target) && isObject(source)) {
            for (const key in source) {
                if (isObject(source[key])) {
                    if (!target[key]) Object.assign(target, { [key]: {} });
                    mergeDeep(target[key], source[key]);
                } else {
                    Object.assign(target, { [key]: source[key] });
                }
            }
        }

        return mergeDeep(target, ...sources);
    }

    mergeDeep(module.exports, require('./tailwind.browser-jit-config.js'));
}
```

## Custom User CSS

The `tailwind-source.css` is completely ignored, but it is possible to add custom CSS by creating a 
`web/tailwind/tailwind.browser-jit.css` file in your theme.
The contents will be passed to the JIT compiler in the browser and included in the styles for the CMS content.

The path to the file for the custom CSS can be configured for a theme by creating a file
`etc/cms-tailwind-jit-theme-config.json` in a theme:
```json
{
  "tailwindBrowserJitCssPath": "../../../../../app/design/frontend/My/theme/web/tailwind/tailwind.browser-jit.css"
}
```
A relative path will be evaluated based on the themes directory. An absolute path is evaluated as specified.
If the path begins with a `/` character, it is treated as an absolute path. Any other character will cause the path
to be treated as relative.  
If a specified file doesn't exist or can't be read, it is silently ignored, and no custom CSS will be used for that theme.


## How to build

**This step is only required if you want to customize the JIT compilation code! For 99.9% of all installations, this is not the case.**  
The build instructions are only included in the README so it is easier to pick up development again when a new version of the Tailwind JIT compiler is released. 

The embedded Tailwind JIT compiler is based on [tailwind-jit-cdn](https://github.com/beyondcode/tailwindcss-jit-cdn).  
The source can be found at `src/view/adminhtml/tailwind-jit`.  
To build, change into that directory and run `yarn install`.

Then run `yarn build` to compile the JIT to the `src/view/adminhtml/web/js` directory.  
A `yarn watch` command is available for convenience during development.

## How to re-use

This module is designed to be re-used for other custom HTML content created on adminhtml pages.

There are some steps to follow when using the embedded JIT:

1. Initialize the JIT on the admin page.
2. Observe content changes and pass them to the JIT.
3. Store the compiled CSS, so it is submitted when the content is saved.
4. Create a database table to store the CSS for the entity
5. Observe the entity being saved and store the compiled CSS in the table
6. When the entity content is rendered on the frontend, also load and render the CSS in a `<style>` tag.

### Initializing the JIT on a page
 
To use the JIT on your custom content, include the `tailwind_jit` layout handle in the adminhml layout XML for your page to include the Tailwind JIT.

```xml
<update handle="tailwind_jit"/>
```
There are no visible components. Look for `<iframe id="tailwindcss-jit"` in the source if you are interested.

### Compiling content

Content can be passed to the JIT compiler by calling the JavaScript function 
```js
window.tailwindCSS.process(htmlContent, customConfig, customStyles)
  .then((css) => {
      // do something with the compiler output
  });
```
The `customConfig` and `customStyles` arguments are optional.

If you want to support custom `tailwind.config.js` configurations, see below how to get the custom config for a given theme.

Custom styles passed in the third argument will be included unchanged in the JIT output.

### Getting the custom tailwind-browser-jit-config

In order to call `tailwindCSS.process` with custom configurations, it is necessary to get a list of the available configurations.
Then it is the responsibility of your code to iterate over these configurations and call `process` with each configuration.

To get the custom tailwind config for a given store ID, call:
```js
window.tailwindCSS.configForStore(storeId);
```

To get a themes tailwind config by theme identifier, use:
```js
window.tailwindCSS.configForTheme(theme)
```

The theme identifier is what is used in the theme's `registration.php`, for example, `"frontend/Hyva/default"`.

### Getting a map of store IDs to Hyvä theme identifiers: 

To compile styles for different themes, it is necessary to know which stores have Hyvä themes.  

To fetch a map of all stores that use Hyvä based themes to their respective theme identifiers, use:

```js
window.tailwindCSS.tailwindThemes()
```

To limit the map to specific stores:
```js
window.tailwindCSS.tailwindThemes(array storeIds)
```

The returned map only contains stores that have Hyvä based themes.

### Getting a list of stores for given websites

If an entity is associated to websites instead of stores (for example, like products), it will be necessary to map
website IDs to the list of store IDs, so the appropriate list of tailwind themes can be determined.

To fetch an array of all store IDs, use:

```js
window.tailwindCSS.storeIdsForWebsites()
```

To limit the array of store IDs to specific websites:
```js
window.tailwindCSS.storeIdsForWebsites(array websiteIds)
```


## Credits

This module relies heavily on the [tailwind-jit-cdn](https://github.com/beyondcode/tailwindcss-jit-cdn) project by [Marcel Pociot](https://github.com/mpociot).  
Many thanks for making the tailwindcss processor run in the browser.


## License

Hyvä Themes - https://hyva.io

Copyright © Hyvä Themes B.V 2020-present. All rights reserved.

This product is licensed per Magento install. Please see [License File](LICENSE.md) for more information.

[ico-compatibility]: https://img.shields.io/badge/magento-%202.4-brightgreen.svg?logo=magento&longCache=true&style=flat-square
