<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Block\Adminhtml\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class SystemInstanceKey extends Field
{
    protected function _getElementHtml(AbstractElement $element)
    {
        $element->setDisabled(true);

        return parent::_getElementHtml($element) . $this->getCopyToClipboardBtnHtml($element);
    }

    private function getCopyToClipboardBtnHtml(AbstractElement $element): string
    {
        $isElementHasValue = !empty($element->getValue());
        $disabledAttribute = $isElementHasValue ? '' :'disabled';
        $elementSelector = '#' . $element->getHtmlId();
        $ariaLabel = __('Copy to clipboard')->render();

        return <<<BUTTON
            <div class="arbase-clip-btn-contaner">
                  <button
                type="button"
                class="arbase-clip-btn"
                aria-label="{$ariaLabel}"
                {$disabledAttribute}
                data-mage-init='{
                    "arBaseCopyToClipboardButton": {
                        "targetInputSelector": "{$elementSelector}"
                    }
                }'
            >
            </button>
        </div>
        BUTTON;
    }
}
