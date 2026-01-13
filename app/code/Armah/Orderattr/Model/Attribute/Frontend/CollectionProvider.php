<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Attribute\Frontend;

use Armah\Orderattr\Api\Data\CheckoutAttributeInterface;
use Armah\Orderattr\Model\Config\Source\CheckoutStep;
use Armah\Orderattr\Model\ResourceModel\Attribute\Collection;
use Armah\Orderattr\Model\ResourceModel\Attribute\Relation\RelationDetails\Collection as RelationDetailsCollection;
use Armah\Orderattr\Model\QuoteProducts;
use Armah\Orderattr\Model\ResourceModel\Attribute\CollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Quote\Model\Quote;
use Magento\Store\Model\StoreManagerInterface;

class CollectionProvider
{
    /**
     * @var array
     */
    private $shippingAttributes = [];

    /**
     * @var array
     */
    private $paymentAttributes = [];

    /**
     * @var Collection
     */
    private $collection = null;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var QuoteProducts
     */
    private $quoteProducts;

    /**
     * @var RelationDetailsCollection
     */
    private $relationDetailsCollection;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessorInterface[]
     */
    private $collectionProcessors;

    /**
     * @param StoreManagerInterface $storeManager
     * @param CollectionFactory $collectionFactory
     * @param QuoteProducts|null $quoteProducts
     * @param RelationDetailsCollection|null $relationDetailsCollection
     * @param CollectionProcessorInterface[] $collectionProcessors
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        CollectionFactory $collectionFactory,
        ?QuoteProducts $quoteProducts = null, //todo remove
        ?RelationDetailsCollection $relationDetailsCollection = null, //todo: move to not optional
        array $collectionProcessors = []
    ) {
        $this->storeManager = $storeManager;
        $this->relationDetailsCollection = $relationDetailsCollection
            ?? ObjectManager::getInstance()->create(RelationDetailsCollection::class);
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessors = $collectionProcessors;
    }

    /**
     * @return CheckoutAttributeInterface[]
     */
    public function getAttributes(?Quote $quote = null)
    {
        return $this->checkParentScope($this->getCollection()->getItems());
    }

    private function getCollection(): Collection
    {
        if ($this->collection === null) {
            $this->collection = $this->collectionFactory->create();
            foreach ($this->collectionProcessors as $processor) {
                $processor->process($this->collection);
            }
        }

        return $this->collection;
    }

    /**
     * @return CheckoutAttributeInterface[]
     */
    public function getShippingAttributes()
    {
        if (!$this->shippingAttributes) {
            $this->shippingAttributes = $this->getAttributesForStep(CheckoutStep::SHIPPING_STEP);
        }

        return $this->shippingAttributes;
    }

    /**
     * @return CheckoutAttributeInterface[]
     */
    public function getPaymentAttributes()
    {
        if (!$this->paymentAttributes) {
            $this->paymentAttributes = $this->getAttributesForStep(CheckoutStep::PAYMENT_STEP);
        }

        return $this->paymentAttributes;
    }

    /**
     * @param $checkoutStep
     *
     * @return CheckoutAttributeInterface[]
     */
    public function getAttributesForStep($checkoutStep)
    {
        $result = [];

        foreach ($this->getAttributes() as $frontendAttribute) {
            if ((int)$frontendAttribute->getCheckoutStep() === $checkoutStep) {
                $result[] = $frontendAttribute;
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getAttributeCodes()
    {
        return $this->getCollection()->getColumnValues('attribute_code');
    }

    /**
     * @param CheckoutAttributeInterface[] $attributes
     * @return CheckoutAttributeInterface[]
     */
    private function checkParentScope(array $attributes): array
    {
        $items = $this->relationDetailsCollection->getItems();

        foreach ($items as $item) {
            if (in_array($item->getDependentAttributeId(), array_keys($attributes))
                && !in_array($item->getAttributeId(), array_keys($attributes))
            ) {
                unset($attributes[$item->getDependentAttributeId()]);
            }
        }

        return $attributes;
    }
}
