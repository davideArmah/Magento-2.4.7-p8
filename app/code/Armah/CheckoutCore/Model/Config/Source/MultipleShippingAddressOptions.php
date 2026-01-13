<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class MultipleShippingAddressOptions implements OptionSourceInterface
{
    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('Grid'),
                'value' => 0
            ],
            [
                'label' => __('Dropdown Menu'),
                'value' => 1
            ]
        ];
    }
}
