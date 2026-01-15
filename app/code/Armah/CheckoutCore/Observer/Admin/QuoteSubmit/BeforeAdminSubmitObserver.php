<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Observer\Admin\QuoteSubmit;

use Armah\CheckoutCore\Api\Data\CustomFieldsConfigInterface;
use Armah\CheckoutCore\Api\Data\OrderCustomFieldsInterface;
use Armah\CheckoutCore\Model\QuoteCustomFieldsFactory;
use Armah\CheckoutCore\Model\ResourceModel\QuoteCustomFields as QuoteCustomFieldsResource;
use Armah\CheckoutCore\Model\ResourceModel\QuoteCustomFields\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class BeforeAdminSubmitObserver implements ObserverInterface
{
    /**
     * @var QuoteCustomFieldsResource
     */
    private $quoteCustomFieldsResource;

    /**
     * @var QuoteCustomFieldsFactory
     */
    private $quoteCustomFieldsFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        QuoteCustomFieldsResource $quoteCustomFieldsResource,
        QuoteCustomFieldsFactory $quoteCustomFieldsFactory,
        CollectionFactory $collectionFactory,
        RequestInterface $request
    ) {
        $this->quoteCustomFieldsResource = $quoteCustomFieldsResource;
        $this->quoteCustomFieldsFactory = $quoteCustomFieldsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(Observer $observer)
    {
        $countOfCustomFields = CustomFieldsConfigInterface::COUNT_OF_CUSTOM_FIELDS;
        $index = CustomFieldsConfigInterface::CUSTOM_FIELD_INDEX;

        for ($index; $index <= $countOfCustomFields; $index++) {
            $customFieldIndex = 'custom_field_' . $index;
            $customAttributes = $this->request->getParam('order');

            if (!$data = $this->getCustomFieldData($customAttributes, $customFieldIndex)) {
                continue;
            }

            /** @var \Magento\Quote\Model\Quote $quote */
            $quote = $observer->getEvent()->getQuote();
            /** @var \Armah\CheckoutCore\Model\ResourceModel\QuoteCustomFields\Collection $customFieldsCollection */
            $customFieldsCollection = $this->collectionFactory->create();
            /** @var \Armah\CheckoutCore\Model\QuoteCustomFields $quoteCustomField */
            $quoteCustomField = $this->quoteCustomFieldsFactory->create();
            $customFieldsCollection->addFilterByQuoteIdAndCustomField($quote->getId(), $customFieldIndex);

            if ($customFieldsCollection->getSize()) {
                $quoteCustomField = $customFieldsCollection->getFirstItem();
            }

            $data['name'] = $customFieldIndex;
            $data['quote_id'] = $quote->getId();
            $quoteCustomField->addData($data);
            $this->quoteCustomFieldsResource->save($quoteCustomField);
        }
    }

    /**
     * @param array $customAttributes
     * @param string $customFieldIndex
     *
     * @return array
     */
    private function getCustomFieldData($customAttributes, $customFieldIndex)
    {
        $data = [];

        if (empty($customAttributes) || !is_array($customAttributes)) {
            return $data;
        }

        foreach ($customAttributes as $key => $value) {
            if (is_array($value) && array_key_exists($customFieldIndex, $value)) {
                switch ($key) {
                    case 'billing_address':
                        $data[OrderCustomFieldsInterface::BILLING_VALUE] = $value[$customFieldIndex];
                    // no break;
                    case 'shipping_address':
                        $data[OrderCustomFieldsInterface::SHIPPING_VALUE] = $value[$customFieldIndex];
                        break;
                }
            }
        }

        return $data;
    }
}
