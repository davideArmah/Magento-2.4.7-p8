<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Block\Adminhtml\Config;

use Armah\Base\Helper\Module;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Module\Manager;

class ShippingComment extends Field
{
    /**
     * @var string
     */
    public const ARMAH_PAYMENT_RESTRICTION_URL = 'https://armah.it/payment-restrictions-for-magento-2.html'
    . '?utm_source=extension&utm_medium=backend&utm_campaign=cash-on-delivery-allowed-shipping-methods';

    /**
     * @var string
     */
    public const MARKETPLACE_PAYMENT_RESTRICTION_URL = 'https://marketplace.magento.com/armah-payrestriction.html';

    //phpcs:disable Magento2.SQL.RawQuery.FoundRawSql
    /**
     * @var string
     */
    private $paymentComment = "Select all or clear the selection to allow all shipping methods. If you want to apply"
    . " more restrictions, please use <a href='%1' target='_blank'>Payment Restrictions</a> extension.";
    //phpcs:enable Magento2.SQL.RawQuery.FoundRawSql

    /**
     * @var Manager
     */
    private $moduleManager;

    /**
     * @var Module
     */
    private $moduleHelper;

    public function __construct(
        Context $context,
        Manager $moduleManager,
        Module $moduleHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->moduleManager = $moduleManager;
        $this->moduleHelper = $moduleHelper;
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        if ($this->moduleManager->isEnabled('Armah_Payrestriction')) {
            $url = $this->getUrl('armah_payrestriction/rule/newAction');
            $element->setComment(__($this->paymentComment, $url));
        } else {
            if ($this->moduleHelper->isOriginMarketplace()) {
                $element->setComment(__($this->paymentComment, self::MARKETPLACE_PAYMENT_RESTRICTION_URL));
            } else {
                $element->setComment(__($this->paymentComment, self::ARMAH_PAYMENT_RESTRICTION_URL));
            }
        }

        return parent::render($element);
    }
}
