<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * @deprecated
 * @see \Armah\CheckoutCore\Setup\RecurringData
 */
class SyncWithCheckoutFields implements DataPatchInterface
{
    public function apply(): SyncWithCheckoutFields
    {
        return $this;
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }
}
