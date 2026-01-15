<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Observer\Catalog\Product;

use Armah\Meta\Model\UrlKey\Generate\ProductsToUpdate;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class BeforeSave implements ObserverInterface
{
    /**
     * @var ProductsToUpdate
     */
    private $productsToUpdate;

    public function __construct(
        ProductsToUpdate $productsToUpdate
    ) {
        $this->productsToUpdate = $productsToUpdate;
    }

    /**
     * event name: catalog_product_save_before
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $product = $observer->getProduct();
        
        if (!$product->getId()) {
            $this->productsToUpdate->addProductToUpdate($product);
        }
    }
}
