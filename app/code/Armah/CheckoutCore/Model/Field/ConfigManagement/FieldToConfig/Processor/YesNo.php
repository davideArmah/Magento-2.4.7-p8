<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field\ConfigManagement\FieldToConfig\Processor;

use Armah\CheckoutCore\Model\Field;
use Armah\CheckoutCore\Model\Field\ConfigManagement\FieldToConfig\SaveConfigValue;
use Armah\CheckoutCore\Model\Field\ConfigManagement\YesNoOptions;

class YesNo implements ProcessorInterface
{
    /**
     * @var SaveConfigValue
     */
    private $saveConfigValue;

    public function __construct(SaveConfigValue $saveConfigValue)
    {
        $this->saveConfigValue = $saveConfigValue;
    }

    public function execute(Field $field, string $configPath): void
    {
        $this->saveConfigValue->execute(
            $configPath,
            $field->isEnabled() ? YesNoOptions::VALUE_YES : YesNoOptions::VALUE_NO
        );
    }
}
