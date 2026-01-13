<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Block\Adminhtml\Order\Plugin;

class OrderView
{
    /**
     * @param \Magento\Sales\Block\Adminhtml\Order\View\Info $subject
     * @param string                                         $result
     *
     * @return string
     */
    public function afterToHtml(
        \Magento\Sales\Block\Adminhtml\Order\View\Info $subject,
        $result
    ) {
        $attributesBlock = $subject->getChildBlock('order_attributes');
        if ($attributesBlock) {
            $attributesBlock->setTemplate("Armah_Orderattr::order/view/attributes.phtml");
            $result = $result . $attributesBlock->toHtml();
        }

        return $result;
    }
}
