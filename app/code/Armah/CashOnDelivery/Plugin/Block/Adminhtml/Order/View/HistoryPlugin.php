<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Plugin\Block\Adminhtml\Order\View;

use Magento\OfflinePayments\Model\Cashondelivery;
use Magento\Sales\Block\Adminhtml\Order\View\History;

class HistoryPlugin
{
    /**
     * @param History $object
     * @param array $result
     *
     * @return array
     */
    public function afterGetStatuses(History $object, $result)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $object->getOrder();
        $paymentMethod = $order->getPayment()->getMethod();

        if ($paymentMethod === Cashondelivery::PAYMENT_METHOD_CASHONDELIVERY_CODE && is_array($result)) {
            $result['pending'] = 'Pending';
            $result['processing'] = 'Processing';
        }

        return $result;
    }
}
