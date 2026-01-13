<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field\ConfigManagement\ConfigToAttribute\Processor;

use Armah\CheckoutCore\Model\Field\ConfigManagement\CustomerAttributes\UpdateAttribute;
use Armah\CheckoutCore\Model\Field\ConfigManagement\YesNoOptions;
use Magento\Customer\Model\Attribute;

class YesNo implements ProcessorInterface
{
    /**
     * @var UpdateAttribute
     */
    private $updateAttribute;

    public function __construct(UpdateAttribute $updateAttribute)
    {
        $this->updateAttribute = $updateAttribute;
    }

    public function execute(Attribute $attribute, string $value, int $websiteId): void
    {
        if ($value !== YesNoOptions::VALUE_NO && $value !== YesNoOptions::VALUE_YES) {
            return;
        }

        $this->updateAttribute->execute(
            $attribute,
            $value === YesNoOptions::VALUE_YES,
            false,
            $websiteId
        );
    }
}
