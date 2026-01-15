<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Api;

/**
 * Interface IndexMethodWrapper
 * @api
 */
interface IndexMethodWrapperInterface
{
    /**
     * @return \Armah\Sorting\Api\IndexedMethodInterface
     */
    public function getSource();

    /**
     * @return \Magento\Framework\Indexer\ActionInterface
     */
    public function getIndexer();
}
