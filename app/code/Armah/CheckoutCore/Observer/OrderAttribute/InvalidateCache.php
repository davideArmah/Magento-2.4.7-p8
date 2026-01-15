<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Observer\OrderAttribute;

use Armah\CheckoutCore\Cache\InvalidateCheckoutCache;
use Armah\Orderattr\Model\Attribute\Attribute;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class InvalidateCache implements ObserverInterface
{
    public const FLAG_NO_INVALIDATE = 'no_invalidate';

    /**
     * @var InvalidateCheckoutCache
     */
    private $invalidateCheckoutCache;

    public function __construct(InvalidateCheckoutCache $invalidateCheckoutCache)
    {
        $this->invalidateCheckoutCache = $invalidateCheckoutCache;
    }

    /**
     * Event: armah_orderattr_entity_attribute_save_after, armah_orderattr_entity_attribute_delete_after
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var Attribute $attribute */
        $attribute = $observer->getEvent()->getData('attribute');

        if (!$attribute->hasData(self::FLAG_NO_INVALIDATE)) {
            $this->invalidateCheckoutCache->execute();
        }
    }
}
