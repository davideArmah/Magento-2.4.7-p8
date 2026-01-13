<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Rich Snippets for Magento 2
 */

namespace Armah\SeoRichData\Model\Review;

use Armah\SeoRichData\Model\Source\Product\RatingFormat;

class GetBestRating
{
    /**
     * @param int $ratingFormat
     * @return int
     */
    public function execute(int $ratingFormat): int
    {
        return $ratingFormat === RatingFormat::PERCENT ? 100 : 5;
    }
}
