<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Rich Snippets for Magento 2
 */

namespace Armah\SeoRichData\Model\Review;

class FormatRating
{
    /**
     * @param float $ratingValue
     * @param float $fromBestRating
     * @param int $toBestRating
     * @return float
     */
    public function execute(float $ratingValue, float $fromBestRating, int $toBestRating): float
    {
        return round($ratingValue * $toBestRating / $fromBestRating, 1);
    }
}
