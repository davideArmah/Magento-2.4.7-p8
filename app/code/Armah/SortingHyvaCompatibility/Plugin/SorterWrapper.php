<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah
 * @package Improved Sorting Hyva Compatibility by Armah
 */

declare(strict_types=1);

namespace Armah\SortingHyvaCompatibility\Plugin;

use Magento\Catalog\Block\Product\ProductList\Toolbar;
use Hyva\Theme\Service\CurrentTheme;
use Armah\Sorting\Helper\Data;

class SorterWrapper
{
    public const SORTER_ELEMENT_REGEX
        = '@\<div[^\>]+?class=\"toolbar-sorter.*?\"\>.*?\<\/div\>@s';

    public const PERMANENT_DIRECTION_ATTRIBUTES = [
        'price_asc',
        'price_desc'
    ];

    /**
     * @var CurrentTheme
     */
    private $currentTheme;

    /**
     * @var Data
     */
    private $helper;

    /**
     * @param CurrentTheme $currentTheme
     * @param Data $helper
     */
    public function __construct(
        CurrentTheme $currentTheme,
        Data $helper
    ) {
        $this->currentTheme = $currentTheme;
        $this->helper = $helper;
    }

    /**
     * Wrap toolbar sorter into div with armSortingDirection component initialization
     *
     * @param Toolbar $subject
     * @param string $result
     * @return string
     */
    public function afterToHtml(Toolbar $subject, string $result): string
    {
        if ($this->currentTheme->isHyva() && $this->isDirectionCanBeHide()) {
            if (preg_match(self::SORTER_ELEMENT_REGEX, $result, $matches)) {
                $sorterElement = $matches[0];
                $sorterElementWrapped = sprintf(
                    '<div x-data="armSortingDirection" x-init="initArmSortingDirection"
                           class="flex items-center order-1 col-span-3 sm:col-span-6
                           md:col-span-3 lg:col-span-6 justify-end">%s</div>',
                    $sorterElement
                );
                return str_replace($sorterElement, $sorterElementWrapped, $result);
            }
        }

        return $result;
    }

    /**
     * Check if price_asc and price_desc enabled
     *
     * @return bool
     */
    private function isDirectionCanBeHide(): bool
    {
        $result = false;
        foreach ($this->getPermanentDirectionAttributes() as $attribute) {
            if ($result = !$this->helper->isMethodDisabled($attribute)) {
                break;
            }
        }

        return $result;
    }

    /**
     * Get sorting attributes
     *
     * @return array
     */
    public function getPermanentDirectionAttributes(): array
    {
        return static::PERMANENT_DIRECTION_ATTRIBUTES;
    }
}
