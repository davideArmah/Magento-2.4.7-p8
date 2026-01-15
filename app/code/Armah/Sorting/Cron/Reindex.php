<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Cron;

use Armah\Sorting\Model\Elasticsearch\IsElasticSort;
use Armah\Sorting\Model\Indexer\Summary;
use Magento\CatalogSearch\Model\Indexer\Fulltext\Processor as FulltextProcessor;

class Reindex
{
    /**
     * @var Summary
     */
    private $summary;

    /**
     * @var IsElasticSort
     */
    private $isElasticSort;

    /**
     * @var FulltextProcessor
     */
    private $fulltextProcessor;

    public function __construct(Summary $summary, IsElasticSort $isElasticSort, FulltextProcessor $fulltextProcessor)
    {
        $this->summary = $summary;
        $this->isElasticSort = $isElasticSort;
        $this->fulltextProcessor = $fulltextProcessor;
    }

    /**
     * Reindex all sorting indexable methods;
     * trigger elasticsearch reindex if needed.
     *
     * @return void
     */
    public function execute(): void
    {
        $this->summary->reindexAll();
        if ($this->isElasticSort->execute(true)) {
            $this->fulltextProcessor->reindexAll();
        }
    }
}
