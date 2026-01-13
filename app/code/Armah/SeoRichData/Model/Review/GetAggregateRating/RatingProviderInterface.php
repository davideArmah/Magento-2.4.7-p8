<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Rich Snippets for Magento 2
 */

namespace Armah\SeoRichData\Model\Review\GetAggregateRating;

use Magento\Catalog\Model\Product;

interface RatingProviderInterface
{
    /**
     * @param Product $product
     * @param int $formatRating
     * @return array
     */
    public function execute(Product $product, int $formatRating): array;
}
