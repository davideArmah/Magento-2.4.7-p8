<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Block\Adminhtml\Field\Edit;

use Armah\CheckoutCore\Block\Adminhtml\Renderer\Template;
use Magento\Backend\Block\Template\Context;
use Armah\CheckoutCore\Model\ModuleEnable;

class AdditionalOptions extends Template
{
    /**
     * @var ModuleEnable
     */
    private $moduleEnable;

    public function __construct(
        Context $context,
        ModuleEnable $moduleEnable,
        array $data = []
    ) {
        $this->moduleEnable = $moduleEnable;
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function isOrderAttributesEnable()
    {
        return $this->moduleEnable->isOrderAttributesEnable();
    }

    /**
     * @return bool
     */
    public function isCustomerAttributesEnable()
    {
        return $this->moduleEnable->isCustomerAttributesEnable();
    }
}
