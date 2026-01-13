<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Customer\Address\Attribute;

class GetRestrictedCodes
{
    /**
     * @var string[]
     */
    private $restrictedCodes;

    /**
     * @param string[] $restrictedCodes
     */
    public function __construct(array $restrictedCodes = [])
    {
        $this->restrictedCodes = $restrictedCodes;
    }

    public function execute(): array
    {
        return array_values($this->restrictedCodes);
    }
}
