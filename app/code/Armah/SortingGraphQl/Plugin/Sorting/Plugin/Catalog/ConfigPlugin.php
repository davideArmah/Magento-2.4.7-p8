<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Armah Improved Sorting GraphQl for Magento 2 (System)
 */

namespace Armah\SortingGraphQl\Plugin\Sorting\Plugin\Catalog;

use Armah\Sorting\Plugin\Catalog\Config;

class ConfigPlugin
{
    /**
     * @param Config $subject
     * @param array $options
     * @return array
     */
    public function afterAfterGetAttributesUsedForSortBy(Config $subject, array $options)
    {
        foreach ($options as $key => $option) {
            $options[$key] = [
                'attribute_code' => $option->getData('attribute_code'),
                'frontend_label' => $option->getStoreLabel()
            ];
        }

        return $options;
    }
}
