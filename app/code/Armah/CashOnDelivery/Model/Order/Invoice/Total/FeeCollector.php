<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model\Order\Invoice\Total;

use Armah\CashOnDelivery\Api\PaymentFeeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Model\Order\Invoice;
use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal;

class FeeCollector extends AbstractTotal
{
    /**
     * @var PaymentFeeRepositoryInterface
     */
    private $paymentFeeRepository;

    public function __construct(
        PaymentFeeRepositoryInterface $paymentFeeRepository,
        array $data = []
    ) {
        parent::__construct($data);
        $this->paymentFeeRepository = $paymentFeeRepository;
    }

    /**
     * @param Invoice $invoice
     *
     * @return $this
     */
    public function collect(Invoice $invoice)
    {
        try {
            $feeTax = 0;
            $feeBaseTax = 0;

            /** @var \Magento\Sales\Model\Order $order */
            $order = $invoice->getOrder();

            /** @var \Armah\CashOnDelivery\Model\PaymentFee $paymentFee */
            $paymentFee = $this->paymentFeeRepository->getByQuoteId($order->getQuoteId());

            if ($order->getTaxAmount() != $invoice->getTaxAmount()
                || $order->getBaseTaxAmount() != $invoice->getBaseTaxAmount()
            ) {
                $feeTax = $paymentFee->getTaxAmount();
                $feeBaseTax = $paymentFee->getBaseTaxAmount();

                $invoice->setTaxAmount($invoice->getTaxAmount() + $feeTax);
                $invoice->setBaseTaxAmount($invoice->getBaseTaxAmount() + $feeBaseTax);
            }

            $invoice->setGrandTotal($invoice->getGrandTotal() + $paymentFee->getAmount() + $feeTax);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $paymentFee->getBaseAmount() + $feeBaseTax);
        } catch (NoSuchEntityException $exception) {
            return $this;
        }

        return $this;
    }
}
