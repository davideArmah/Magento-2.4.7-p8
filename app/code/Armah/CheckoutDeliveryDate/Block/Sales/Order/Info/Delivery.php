<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Delivery Date for Magento 2 (System)
 */

namespace Armah\CheckoutDeliveryDate\Block\Sales\Order\Info;

use Armah\CheckoutDeliveryDate\Model\DeliveryDateProvider;
use Magento\Checkout\Model\Session;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\PurchaseOrder\Api\PurchaseOrderRepositoryInterface;

class Delivery extends Template
{
    /**
     * @var DeliveryDateProvider
     */
    protected $deliveryProvider;

    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var PurchaseOrderRepositoryInterface|null
     */
    private $purchaseOrderRepository;

    public function __construct(
        Context $context,
        DeliveryDateProvider $deliveryProvider,
        Session $checkoutSession,
        TimezoneInterface $timezone,
        ObjectManagerInterface $objectManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->deliveryProvider = $deliveryProvider;
        $this->checkoutSession = $checkoutSession;
        $this->timezone = $timezone;
        $this->objectManager = $objectManager;
        $this->setPurchaseOrderRepository();
    }

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('sales/order/info/delivery.phtml');
    }

    private function setPurchaseOrderRepository(): void
    {
        if (interface_exists(PurchaseOrderRepositoryInterface::class)) {
            $this->purchaseOrderRepository = $this->objectManager->get(PurchaseOrderRepositoryInterface::class);
        }
    }

    /**
     * @return bool|int
     */
    private function getCurrentOrderId()
    {
        if ($orderId = $this->getOrderId()) {
            return (int)$orderId;
        }

        if ($orderId = $this->getRequest()->getParam('order_id')) {
            return (int)$orderId;
        }

        if ($lastRealOrder = $this->checkoutSession->getLastRealOrder()) {
            if ($orderId = $lastRealOrder->getId()) {
                return (int)$orderId;
            }
        }

        return false;
    }

    /**
     * @return bool|int
     */
    private function getCurrentQuoteId(?int $requestId = null)
    {
        if ($quoteId = $this->getQuoteId()) {
            return (int)$quoteId;
        }

        if ($requestId && $this->purchaseOrderRepository !== null) {
            return (int)$this->purchaseOrderRepository->getById($requestId)->getQuoteId();
        }

        if ($quoteId = $this->checkoutSession->getQuoteId()) {
            return (int)$quoteId;
        }

        return false;
    }

    /**
     * @return array|bool
     */
    public function getDeliveryDateFields()
    {
        if ($orderId = $this->getCurrentOrderId()) {
            $delivery = $this->deliveryProvider->findByOrderId($orderId);
        } elseif ($requestId = (int)$this->getRequest()->getParam('request_id')) {
            $quoteId = $this->getCurrentQuoteId($requestId);
            if ($quoteId) {
                $delivery = $this->deliveryProvider->findByQuoteId($quoteId);
            }
        } elseif ($quoteId = $this->getCurrentQuoteId()) {
            $delivery = $this->deliveryProvider->findByQuoteId($quoteId);
        } else {
            return false;
        }

        if (!$delivery->getId()) {
            return false;
        }

        return $this->getDeliveryFields($delivery);
    }

    /**
     * @param \Armah\CheckoutDeliveryDate\Model\Delivery $delivery
     *
     * @return array
     */
    public function getDeliveryFields($delivery)
    {
        $date = $delivery->getDate();
        $time = $delivery->getTime();

        $fields = [];
        if (!empty($date)) {
            $fields[] = [
                'label' => __('Delivery Date'),
                'value' => $this->timezone->formatDateTime(
                    $date,
                    \IntlDateFormatter::FULL,
                    \IntlDateFormatter::NONE,
                    null,
                    false
                )
            ];
        }

        if ($time !== null && $time >= 0) {
            $fields[] = [
                'label' => __('Delivery Time'),
                'value' => $time . ':00 - ' . (($time) + 1) . ':00',
            ];
        }

        if ($delivery->getComment()) {
            $fields[] = [
                'label' => __('Delivery Comment'),
                'value' => $delivery->getComment(),
            ];
        }

        return $fields;
    }
}
