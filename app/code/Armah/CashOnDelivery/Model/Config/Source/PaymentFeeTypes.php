<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class PaymentFeeTypes implements OptionSourceInterface
{
    public const FIXED_AMOUNT = 0;
    public const PERCENT = 1;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('Fixed Amount'),
                'value' => self::FIXED_AMOUNT
            ],
            [
                'label' => __('Percent'),
                'value' => self::PERCENT
            ]
        ];
    }
}
