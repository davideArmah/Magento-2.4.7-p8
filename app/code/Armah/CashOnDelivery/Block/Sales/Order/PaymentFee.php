<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Block\Sales\Order;

use Armah\CashOnDelivery\Api\OrderPaymentFeeRepositoryInterface;
use Armah\CashOnDelivery\Model\FeeTotalCollector;
use Armah\CashOnDelivery\Model\OrderPaymentFee;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class PaymentFee extends Template
{
    /**
     * @var FeeTotalCollector
     */
    private $feeTotalCollector;

    /**
     * @var OrderPaymentFeeRepositoryInterface
     */
    private $paymentFeeRepository;

    public function __construct(
        Context $context,
        FeeTotalCollector $feeTotalCollector,
        OrderPaymentFeeRepositoryInterface $paymentFeeRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->feeTotalCollector = $feeTotalCollector;
        $this->paymentFeeRepository = $paymentFeeRepository;
    }

    /**
     * @return $this
     */
    public function initTotals()
    {
        $parentBlock = $this->getParentBlock();

        if (!$parentBlock || !method_exists($parentBlock, 'getOrder')) {
            return $this;
        }

        /** @var \Magento\Sales\Model\Order $order */
        $order = $parentBlock->getOrder();

        if (!($order instanceof \Magento\Sales\Api\Data\OrderInterface)) {
            return $this;
        }

        try {
            /** @var OrderPaymentFee $paymentFee */
            $paymentFee = $this->paymentFeeRepository->getByOrderId((int)$order->getEntityId());
        } catch (NoSuchEntityException $exception) {
            return $this;
        }

        if ($paymentFee->getAmount()) {
            $storeId = (int)$order->getStoreId();
            $feeTotals = $this->feeTotalCollector->getTotals($paymentFee, $storeId);
            foreach ($feeTotals as $total) {
                $parentBlock->addTotalBefore($total, 'grand_total');
            }
        }

        return $this;
    }
}
