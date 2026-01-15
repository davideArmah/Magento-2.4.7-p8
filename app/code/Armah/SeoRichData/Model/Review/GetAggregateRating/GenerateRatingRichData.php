<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Rich Snippets for Magento 2
 */

namespace Armah\SeoRichData\Model\Review\GetAggregateRating;

use Armah\SeoRichData\Model\Review\FormatRating;
use Armah\SeoRichData\Model\Review\GetBestRating;

class GenerateRatingRichData
{
    /**
     * @var FormatRating
     */
    private $formatRating;

    /**
     * @var GetBestRating
     */
    private $getBestRating;

    public function __construct(FormatRating $formatRating, GetBestRating $getBestRating)
    {
        $this->formatRating = $formatRating;
        $this->getBestRating = $getBestRating;
    }

    /**
     * @param int $reviewCount
     * @param float $ratingValue
     * @param float $fromBestRating
     * @param int $formatRating
     * @return array
     */
    public function execute(int $reviewCount, float $ratingValue, float $fromBestRating, int $formatRating): array
    {
        $bestRating = $this->getBestRating->execute($formatRating);
        $ratingValue = $this->formatRating->execute($ratingValue, $fromBestRating, $bestRating);

        return [
            '@type' => 'AggregateRating',
            'ratingValue' => $ratingValue,
            'bestRating' => $bestRating,
            'reviewCount' => $reviewCount
        ];
    }
}
