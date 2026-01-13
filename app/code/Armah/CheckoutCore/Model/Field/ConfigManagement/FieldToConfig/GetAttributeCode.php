<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field\ConfigManagement\FieldToConfig;

use Armah\CheckoutCore\Model\Field;
use Armah\CheckoutCore\Model\ResourceModel\GetCustomerAddressAttributeById;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class GetAttributeCode
{
    /**
     * @var GetCustomerAddressAttributeById
     */
    private $getCustomerAddressAttributeById;

    public function __construct(GetCustomerAddressAttributeById $getCustomerAddressAttributeById)
    {
        $this->getCustomerAddressAttributeById = $getCustomerAddressAttributeById;
    }

    public function execute(Field $field): ?string
    {
        $attributeId = $field->getAttributeId();
        if (!$attributeId) {
            return null;
        }

        $attribute = $this->getCustomerAddressAttributeById->execute($attributeId);
        if (!$attribute) {
            return null;
        }

        return $attribute->getAttributeCode();
    }
}
