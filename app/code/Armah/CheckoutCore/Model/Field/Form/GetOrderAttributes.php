<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field\Form;

use Armah\CheckoutCore\Model\Field;
use Armah\Orderattr\Model\ResourceModel\Attribute\Collection;
use Armah\Orderattr\Model\ResourceModel\Attribute\CollectionFactory;
use Magento\Eav\Model\Attribute;
use Magento\Framework\ObjectManagerInterface;

class GetOrderAttributes
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param int $storeId
     * @return Attribute[]
     */
    public function execute(int $storeId): array
    {
        $collectionFactory = $this->objectManager->get(CollectionFactory::class);

        /** @var Collection $collection */
        $collection = $collectionFactory->create();

        if ($storeId !== Field::DEFAULT_STORE_ID) {
            $collection->addStoreFilter($storeId);
        }

        return $collection->getItems();
    }
}
