<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Customer\Model\Metadata\AddressMetadata;

use Armah\CheckoutCore\Api\Data\CustomFieldsConfigInterface;
use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Model\Metadata\AddressMetadata;

class AddCustomAttributes
{
    /**
     * @param AddressMetadata $subject
     * @param array $result
     * @param string $dataObjectClassName
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetCustomAttributesMetadata(
        AddressMetadata $subject,
        array $result,
        $dataObjectClassName = AddressMetadataInterface::DATA_INTERFACE_NAME
    ): array {
        foreach ($subject->getAllAttributesMetadata() as $attribute) {
            if (in_array($attribute->getAttributeCode(), CustomFieldsConfigInterface::CUSTOM_FIELDS_ARRAY, true)) {
                $result[] = $attribute;
            }
        }

        return $result;
    }
}
