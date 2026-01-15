<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field;

use Armah\CheckoutCore\Model\Config;
use Magento\Customer\Model\Attribute;
use Magento\Eav\Model\ResourceModel\Entity\Attribute as AttributeResource;
use Magento\Framework\Exception\AlreadyExistsException;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class UpdateTelephoneAttribute
{
    /**
     * @var AttributeResource
     */
    private $attributeResource;

    /**
     * @var Config
     */
    private $configProvider;

    public function __construct(
        AttributeResource $attributeResource,
        Config $configProvider
    ) {
        $this->attributeResource = $attributeResource;
        $this->configProvider = $configProvider;
    }

    /**
     * @param Attribute $attribute
     * @throws AlreadyExistsException
     * @throws \Exception
     */
    public function execute(Attribute $attribute): void
    {
        $this->configProvider->saveTelephoneOption('');
        $attribute->setIsRequired(false);
        $this->attributeResource->save($attribute);
    }
}
