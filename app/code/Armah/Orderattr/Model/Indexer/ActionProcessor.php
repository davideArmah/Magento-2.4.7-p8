<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Indexer;

use Magento\Framework\Indexer\AbstractProcessor;
use Armah\Orderattr\Model\ResourceModel\Entity\Entity;

class ActionProcessor extends AbstractProcessor
{
    public const INDEXER_ID = Entity::GRID_INDEXER_ID;
}
