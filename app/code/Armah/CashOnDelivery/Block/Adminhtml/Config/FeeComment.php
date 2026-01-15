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

class FeeComment extends Field
{
    /**
     * @var string
     */
    public const ARMAH_FEE_URL = 'https://armah.it/extra-fee-for-magento-2.html?utm_source=extension&'
    . 'utm_medium=backend&utm_campaign=cash-on-delivery-fee';

    /**
     * @var string
     */
    public const MARKETPLACE_FEE_URL = 'https://marketplace.magento.com/armah-module-extra-fee.html';

    /**
     * @var string
     */
    private $feeComment = "Floating point numbers only. Up to 2 digits after the point. Should be greater than 0. "
    . "To set more flexible fees, use <a href='%1' target='_blank'>Extra Fee</a> extension.";

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
     * @inheritdoc
     */
    public function render(AbstractElement $element)
    {
        if ($this->moduleManager->isEnabled('Armah_Extrafee')) {
            $url = $this->getUrl('armah_extrafee/index/new');
            $element->setComment(__($this->feeComment, $url));
        } else {
            if ($this->moduleHelper->isOriginMarketplace()) {
                $element->setComment(__($this->feeComment, self::MARKETPLACE_FEE_URL));
            } else {
                $element->setComment(__($this->feeComment, self::ARMAH_FEE_URL));
            }
        }

        return parent::render($element);
    }
}
