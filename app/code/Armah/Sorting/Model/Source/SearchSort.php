<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Source;

use Magento\Catalog\Model\Config\Source\ListSort;

class SearchSort extends ListSort
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = parent::toOptionArray();
        array_shift($options);
        array_unshift($options, [
            'value' => 'relevance',
            'label' => __('Relevance')
        ]);

        return $options;
    }
}
