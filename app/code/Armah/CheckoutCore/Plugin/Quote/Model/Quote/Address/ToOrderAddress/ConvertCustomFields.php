<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Quote\Model\Quote\Address\ToOrderAddress;

use Armah\CheckoutCore\Api\Data\CustomFieldsConfigInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\Quote\Address\ToOrderAddress;
use Magento\Sales\Api\Data\OrderAddressInterface;

class ConvertCustomFields
{
    /**
     * @param ToOrderAddress $subject
     * @param OrderAddressInterface $result
     * @param AddressInterface $object
     * @param array $data
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterConvert(
        ToOrderAddress $subject,
        OrderAddressInterface $result,
        AddressInterface $quoteAddress,
        $data = []
    ): OrderAddressInterface {
        foreach (CustomFieldsConfigInterface::CUSTOM_FIELDS_ARRAY as $attribute) {
            $result->setData($attribute, $quoteAddress->getData($attribute));
        }

        return $result;
    }
}
