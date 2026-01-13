<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Model\Source;

use Magento\Framework\Option\ArrayInterface;

class CategoryData implements ArrayInterface
{
    const FROM_PRODUCT_CATEGORIES = '1';
    const FROM_BREADCRUMBS = '0';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [
                'value' => self::FROM_PRODUCT_CATEGORIES,
                'label' => __('From Product Associated Categories')
            ],
            [
                'value' => self::FROM_BREADCRUMBS,
                'label' => __('From Breadcrumbs')
            ]
        ];

        return $options;
    }
}
