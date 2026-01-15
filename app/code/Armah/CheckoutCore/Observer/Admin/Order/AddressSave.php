<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Observer\Admin\Order;

use Armah\CheckoutCore\Api\Data\OrderCustomFieldsInterface;
use Armah\CheckoutCore\Model\OrderCustomFieldsFactory;
use Armah\CheckoutCore\Model\ResourceModel\OrderCustomFields;
use Armah\CheckoutCore\Model\ResourceModel\OrderCustomFields\Collection;
use Armah\CheckoutCore\Model\ResourceModel\OrderCustomFields\CollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\OrderAddressRepositoryInterface;

class AddressSave implements ObserverInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var CollectionFactory
     */
    private $orderCustomFieldsCollection;

    /**
     * @var OrderCustomFields
     */
    private $orderCustomFieldsResource;

    /**
     * @var OrderAddressRepositoryInterface
     */
    private $orderAddressRepository;

    /**
     * @var OrderCustomFieldsFactory
     */
    private $orderCustomFieldsFactory;

    public function __construct(
        RequestInterface $request,
        CollectionFactory $orderCustomFieldsCollection,
        OrderCustomFields $orderCustomFieldsResource,
        OrderAddressRepositoryInterface $orderAddressRepository,
        ?OrderCustomFieldsFactory $orderCustomFieldsFactory = null // TODO move to not optional
    ) {
        $this->request = $request;
        $this->orderCustomFieldsCollection = $orderCustomFieldsCollection;
        $this->orderCustomFieldsResource = $orderCustomFieldsResource;
        $this->orderAddressRepository = $orderAddressRepository;
        $this->orderCustomFieldsFactory = $orderCustomFieldsFactory
            ?: ObjectManager::getInstance()->get(OrderCustomFieldsFactory::class);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(Observer $observer)
    {
        $addressData = $this->request->getParams();
        $data = [];

        foreach (\Armah\CheckoutCore\Api\Data\CustomFieldsConfigInterface::CUSTOM_FIELDS_ARRAY as $customFieldIndex) {
            if (isset($addressData[$customFieldIndex])) {
                /** @var Collection $orderCustomFieldsCollection */
                $orderCustomFieldsCollection = $this->orderCustomFieldsCollection->create();
                $orderCustomFieldsCollection->addFieldByOrderIdAndCustomField(
                    $observer->getOrderId(),
                    $customFieldIndex
                );

                if ($orderCustomFieldsCollection->getSize() === 0) {
                    $orderCustomField = $this->orderCustomFieldsFactory->create(
                        ['data' => ['name' => $customFieldIndex, 'order_id' => $observer->getOrderId()]]
                    );
                } else {
                    $orderCustomField = $orderCustomFieldsCollection->getFirstItem();
                }

                $orderAddress = $this->orderAddressRepository->get($addressData['address_id']);

                if ($orderAddress->getAddressType() === 'billing') {
                    $data[OrderCustomFieldsInterface::BILLING_VALUE] = $addressData[$customFieldIndex];
                } elseif ($orderAddress->getAddressType() === 'shipping') {
                    $data[OrderCustomFieldsInterface::SHIPPING_VALUE] = $addressData[$customFieldIndex];
                }

                $orderCustomField->addData($data);
                $this->orderCustomFieldsResource->save($orderCustomField);
            }
        }
    }
}
