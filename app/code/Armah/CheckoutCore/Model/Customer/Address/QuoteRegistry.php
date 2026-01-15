<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Customer\Address;

use Magento\Quote\Api\Data\CartInterface;

class QuoteRegistry
{
    /**
     * @var CartInterface|null
     */
    private ?CartInterface $quote = null;

    public function setQuote(?CartInterface $quote)
    {
        $this->quote = $quote;
    }

    public function getQuote(): ?CartInterface
    {
        return $this->quote;
    }
}
