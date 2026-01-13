# Hyvä Themes - Heroicons 2

[![Hyvä Themes](https://hyva.io/media/wysiwyg/logo-compact.png)](https://hyva.io/)

## hyva-themes/magento2-heroicons2

![Supported Magento Versions][ico-compatibility]

This module enables the usage of [Heroicons](https://heroicons.com/) version 2 SVG icons.

Compatible with Magento 2.4.0 and higher.

## Installation

1. Install via composer

   With Private Packagist access:
   ```bash
   composer require hyva-themes/magento2-heroicons2
   ```

   \- OR -

   With Gitlab access:
   ```bash
   composer config repositories.hyva-themes/magento2-heroicons2 git git@gitlab.hyva.io:hyva-themes/magento2-heroicons2.git
   composer require hyva-themes/magento2-heroicons2:dev-main
   ```

2. Enable module
    ```bash
    bin/magento setup:upgrade
    ```

## Configuration

No configuration needed.

## Usage and Customization

Please refer to the Hyvä Docs for information about SvgIcon usage in Hyvä
Themes: https://docs.hyva.io/hyva-themes/writing-code/working-with-view-models/svgicons.html

There are currently 3 implementations: solid, outline and mini.
Respectively the `Heroicons2Solid`, `Heroicons2Outline` and `Heroicons2Mini` ViewModels, located
in `Hyva\Heroicons2\ViewModel`.

The available icon render methods can be found at `src/ViewModel/Heroicons2Interface.php`, but they will also
auto-complete in your IDE.

For usage in phtml files:

```php
$heroicons = $viewModels->require(\Hyva\Heroicons2\ViewModel\Heroicons2Outline::class);

echo $heroicons->shoppingCartHtml('w-6 h-6');
```

The icons can also be rendered in CMS content, using the `{{icon}}` directive. Find the path of the SVG
inside `/src/view/frontend/web/svg/`, and remove the `.svg` at the end.

For instance, `/src/view/frontend/web/svg/heroicons2/24/solid/shopping-cart.svg` can be used as `heroicons2/24/solid/shopping-cart`.

For usage in CMS pages:

```jsx
{{icon "heroicons2/24/solid/shopping-cart" classes="w-6 h-6" width=12 height=12}}
```

## Icon License

The [Heroicons](https://github.com/tailwindlabs/heroicons) used in this module were created by TailwindLabs and are
licensed under the MIT License

## Credits

- [All Contributors][link-contributors]

## Module License

Hyvä Themes - https://hyva.io

Copyright © Hyvä Themes B.V 2020-present. All rights reserved.

This product is licensed per Magento install. Please see [License File](LICENSE.md) for more information.

[ico-compatibility]: https://img.shields.io/badge/magento-%202.4-brightgreen.svg?logo=magento&longCache=true&style=flat-square

[link-contributors]: ../../contributors
