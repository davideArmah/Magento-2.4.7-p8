<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Thank you Page 2 for Magento 2 (System)
 */

namespace Armah\CheckoutThankYouPage\Block\Adminhtml\System\Config;

use Armah\CheckoutThankYouPage\Model\ThankYouPageModule;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class SuccessPage extends Field
{
    /**
     * @var ThankYouPageModule
     */
    private $thankYouPageModule;

    public function __construct(
        Context $context,
        ThankYouPageModule $thankYouPageModule,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->thankYouPageModule = $thankYouPageModule;
    }
    
    protected function _getElementHtml(AbstractElement $element): string
    {
        if ($this->thankYouPageModule->isModuleEnable($element->getScope(), (int)$element->getScopeId())) {
            $element->setDisabled('disabled');
        }

        return $element->getElementHtml();
    }
}
