<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface EntityDataSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Armah\Orderattr\Api\Data\EntityDataInterface[]
     */
    public function getItems();

    /**
     * @param \Armah\Orderattr\Api\Data\EntityDataInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
