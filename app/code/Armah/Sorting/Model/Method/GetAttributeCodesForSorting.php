<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Method;

use Armah\Sorting\Model\ConfigProvider;
use Armah\Sorting\Model\MethodProvider;
use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Provide attribute codes used for sorting by armah sorting.
 * This attributes must be added for indexation.
 */
class GetAttributeCodesForSorting
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var MethodProvider
     */
    private $methodProvider;

    /**
     * @var ProductAttributeRepositoryInterface
     */
    private $productAttributeRepository;

    /**
     * @var string[]
     */
    private $attributeCodesForSorting;

    public function __construct(
        ConfigProvider $configProvider,
        MethodProvider $methodProvider,
        ProductAttributeRepositoryInterface $productAttributeRepository
    ) {
        $this->configProvider = $configProvider;
        $this->methodProvider = $methodProvider;
        $this->productAttributeRepository = $productAttributeRepository;
    }

    public function execute(): array
    {
        if ($this->attributeCodesForSorting === null) {
            $this->attributeCodesForSorting = $this->getAttributeCodes();
        }

        return $this->attributeCodesForSorting;
    }

    /**
     * Check if eav attribute exists.
     *
     * Detect if passed attribute code need be processed with magento.
     * If armah method exist with same code, armah method more priority and processed by Sorting module.
     */
    private function isEavAttribute(string $sortAttributeCode): bool
    {
        if ($this->methodProvider->getMethodByCode($sortAttributeCode) !== null) {
            return false;
        }

        try {
            $this->productAttributeRepository->get($sortAttributeCode);
            $result = true;
        } catch (NoSuchEntityException $e) {
            $result = false;
        }

        return $result;
    }

    private function getAttributeCodes(): array
    {
        $attributes = [
            'created_at',
            'small_image',
            $this->configProvider->getBestsellerAttributeCode(),
            $this->configProvider->getRevenueAttributeCode(),
            $this->configProvider->getMostviewedAttributeCode(),
            $this->configProvider->getNewAttributeCode(),
            $this->configProvider->getGlobalSorting()
        ];

        return array_filter($attributes, function (?string $attribute) {
            return $attribute && $this->isEavAttribute($attribute);
        });
    }
}
