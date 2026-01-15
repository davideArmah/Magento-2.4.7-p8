<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field\ConfigManagement\FieldToConfig\Processor;

use Armah\CheckoutCore\Model\Field;

interface ProcessorInterface
{
    /**
     * @param Field $field
     * @param string $configPath
     * @return void
     */
    public function execute(Field $field, string $configPath): void;
}
