<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Attribute\Frontend;

use Armah\Orderattr\Model\QuoteProducts;
use Armah\Orderattr\Model\ResourceModel\Attribute\Collection;
use Magento\Store\Model\StoreManagerInterface;

class CollectionConditionsProcessor implements CollectionProcessorInterface
{
    /**
     * @var QuoteProducts
     */
    private $quoteProducts;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(QuoteProducts $quoteProducts, StoreManagerInterface $storeManager)
    {
        $this->quoteProducts = $quoteProducts;
        $this->storeManager = $storeManager;
    }

    public function process(Collection $collection): void
    {
        $collection->addConditionsFilter($this->quoteProducts->getProductIds());
        $collection->addStoreFilter($this->storeManager->getStore()->getId());
    }
}
