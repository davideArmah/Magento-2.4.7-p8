<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Base\Model\ModuleInfoProvider;

use Armah\Base\Model\ModuleInfoProvider;

class RestrictOSC
{
    /**
     * @param ModuleInfoProvider $subject
     * @param array $result
     * @return array
     */
    public function afterGetRestrictedModules(ModuleInfoProvider $subject, $result): array
    {
        $result[] = 'Armah_Checkout';

        return $result;
    }
}
