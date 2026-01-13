<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Block\Checkout\Cart;

use Armah\CashOnDelivery\Model\ConfigProvider;
use Magento\Framework\View\Element\Template;

class CheckAvailable extends Template
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(
        Template\Context $context,
        ConfigProvider $configProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->configProvider = $configProvider;
    }

    /**
     * @return bool
     */
    public function isVerificationEnable()
    {
        return $this->configProvider->isCodeVerificationEnabled();
    }
}
