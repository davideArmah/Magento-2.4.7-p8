<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\ResourceModel;

class AttributeFormCodes
{
    public const ADMINHTML_CHECKOUT = 'adminhtml_checkout';
    public const ADMINHTML_CUSTOMER = 'adminhtml_customer';
    public const CUSTOMER_ACCOUNT_CREATE = 'customer_account_create';
    public const CUSTOMER_ACCOUNT_EDIT = 'customer_account_edit';

    // Amasty_CustomerAttributes
    public const ARMAH_CUSTOM_ATTRIBUTES = 'armah_custom_attribute';
    public const ARMAH_CUSTOM_ATTRIBUTES_REGISTRATION = 'customer_attributes_registration';
    public const ARMAH_CUSTOM_ATTRIBUTES_CHECKOUT = 'customer_attributes_checkout';
}
