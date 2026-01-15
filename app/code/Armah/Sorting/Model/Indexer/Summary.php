<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Indexer;

use Armah\Sorting\Model\Indexer\Bestsellers\BestsellersProcessor;
use Armah\Sorting\Model\Indexer\MostViewed\MostViewedProcessor;
use Armah\Sorting\Model\Indexer\Revenue\RevenueProcessor;
use Armah\Sorting\Model\Indexer\Wished\WishedProcessor;
use Magento\Framework\Indexer\IndexerRegistry;
use Magento\Indexer\Model\IndexerFactory;

class Summary
{
    /**
     * @var array
     */
    private $indexerIds = [
        BestsellersProcessor::INDEXER_ID,
        RevenueProcessor::INDEXER_ID,
        MostViewedProcessor::INDEXER_ID,
        WishedProcessor::INDEXER_ID
    ];

    /**
     * @var IndexerRegistry
     */
    private $indexerRegistry;

    public function __construct(IndexerRegistry $indexerRegistry)
    {
        $this->indexerRegistry = $indexerRegistry;
    }

    /**
     * @return void
     */
    public function reindexAll(): void
    {
        foreach ($this->indexerIds as $indexerId) {
            $indexer = $this->indexerRegistry->get($indexerId);
            if ($indexer) {
                $indexer->reindexAll();
            }
        }
    }
}
