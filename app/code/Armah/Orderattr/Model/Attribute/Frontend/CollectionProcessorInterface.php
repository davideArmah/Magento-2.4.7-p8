<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Attribute\Frontend;

use Armah\Orderattr\Model\ResourceModel\Attribute\Collection;

interface CollectionProcessorInterface
{
    public function process(Collection $collection): void;
}
