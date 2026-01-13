<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Observer\Catalog\Product;

use Armah\Meta\Model\UrlKey\Generate\ProcessProductsAfterCreation;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AfterSave implements ObserverInterface
{
    /**
     * @var ProcessProductsAfterCreation
     */
    private $processProductsAfterCreation;

    public function __construct(
        ProcessProductsAfterCreation $processProductsAfterCreation
    ) {
        $this->processProductsAfterCreation = $processProductsAfterCreation;
    }

    /**
     * event name: catalog_product_save_after
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $this->processProductsAfterCreation->execute();
    }
}
