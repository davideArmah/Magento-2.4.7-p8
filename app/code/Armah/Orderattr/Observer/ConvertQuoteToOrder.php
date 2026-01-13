<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * event sales_model_service_quote_submit_before   sales_convert_quote_to_order
 * name ConvertQuoteAttributesToOrderAttributes
 */
class ConvertQuoteToOrder implements ObserverInterface
{
    /**
     * @var \Magento\Sales\Api\Data\OrderExtensionFactory
     */
    private $orderExtensionFactory;

    public function __construct(\Magento\Sales\Api\Data\OrderExtensionFactory $orderExtensionFactory)
    {
        $this->orderExtensionFactory = $orderExtensionFactory;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /**
         * @var \Magento\Quote\Model\Quote $quote
         * @var \Magento\Sales\Model\Order $order
         */
        $quote = $observer->getEvent()->getQuote();
        $order = $observer->getEvent()->getOrder();

        $quoteAttributes = $quote->getExtensionAttributes();
        if ($quoteAttributes && $quoteAttributes->getArmahOrderAttributes()) {
            $customAttributes = $quoteAttributes->getArmahOrderAttributes();
            $orderAttributes = $order->getExtensionAttributes();
            if (empty($orderAttributes)) {
                $orderAttributes = $this->orderExtensionFactory->create();
            }
            $orderAttributes->setArmahOrderAttributes($customAttributes);
            $order->setExtensionAttributes($orderAttributes);
            $quoteAttributes->setArmahOrderAttributes([]);
            $quote->setExtensionAttributes($quoteAttributes);
        }
    }
}
