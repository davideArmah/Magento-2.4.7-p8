<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Quote;

use Armah\CheckoutCore\Api\Data\CustomFieldsConfigInterface;
use Armah\CheckoutCore\Api\Data\QuoteCustomFieldsInterface;
use Armah\CheckoutCore\Model\QuoteCustomFields;
use Armah\CheckoutCore\Model\QuoteCustomFieldsFactory;
use Armah\CheckoutCore\Model\ResourceModel\QuoteCustomFields as QuoteCustomFieldsResource;
use Armah\CheckoutCore\Model\ResourceModel\QuoteCustomFields\Collection;
use Armah\CheckoutCore\Model\ResourceModel\QuoteCustomFields\CollectionFactory;

class CustomFieldItemsProvider
{
    /**
     * @var QuoteCustomFields[]
     */
    private $itemsStorage = [];

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var QuoteCustomFieldsFactory
     */
    private $customFieldsFactory;

    /**
     * @var QuoteCustomFieldsResource
     */
    private $customFieldsResource;

    public function __construct(
        CollectionFactory $collectionFactory,
        QuoteCustomFieldsFactory $customFieldsFactory,
        QuoteCustomFieldsResource $customFieldsResource
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->customFieldsFactory = $customFieldsFactory;
        $this->customFieldsResource = $customFieldsResource;
    }

    /**
     * @param int $quoteId
     *
     * @return QuoteCustomFields[]|QuoteCustomFieldsInterface[]
     */
    public function getItemsByQuoteId(int $quoteId): array
    {
        if (!isset($this->itemsStorage[$quoteId])) {
            $this->itemsStorage[$quoteId] = [];
            /** @var Collection $customFieldsCollection */
            $customFieldsCollection = $this->collectionFactory->create();
            $customFieldsCollection->addFieldByQuoteId($quoteId);

            foreach (CustomFieldsConfigInterface::CUSTOM_FIELDS_ARRAY as $fieldName) {
                /** @var QuoteCustomFields $item */
                $item = $customFieldsCollection->getItemByColumnValue('name', $fieldName);
                if (!$item) {

                    $item = $this->customFieldsFactory->create(
                        ['data' => ['quote_id' => $quoteId, 'name' => $fieldName]]
                    );
                }
                $item->setDataChanges(false);

                $this->itemsStorage[$quoteId][] = $item;
            }
        }

        return $this->itemsStorage[$quoteId];
    }
}
