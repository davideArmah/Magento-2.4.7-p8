<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Attribute\Frontend;

use Armah\Orderattr\Api\Data\CheckoutAttributeInterface;
use Armah\Orderattr\Model\ResourceModel\Attribute\Collection;

class CollectionProcessor implements CollectionProcessorInterface
{
    public function process(Collection $collection): void
    {
        $collection->setOrder(CheckoutAttributeInterface::SORTING_ORDER, 'ASC');
        $collection->addFieldToFilter(CheckoutAttributeInterface::IS_VISIBLE_ON_FRONT, 1);
    }
}
