<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Customer\Model\Address;

use Armah\CheckoutCore\Model\Customer\Address\QuoteRegistry;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Model\Address;

class AddGuestData
{
    /**
     * @var QuoteRegistry
     */
    private QuoteRegistry $quoteRegistry;

    public function __construct(QuoteRegistry $quoteRegistry)
    {
        $this->quoteRegistry = $quoteRegistry;
    }

    /**
     * Fix guest address data validation for magento 2.4.8
     *
     * Add missed data from the billing address which may be set to required by OSC
     *
     * @see \Magento\Customer\Model\Address::updateData
     * @see \Magento\Quote\Model\CustomerManagement::validateAddresses
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeUpdateData(Address $subject, AddressInterface $address): ?array
    {
        $quote = $this->quoteRegistry->getQuote();
        if ($quote && $quote->getCustomerIsGuest() && ($billingAddress = $quote->getBillingAddress())) {
            $address->setCompany($billingAddress->getCompany());
            $address->setFax($billingAddress->getFax());
            $address->setRegionId($billingAddress->getRegionId());
            $address->setMiddlename($billingAddress->getMiddlename());
            $address->setPrefix($billingAddress->getPrefix());
            $address->setSuffix($billingAddress->getSuffix());

            return [$address];
        }

        return null;
    }
}
