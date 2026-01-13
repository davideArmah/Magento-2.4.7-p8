<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) 2023 Amasty (https://www.armah.it)
 * @package One Step Checkout Gift Wrap for Magento 2 (System)
 */

namespace Armah\CheckoutGiftWrap\Model\Order\Invoice\Total;

use Armah\CheckoutCore\Model\ResourceModel\Fee\CollectionFactory as FeeCollectionFactory;
use Magento\Sales\Model\Order\Invoice;
use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal;

class Additional extends AbstractTotal
{
    /**
     * @var FeeCollectionFactory
     */
    protected $feeCollectionFactory;

    public function __construct(
        FeeCollectionFactory $feeCollectionFactory,
        array $data = []
    ) {
        parent::__construct($data);
        $this->feeCollectionFactory = $feeCollectionFactory;
    }

    /**
     * @param Invoice $invoice
     *
     * @return $this
     */
    public function collect(Invoice $invoice)
    {
        $order = $invoice->getOrder();

        $feesQuoteCollection = $this->feeCollectionFactory->create()
            ->addFieldToFilter('quote_id', $order->getQuoteId());

        $feeAmount = 0;
        $baseFeeAmount = 0;

        /** @var \Armah\CheckoutCore\Model\Fee $fee */
        foreach ($feesQuoteCollection as $fee) {
            $feeAmount += $fee->getData('amount');
            $baseFeeAmount += $fee->getData('base_amount');
        }

        $invoice->setGrandTotal($invoice->getGrandTotal() + $feeAmount);
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $baseFeeAmount);

        return $this;
    }
}
