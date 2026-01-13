<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Api;

interface CheckoutBlocksProviderInterface
{
    /**
     * @return array
     */
    public function getDefaultBlockTitles(): array;

    /**
     * @param ?int $store
     * @return array
     */
    public function getBlocksConfig(?int $store = null): array;
}
