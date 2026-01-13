<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model;

use Magento\Checkout\Model\Session;
use Magento\Quote\Model\Quote;

class QuoteProducts
{
    /**
     * @var Session
     */
    private $checkoutSession;

    public function __construct(
        Session $checkoutSession
    ) {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @return string[]
     */
    public function getProductIds(?Quote $quote = null): array
    {
        $productIds = [];
        if (!$quote) {
            $quote = $this->checkoutSession->getQuote();
        }
        foreach ($quote->getAllItems() as $item) {
            if ($item->getProduct()) {
                $productIds[] = $item->getProduct()->getId();
            }
        }

        return $productIds;
    }
}
