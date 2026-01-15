<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Api;

/**
 * @api
 */
interface ProductReviewLinkProcessorInterface
{
    /**
     * @param int $productId
     * @param int $reviewId
     */
    public function create(int $productId, int $reviewId): void;

    /**
     * @param int $productId
     * @param int $reviewId
     */
    public function remove(int $productId, int $reviewId): void;
}
