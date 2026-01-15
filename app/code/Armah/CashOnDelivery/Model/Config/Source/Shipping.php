<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Shipping implements OptionSourceInterface
{
    public const ALL_SHIPPING = 0;
    public const SPECIFIC_SHIPPING = 1;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('All Allowed Shipping Methods'),
                'value' => self::ALL_SHIPPING
            ],
            [
                'label' => __('Specific Shipping Methods'),
                'value' => self::SPECIFIC_SHIPPING
            ]
        ];
    }
}
