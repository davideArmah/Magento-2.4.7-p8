<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Elasticsearch\Adapter\DataMapper;

use Armah\Sorting\Model\Elasticsearch\Adapter\IndexedDataMapper;
use Armah\Sorting\Model\Method\IsMethodEnabled;
use Armah\Sorting\Model\ResourceModel\Method\Saving as SavingResource;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Saving extends IndexedDataMapper
{
    public const FIELD_NAME = 'saving';

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory,
        SavingResource $resourceMethod,
        IsMethodEnabled $isMethodEnabled
    ) {
        parent::__construct($resourceMethod, $isMethodEnabled);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Saving is not indexed method.
     * @return bool
     */
    public function getIndexerCode()
    {
        return false;
    }

    protected function forceLoad(int $storeId, ?array $entityIds = []): array
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->setStoreId($storeId);
        $collection->addPriceData();
        if (!empty($entityIds)) {
            $collection->addIdFilter($entityIds);
        }
        $this->resourceMethod->setLimitColumns(true);
        $this->resourceMethod->apply($collection, '');
        $this->resourceMethod->setLimitColumns(false);

        return $this->resourceMethod->getConnection()->fetchPairs($collection->getSelect());
    }
}
