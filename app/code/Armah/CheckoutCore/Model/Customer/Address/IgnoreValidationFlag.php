<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Customer\Address;

class IgnoreValidationFlag
{
    /**
     * @var bool
     */
    private $shouldIgnore = false;

    public function shouldIgnore(): bool
    {
        return $this->shouldIgnore;
    }

    public function setShouldIgnore(bool $shouldIgnore): void
    {
        $this->shouldIgnore = $shouldIgnore;
    }
}
