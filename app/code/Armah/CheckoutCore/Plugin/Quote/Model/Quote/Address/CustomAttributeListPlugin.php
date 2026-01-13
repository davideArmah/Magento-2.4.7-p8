<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Quote\Model\Quote\Address;

use Armah\CheckoutCore\Api\Data\CustomFieldsConfigInterface;
use Magento\Customer\Model\Attribute;
use Magento\Customer\Model\AttributeMetadataConverter;
use Magento\Customer\Model\Indexer\Address\AttributeProvider;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote\Address\CustomAttributeListInterface;

class CustomAttributeListPlugin
{
    /**
     * @var AttributeRepositoryInterface
     */
    private $eavAttributeRepository;

    /**
     * @var AttributeMetadataConverter
     */
    private $attributeMetadataConverter;

    /**
     * @var \Magento\Framework\Api\MetadataObjectInterface[]
     */
    private $attributes = null;

    public function __construct(
        AttributeRepositoryInterface $eavAttributeRepository,
        AttributeMetadataConverter $attributeMetadataConverter
    ) {
        $this->eavAttributeRepository = $eavAttributeRepository;
        $this->attributeMetadataConverter = $attributeMetadataConverter;
    }

    /**
     * @param CustomAttributeListInterface $subject
     * @param array $result
     *
     * @return array
     */
    public function afterGetAttributes(CustomAttributeListInterface $subject, array $result): array
    {
        if ($this->attributes === null) {
            foreach (CustomFieldsConfigInterface::CUSTOM_FIELDS_ARRAY as $attributeCode) {
                try {
                    /** @var Attribute $customAttribute */
                    $customAttribute =
                        $this->eavAttributeRepository->get(AttributeProvider::ENTITY, $attributeCode);
                } catch (NoSuchEntityException $exception) {
                    continue;
                }

                if ($customAttribute->getAttributeCode()) {
                    $this->attributes[$customAttribute->getAttributeCode()] = $this->attributeMetadataConverter
                        ->createMetadataAttribute($customAttribute);
                }
            }
        }

        return $this->attributes ? array_merge($result, $this->attributes) : $result;
    }
}
