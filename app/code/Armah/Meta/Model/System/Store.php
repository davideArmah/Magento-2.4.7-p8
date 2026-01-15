<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Model\System;

class Store extends \Magento\Store\Model\System\Store
{
    /**
     * Retrieve store values for form
     *
     * @param bool $empty
     * @param bool $all
     * @return array
     */
    public function getStoreValuesForForm($empty = false, $all = false)
    {
        $options = parent::getStoreValuesForForm($empty, $all);

        if ($empty) {
            $options[0] = [
                'label' => __('Default'),
                'value' => 0
            ];
        }

        return $options;
    }
}
