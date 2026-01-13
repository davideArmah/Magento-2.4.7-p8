<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model;

use Armah\Sorting\Api\IndexMethodWrapperInterface;
use Armah\Sorting\Api\IndexedMethodInterface;
use Armah\Sorting\Model\Indexer\AbstractIndexer;

/**
 * This Class used for DI VirtualType
 */
class IndexMethodWrapper implements IndexMethodWrapperInterface
{
    /**
     * @var IndexedMethodInterface
     */
    private $source;

    /**
     * @var AbstractIndexer
     */
    private $indexer;

    /**
     * IndexMethodWrapper constructor.
     *
     * @param IndexedMethodInterface $source
     * @param AbstractIndexer        $indexer
     */
    public function __construct(
        IndexedMethodInterface $source,
        AbstractIndexer $indexer
    ) {
        $this->source = $source;
        $this->indexer = $indexer;
    }

    /**
     * @return IndexedMethodInterface
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return AbstractIndexer
     */
    public function getIndexer()
    {
        return $this->indexer;
    }
}
