<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Checkout\Model\ShippingInformationManagement;

use Armah\CheckoutCore\Helper\Address;
use Magento\Checkout\Model\ShippingInformationManagement;
use Magento\Checkout\Api\Data\ShippingInformationInterface;

/**
 * area webapi_rest
 */
class FillAddressData
{
    /**
     * @var Address
     */
    private $addressHelper;

    public function __construct(
        Address $addressHelper
    ) {
        $this->addressHelper = $addressHelper;
    }

    /**
     * @param ShippingInformationManagement $subject
     * @param $cartId
     * @param ShippingInformationInterface $addressInformation
     *
     * @return array
     */
    public function beforeSaveAddressInformation(
        ShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        foreach ([$addressInformation->getShippingAddress(), $addressInformation->getBillingAddress()] as $address) {
            if ($address) {
                $this->addressHelper->fillEmpty($address);
            }
        }

        return [$cartId, $addressInformation];
    }
}
