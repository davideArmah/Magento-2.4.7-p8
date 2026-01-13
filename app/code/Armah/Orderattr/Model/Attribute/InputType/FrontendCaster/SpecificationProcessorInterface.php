<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */
namespace Armah\Orderattr\Model\Attribute\InputType\FrontendCaster;

use Armah\Orderattr\Api\Data\CheckoutAttributeInterface;

/**
 * Service Provider Interface - SPI
 */
interface SpecificationProcessorInterface
{
    /**
     * @param string[] $element
     * @param CheckoutAttributeInterface $attribute
     * @return void
     */
    public function processSpecificationByAttribute(array &$element, CheckoutAttributeInterface $attribute): void;
}
