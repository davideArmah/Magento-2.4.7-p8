<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Observer\Sales\Order\Payment;

use Armah\CashOnDelivery\Model\ConfigProvider;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\OfflinePayments\Model\Cashondelivery;
use Magento\Sales\Model\Order;

class Place implements ObserverInterface
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    /**
     * @inheritdoc
     */
    public function execute(Observer $observer)
    {
        /** @var Order $order */
        $order = $observer->getPayment()->getOrder();

        if ($order->getPayment()->getMethod() === Cashondelivery::PAYMENT_METHOD_CASHONDELIVERY_CODE
            && $status = $this->configProvider->getOrderStatus()
        ) {
            if ($status === Order::STATE_PROCESSING) {
                $order->setState(Order::STATE_PROCESSING);
            }
            
            $order->setStatus($status);

            foreach ($order->getStatusHistories() as $item) {
                $item->setStatus($status);
            }
        }
    }
}
