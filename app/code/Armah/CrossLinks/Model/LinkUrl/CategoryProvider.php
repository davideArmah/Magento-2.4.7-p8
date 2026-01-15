<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model\LinkUrl;

use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class CategoryProvider
{
    /**
     * @var array
     */
    private array $storage = [];

    public function __construct(
        private readonly CollectionFactory $categoryCollectionFactory
    ) {
    }

    /**
     * Return category with minimal information, required for URL generation
     *
     * @param int $categoryId
     * @return Category|null
     */
    public function getCategory(int $categoryId): ?CategoryInterface
    {
        if (!array_key_exists($categoryId, $this->storage)) {
            $this->loadCategories([$categoryId]);
        }

        return $this->storage[$categoryId];
    }

    public function loadCategories(array $categoryIds): void
    {
        $categoryIds = array_diff($categoryIds, array_keys($this->storage));
        if (empty($categoryIds)) {
            return;
        }
        /** @var Collection $collection */
        $collection = $this->categoryCollectionFactory->create();
        $collection->addIdFilter($categoryIds);

        /** @var Category $category */
        foreach ($collection->getItems() as $category) {
            $this->storage[$category->getId()] = $category;
        }

        foreach ($categoryIds as $categoryId) {
            if (!array_key_exists($categoryId, $this->storage)) {
                $this->storage[$categoryId] = null;
            }
        }
    }

    public function _resetState(): void
    {
        $this->storage = [];
    }
}
