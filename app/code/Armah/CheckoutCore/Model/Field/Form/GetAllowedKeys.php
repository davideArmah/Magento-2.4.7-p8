<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field\Form;

use Armah\CheckoutCore\Model\Customer\Address\Attribute\CanChangeIfAttributeIsRequired;
use Armah\CheckoutCore\Model\Field;
use Armah\CheckoutCore\Model\ResourceModel\GetCustomerAddressAttributeById;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class GetAllowedKeys
{
    /**
     * @var CanChangeIfAttributeIsRequired
     */
    private $canChangeIfAttributeIsRequired;

    /**
     * @var GetCustomerAddressAttributeById
     */
    private $getCustomerAddressAttributeById;

    /**
     * @var array<string, string>
     */
    private $allowedKeys;

    /**
     * @param CanChangeIfAttributeIsRequired $canChangeIfAttributeIsRequired
     * @param GetCustomerAddressAttributeById $getCustomerAddressAttributeById
     * @param array<string, string> $allowedKeys
     */
    public function __construct(
        CanChangeIfAttributeIsRequired $canChangeIfAttributeIsRequired,
        GetCustomerAddressAttributeById $getCustomerAddressAttributeById,
        array $allowedKeys = []
    ) {
        $this->canChangeIfAttributeIsRequired = $canChangeIfAttributeIsRequired;
        $this->getCustomerAddressAttributeById = $getCustomerAddressAttributeById;
        $this->allowedKeys = $allowedKeys;
    }

    /**
     * @param array $fieldData
     * @return string[]
     */
    public function execute(array $fieldData): array
    {
        $result = $this->allowedKeys;

        if (empty($fieldData[Field::ENABLED])) {
            unset($result[Field::SORT_ORDER]);
        }

        $attribute = $this->getCustomerAddressAttributeById->execute($fieldData[Field::ATTRIBUTE_ID]);
        if (!$this->canChangeIfAttributeIsRequired->execute($attribute->getAttributeCode())) {
            unset($result[Field::REQUIRED]);
        }

        return array_values($result);
    }
}
