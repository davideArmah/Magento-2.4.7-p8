<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\CustomerAttribute;

class Storage
{
    /**
     * @var string[]
     */
    private $customerAttributesCodes = [];

    /**
     * @return string[]
     */
    public function getCustomerAttributesCodes(): array
    {
        return $this->customerAttributesCodes;
    }

    public function addCustomerAttributeCode(string $code): void
    {
        $this->customerAttributesCodes[] = $code;
    }
}
