<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Block\Adminhtml\System\Config;

use Armah\CheckoutCore\Model\Config\SocialLogin\CheckoutPositionValue;
use Armah\CheckoutCore\Model\ModuleEnable;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class SocialLogin extends Field
{
    /**
     * @var ModuleEnable
     */
    private $moduleEnable;
    
    /**
     * @var CheckoutPositionValue
     */
    private $checkoutPositionValue;

    /**
     * @param Context $context
     * @param ModuleEnable $moduleEnable
     * @param CheckoutPositionValue $checkoutPositionValue
     * @param array $data
     */
    public function __construct(
        Context $context,
        ModuleEnable $moduleEnable,
        CheckoutPositionValue $checkoutPositionValue,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->moduleEnable = $moduleEnable;
        $this->checkoutPositionValue = $checkoutPositionValue;
    }
    
    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        $url = 'https://amasty.com/social-login-for-magento-2.html';
        $element->setComment(
            __(
                "Let your customers sign in with different social networks on the checkout. "
                . "This setting is enabled once Social Login is installed. Learn more about it "
                . "<a target='_blank' href='%1'>here</a>.",
                $url
            )
        );

        return parent::render($element);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        if (!$this->moduleEnable->isSocialLoginEnable()) {
            $element->setDisabled('disabled');
        }
        
        $socialLoginValue = $this->checkoutPositionValue->getPositionValue(
            $element->getScope(),
            (int)$element->getScopeId()
        );
        if ((int)$element->getValue() !== $socialLoginValue) {
            $element->setValue($socialLoginValue);
        }

        return $element->getElementHtml();
    }
}
