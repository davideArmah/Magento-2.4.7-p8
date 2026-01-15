<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field\ConfigManagement\ConfigToAttribute\Processor;

use Magento\Customer\Model\Attribute;

interface ProcessorInterface
{
    /**
     * @param Attribute $attribute
     * @param string $value
     * @param int $websiteId
     * @return void
     */
    public function execute(Attribute $attribute, string $value, int $websiteId): void;
}
