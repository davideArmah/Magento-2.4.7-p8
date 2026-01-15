<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Observer\CustomerAttribute;

use Armah\CheckoutCore\Cache\InvalidateCheckoutCache;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class InvalidateCache implements ObserverInterface
{
    /**
     * @var InvalidateCheckoutCache
     */
    private $invalidateCheckoutCache;

    public function __construct(InvalidateCheckoutCache $invalidateCheckoutCache)
    {
        $this->invalidateCheckoutCache = $invalidateCheckoutCache;
    }

    /**
     * Event: customer_attributes_after_save, customer_attributes_delete_after
     *
     * @param Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(Observer $observer)
    {
        $this->invalidateCheckoutCache->execute();
    }
}
