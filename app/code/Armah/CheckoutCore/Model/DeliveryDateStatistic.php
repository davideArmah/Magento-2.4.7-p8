<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model;

use Armah\CheckoutCore\Api\DeliveryDateStatisticInterface;

class DeliveryDateStatistic implements DeliveryDateStatisticInterface
{
    /**
     * Used for provide Delivery Date data from submodule
     *
     * @param array $quoteIds
     * @param int $quoteTotalCount
     * @return array
     */
    public function collect(array $quoteIds = [], int $quoteTotalCount = 1): array
    {
        return [
            'delivery' => [],
            'delivery_total_count' => 0
        ];
    }
}
