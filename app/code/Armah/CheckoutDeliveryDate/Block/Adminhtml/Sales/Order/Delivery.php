<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Delivery Date for Magento 2 (System)
 */

namespace Armah\CheckoutDeliveryDate\Block\Adminhtml\Sales\Order;

class Delivery extends \Armah\CheckoutDeliveryDate\Block\Sales\Order\Info\Delivery
{
    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setTemplate('Armah_CheckoutDeliveryDate::sales/order/delivery.phtml');
    }
}
