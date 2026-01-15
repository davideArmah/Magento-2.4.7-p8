<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model\Order\Creditmemo\Total;

use Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal;
use Magento\Sales\Model\Order\Creditmemo;
use Armah\CashOnDelivery\Api\PaymentFeeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

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
     * @param Creditmemo $creditmemo
     *
     * @return $this
     */
    public function collect(Creditmemo $creditmemo)
    {
        try {
            $feeTax = 0;
            $feeBaseTax = 0;

            /** @var \Magento\Sales\Model\Order $order */
            $order = $creditmemo->getOrder();

            /** @var \Armah\CashOnDelivery\Model\PaymentFee $paymentFee */
            $paymentFee = $this->paymentFeeRepository->getByQuoteId($order->getQuoteId());

            if ($order->getTaxAmount() != $creditmemo->getTaxAmount()
                || $order->getBaseTaxAmount() != $creditmemo->getBaseTaxAmount()
            ) {
                $feeTax = $paymentFee->getTaxAmount();
                $feeBaseTax = $paymentFee->getBaseTaxAmount();

                $creditmemo->setTaxAmount($creditmemo->getTaxAmount() + $feeTax);
                $creditmemo->setBaseTaxAmount($creditmemo->getBaseTaxAmount() + $feeBaseTax);
            }

            $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $paymentFee->getAmount() + $feeTax);
            $creditmemo
                ->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $paymentFee->getBaseAmount() + $feeBaseTax);
        } catch (NoSuchEntityException $exception) {
            return $this;
        }

        return $this;
    }
}
