<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\Model;

use function array_map as map;
use function array_reduce as reduce;
use function array_unique as unique;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class PrefixJitClasses
{
    public function prefixJitClassesInCss(string $generatedCss, string $prefix): string
    {
        // Since this method manipulates the css string from which the class names are extracted, we don't care if
        // any characters already are escaped or not.
        // (Note that a : in a class name is escaped as \: in the generated css.)
        $classes = map('preg_quote', $this->extractCssClassNamesFromStyles($generatedCss));

        // find all class names in css to be replaced with prefixed version
        $find = '/\.(' . str_replace('/', '\/', implode('|', $classes)) . '\s*{)/';

        $replace = '.' . $prefix . '$1';

        $prefixedCss = preg_replace($find, $replace, $generatedCss);

        // Tailwind generates HTML entities escaped CSS. In HTML class attributes the CSS class names are automatically
        // decoded, but in the inline <style> tags it isn't because of the leading backslashes.
        // We need to replace the escaped HTML entity with a literal one to match the decoded version in the HTML class attribute.
        return str_replace('\\&amp\\;', '\\&', $prefixedCss);
    }

    public function extractCssClassNamesFromStyles(string $css): array
    {
        // find all css declarations in styles
        $classes = preg_match_all('/(?:^|}|\s)\.(?<classes>[^{]+)/m', $css, $matches)
            ? unique($matches['classes'])
            : [];
        $classes = reduce($classes, function (array $acc, string $class): array {
            // split "group[open] .group-open\:text-blue-600" to ["group", "group-open\:text-blue-600"]
            // split "group[aria-expanded="true"] .group-aria-expanded\:text-blue-600" to ["group", "group-open\:text-blue-600"]
            if (preg_match('/group\[[^]]+\] \.(?<groupClass>group-[^ {]+)/', $class, $m)) {
                $acc[] = 'group';
                $acc[] = $m['groupClass'];
            } else {
                $acc[] = $class;
            }
            return $acc;
        }, []);

        return map('trim', $classes);
    }

    public function prefixJitClassesInHtml(string $css, string $html, string $prefix): string
    {
        $cssClassesFromStyles           = $this->extractCssClassNamesFromStyles($css);
        // Some styles like space-x-4 generate CSS selectors like .space-x-4 > :not([hidden]) ~ :not([hidden])
        // We need to cut off everything after the first space if present.
        $classNamesOnly = map(static function (string $class) {
            // commas in a class like from-[rgba(67,103,119,0.4)] are compiled to '\2c ' by tailwind. We need to revert that to match the styles in HTML attributes
            $classWithRestoredCommas = preg_replace('/\\\2c /', ',', $class);
            $pos = strpos($classWithRestoredCommas, ' ');
            return substr($classWithRestoredCommas, 0, $pos === false ? strlen($class) : $pos);
        }, $cssClassesFromStyles);
        // Remove training pseudo variant selectors like :hover and ::after. Note: the : is NOT escaped for them!
        $classesWithoutPseudoElements   = preg_replace('/(?<!\\\):.+$/', '', $classNamesOnly);

        // Unescape already escaped \:, \/, \[, \], \# in class names so that they aren't double-escaped
        // by preg_quote in the regex class names...
        // However, in class names in the html attribute those characters are not escaped.
        // For this reason we remove any escaping from the class name before using them in the regex search pattern.
        // Characters escaped by tailwind: ['\\:', '\\/', '\\[', '\\]', '\\#'] -> [':', '/', '[', ']', '#']
        // Classes with numbers in them like 2xl:text-sm are escaped with \32xl\:text-sm, so we need to treat \3 special
        $classesWithoutTailWindEscaping = str_replace(['\3', '\\'], '', $classesWithoutPseudoElements);

        $regexClasses = map('preg_quote', $classesWithoutTailWindEscaping);
        if (empty($regexClasses)) {
            return $html;
        }

        $findClassAttributeRegexes = [
            // find all class="" attributes
            '/\s(?<attr>class=)(?<quote>[\'"])(?<value>.*?)\k<quote>/sim',

            // find all {{icon "heroicons/solid/shopping-cart" classes="w-6 h-6 text-blue-800" width=12 height=12}} attributes
            '/\s(?<attr>classes=)(?<quote>[\'"])(?<value>.*?)\k<quote>/sim',
        ];

        // find all classes in attribute value to be replaced with prefixed version
        $fullyEscapedHtmlAttrRegex = str_replace('/', '\/', implode('|', $regexClasses));
        $findCssClassInHtmlAttr    = '/(?<![a-z[:\]-])(?<class>' . $fullyEscapedHtmlAttrRegex . ')(?![a-z[:\]-])/s';

        $classesInHtmlAttrs = reduce($findClassAttributeRegexes, function (string $html, string $findClassAttributeRegex) use ($findCssClassInHtmlAttr, $prefix): string {
            return preg_replace_callback(
                $findClassAttributeRegex,
                function (array $attributeMatch) use ($findCssClassInHtmlAttr, $prefix) {
                    $result = preg_replace($findCssClassInHtmlAttr, $prefix . '$1', $attributeMatch['value']);
                    $wrapperStart = $attributeMatch['wrapperStart'] ?? '';
                    $wrapperEnd = $attributeMatch['wrapperEnd'] ?? '';
                    return " {$attributeMatch['attr']}{$attributeMatch['quote']}{$wrapperStart}$result{$wrapperEnd}{$attributeMatch['quote']}";
                },
                $html
            );
        }, $html);

        // Handle classes in JS strings in :class attributes - ' and " quotes are quoted with a backslash in the JS string, so the regex needs to be adjusted accordingly
        // This doesn't work due to the styles generated by tailwind also containing the quotes around the content string (see note in readme)
        $fullyEscapedJsStrRegex = str_replace(['/', "'", '"'], ['\/', "\\\\'", '\\\\"'], implode('|', $regexClasses));
        $findCssClassInJsStr    = '/(?<![a-z[:\]-])(?<class>' . $fullyEscapedJsStrRegex . ')(?![a-z[:\]-])/s';

        return preg_replace_callback(
             // find all :class="{'foo before:content-[\'bar\']': 1 === 1}" attributes
            '/\s(?<attr>(?:x-bind)?:class=)(?<quote>[\'"])(?<wrapperStart>{)(?<value>[^}]+)(?<wrapperEnd>})\k<quote>/sim',
            function (array $attributeMatch) use ($findCssClassInJsStr, $prefix) {
                $result = preg_replace($findCssClassInJsStr, $prefix . '$1', $attributeMatch['value']);
                $wrapperStart = $attributeMatch['wrapperStart'] ?? '';
                $wrapperEnd = $attributeMatch['wrapperEnd'] ?? '';
                return " {$attributeMatch['attr']}{$attributeMatch['quote']}{$wrapperStart}$result{$wrapperEnd}{$attributeMatch['quote']}";
            },
            $classesInHtmlAttrs
        );
    }
}
