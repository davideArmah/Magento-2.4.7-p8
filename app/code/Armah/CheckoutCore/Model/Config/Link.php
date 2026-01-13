<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;

class Link extends Field
{
    protected function _getElementHtml(AbstractElement $element)
    {
        $element->setHref($this->getUrl('armah_checkout/field'));
        $confirmMessage = $this->escapeQuote($this->escapeHtml(__('Unsaved changes will be discarded.')));
        $element->setOnclick('return confirm(\'' . $confirmMessage . '\')');

        return parent::_getElementHtml($element);
    }

    protected function _renderScopeLabel(AbstractElement $element)
    {
        return '';
    }
}
