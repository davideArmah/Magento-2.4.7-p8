<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Block\Adminhtml\Order\Plugin;

use Armah\Orderattr\Block\Adminhtml\Order\Create\Form\Attributes;

class CreateFormOrderAttributes
{
    public function afterToHtml(\Magento\Sales\Block\Adminhtml\Order\Create\Form\Account $subject, $result)
    {
        $orderAttributesForm = $subject->getLayout()->createBlock(
            Attributes::class,
            '',
            ['orderStoreId' => $subject->getStore()->getId()]
        );
        $orderAttributesForm->setQuote($subject->getQuote());

        return $result . $orderAttributesForm->toHtml();
    }
}
