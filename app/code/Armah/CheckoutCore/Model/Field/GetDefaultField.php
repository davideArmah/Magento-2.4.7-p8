<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field;

use Armah\CheckoutCore\Model\Field;
use Armah\CheckoutCore\Model\ResourceModel\Field\Collection\FilterByAttributeAndStore;
use Armah\CheckoutCore\Model\ResourceModel\Field\CollectionFactory;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class GetDefaultField
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var FilterByAttributeAndStore
     */
    private $filterByAttributeAndStore;

    public function __construct(
        CollectionFactory $collectionFactory,
        FilterByAttributeAndStore $filterByAttributeAndStore
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->filterByAttributeAndStore = $filterByAttributeAndStore;
    }

    public function execute(int $attributeId): ?Field
    {
        $collection = $this->collectionFactory->create();
        $this->filterByAttributeAndStore->execute(
            $collection,
            $attributeId,
            [Field::DEFAULT_STORE_ID]
        );

        return $collection->getSize() > 0 ? $collection->getFirstItem() : null;
    }
}
