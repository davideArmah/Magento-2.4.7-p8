<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Api\Data;

interface ManageCheckoutTabsInterface
{
    /**
     * Constants defined for config values
     */
    public const CUSTOMER_INFO_TAB = 'customer';
    public const ORDER_SUMMARY_TAB = 'summary';
    public const PAYMENT_METHOD_TAB = 'payment';
    public const SHIPPING_METHOD_TAB = 'shipping';
}
