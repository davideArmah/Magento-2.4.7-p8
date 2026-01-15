<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Indexer\Conditions;

use Magento\Framework\Indexer\AbstractProcessor;

class ProductProcessor extends AbstractProcessor
{
    public const INDEXER_ID = 'armah_product_order_attribute';
}
