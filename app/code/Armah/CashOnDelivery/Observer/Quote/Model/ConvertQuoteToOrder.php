<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Observer\Quote\Model;

use Armah\CashOnDelivery\Api\OrderPaymentFeeRepositoryInterface;
use Armah\CashOnDelivery\Api\PaymentFeeRepositoryInterface;
use Armah\CashOnDelivery\Model\OrderPaymentFee;
use Armah\CashOnDelivery\Model\OrderPaymentFeeFactory;
use Armah\CashOnDelivery\Model\PaymentFee;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Model\Order;

class ConvertQuoteToOrder implements ObserverInterface
{
    /**
     * @var OrderPaymentFeeFactory
     */
    private $orderFeeFactory;

    /**
     * @var PaymentFeeRepositoryInterface
     */
    private $quoteFeeRepository;

    /**
     * @var OrderPaymentFeeRepositoryInterface
     */
    private $orderFeeRepository;

    public function __construct(
        OrderPaymentFeeFactory $orderFeeFactory,
        PaymentFeeRepositoryInterface $quoteFeeRepository,
        OrderPaymentFeeRepositoryInterface $orderFeeRepository
    ) {
        $this->orderFeeFactory = $orderFeeFactory;
        $this->quoteFeeRepository = $quoteFeeRepository;
        $this->orderFeeRepository = $orderFeeRepository;
    }

    /**
     * Event 'sales_model_service_quote_submit_success'
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var Order $order */
        $order = $observer->getData('order');

        try {
            /** @var PaymentFee $paymentFee */
            $quoteFee = $this->quoteFeeRepository->getByQuoteId((int)$order->getQuoteId());
        } catch (NoSuchEntityException $exception) {
            unset($exception);

            return;
        }

        /** @var OrderPaymentFee $orderFee */
        $orderFee = $this->orderFeeFactory->create();
        $orderFee->setOrderId((int)$order->getEntityId());
        $orderFee->setAmount($quoteFee->getAmount());
        $orderFee->setBaseAmount($quoteFee->getBaseAmount());
        $orderFee->setTaxAmount($quoteFee->getTaxAmount());
        $orderFee->setBaseTaxAmount($quoteFee->getBaseTaxAmount());
        $this->orderFeeRepository->save($orderFee);
    }
}
