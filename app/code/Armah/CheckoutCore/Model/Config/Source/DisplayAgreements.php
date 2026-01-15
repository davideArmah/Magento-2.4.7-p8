<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class DisplayAgreements implements OptionSourceInterface
{
    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'payment_method', 'label' => __('Below the Selected Payment Method')],
            ['value' => 'order_totals', 'label' => __('Below the Order Total')]
        ];
    }
}
