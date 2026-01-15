<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Quote\Model\CustomerManagement;

use Armah\CheckoutCore\Model\Customer\Address\QuoteRegistry;
use Magento\Quote\Model\CustomerManagement;
use Magento\Quote\Model\Quote;

/**
 * @see \Armah\CheckoutCore\Plugin\Customer\Model\Address\AddGuestData
 */
class FixGuestAddressValidationPlugin
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
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeValidateAddresses(CustomerManagement $subject, Quote $quote): void
    {
        $this->quoteRegistry->setQuote($quote);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param CustomerManagement $subject
     * @param null $result
     */
    public function afterValidateAddresses(CustomerManagement $subject, $result): void
    {
        $this->quoteRegistry->setQuote(null);
    }
}
