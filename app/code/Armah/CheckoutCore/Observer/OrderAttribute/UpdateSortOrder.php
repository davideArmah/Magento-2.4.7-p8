<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Observer\OrderAttribute;

use Armah\CheckoutCore\Model\OrderAttribute\UpdateSortOrder as SortOrderModel;
use Armah\Orderattr\Model\Attribute\Attribute;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;

class UpdateSortOrder implements ObserverInterface
{
    /**
     * @var SortOrderModel
     */
    private $sortOrderModel;

    public function __construct(SortOrderModel $sortOrderModel)
    {
        $this->sortOrderModel = $sortOrderModel;
    }

    /**
     * Event: armah_orderattr_entity_attribute_save_before
     *
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {
        /** @var Attribute $attribute */
        $attribute = $observer->getEvent()->getData('attribute');

        $this->sortOrderModel->execute($attribute);
    }
}
