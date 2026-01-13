<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field\Form\Processor;

interface ProcessorInterface
{
    /**
     * @param array<int, array> $fields
     * @param int $storeId
     * @throws \Exception
     * @return array<int, array> Remaining fields that haven't been processed yet
     */
    public function process(array $fields, int $storeId): array;
}
