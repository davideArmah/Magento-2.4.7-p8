<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Block\Order\Plugin;

class OrderView
{
    /**
     * @param \Magento\Sales\Block\Order\Info $subject
     * @param                                 $result
     *
     * @return string
     */
    public function afterToHtml(\Magento\Sales\Block\Order\Info $subject, $result)
    {
        /** @var \Armah\Orderattr\Block\Order\Attributes $attributesBlock */
        if ($attributesBlock = $subject->getChildBlock('order_attributes')) {
            $result .= $attributesBlock->toHtml();
        }

        return $result;
    }
}
