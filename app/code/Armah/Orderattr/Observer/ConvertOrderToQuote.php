<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * event sales_convert_order_to_quote
 * name ConvertOrderAttributesToQuoteAttributes
 */
class ConvertOrderToQuote implements ObserverInterface
{
    /**
     * @var \Magento\Quote\Api\Data\CartExtensionFactory
     */
    private $cartExtensionFactory;

    /**
     * @var \Armah\Orderattr\Model\Entity\Adapter\Order\Adapter
     */
    private $orderAdapter;

    public function __construct(
        \Magento\Quote\Api\Data\CartExtensionFactory $cartExtensionFactory,
        \Armah\Orderattr\Model\Entity\Adapter\Order\Adapter $orderAdapter
    ) {
        $this->cartExtensionFactory = $cartExtensionFactory;
        $this->orderAdapter = $orderAdapter;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
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

        $orderExtensionAttributes = $order->getExtensionAttributes();
        if (!$orderExtensionAttributes || !$orderExtensionAttributes->getArmahOrderAttributes()) {
            $this->orderAdapter->addExtensionAttributesToOrder($order);
            $orderExtensionAttributes = $order->getExtensionAttributes();
        }
        if ($orderExtensionAttributes->getArmahOrderAttributes()) {
            $customAttributes = $orderExtensionAttributes->getArmahOrderAttributes();
            $quoteExtensionAttributes = $quote->getExtensionAttributes();
            if (empty($quoteExtensionAttributes)) {
                $quoteExtensionAttributes = $this->cartExtensionFactory->create();
            }
            $quoteExtensionAttributes->setArmahOrderAttributes($customAttributes);
            $quote->setExtensionAttributes($quoteExtensionAttributes);
        }
    }
}
