<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class PercentCalculateBasedOn implements OptionSourceInterface
{
    public const EXCLUDING_TAX = 0;
    public const INCLUDING_TAX = 1;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('Cart Subtotal Excluding Tax'),
                'value' => self::EXCLUDING_TAX
            ],
            [
                'label' => __('Cart Subtotal Including Tax'),
                'value' => self::INCLUDING_TAX
            ]
        ];
    }
}
