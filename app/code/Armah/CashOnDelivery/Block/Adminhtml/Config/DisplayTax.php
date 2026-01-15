<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Block\Adminhtml\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Phrase;

class DisplayTax extends Field
{
    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $url = $this->getUrl('adminhtml/system_config/edit/section/payment');
        $element->setComment($this->getCommentMessage($url));

        return parent::render($element);
    }

    /**
     * @param string $url
     * @return Phrase
     */
    private function getCommentMessage(string $url): Phrase
    {
        return __(
            "More Cash On Delivery related options are available at payment methods' "
            . "<a href='%1' onclick=\"return confirm('Unsaved changes will be discarded.')\">configuration page</a> "
            . "(scroll to Cash On Delivery Payment by Armah).",
            $url
        );
    }
}
