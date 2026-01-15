<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model\Sales\Pdf;

use Armah\CashOnDelivery\Api\OrderPaymentFeeRepositoryInterface;
use Armah\CashOnDelivery\Model\FeeTotalCollector;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order\Pdf\Total\DefaultTotal;
use Magento\Tax\Helper\Data;
use Magento\Tax\Model\Calculation;
use Magento\Tax\Model\ResourceModel\Sales\Order\Tax\CollectionFactory;

class PaymentFee extends DefaultTotal
{
    public const DEFAULT_FONT_SIZE = 7;

    /**
     * @var OrderPaymentFeeRepositoryInterface
     */
    private $paymentFeeRepository;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var FeeTotalCollector
     */
    private $feeTotalCollector;

    public function __construct(
        Data $taxHelper,
        Calculation $taxCalculation,
        CollectionFactory $ordersFactory,
        OrderPaymentFeeRepositoryInterface $paymentFeeRepository,
        OrderRepositoryInterface $orderRepository,
        FeeTotalCollector $feeTotalCollector,
        array $data = []
    ) {
        parent::__construct($taxHelper, $taxCalculation, $ordersFactory, $data);
        $this->paymentFeeRepository = $paymentFeeRepository;
        $this->orderRepository = $orderRepository;
        $this->feeTotalCollector = $feeTotalCollector;
    }

    /**
     * @return array
     */
    public function getTotalsForDisplay(): array
    {
        $fontSize = $this->getFontSize() ?: self::DEFAULT_FONT_SIZE;
        try {
            /** @var \Magento\Sales\Model\Order $order */
            $order = $this->orderRepository->get($this->getSource()->getOrderId());
            $storeId = (int)$order->getStoreId();
            $paymentFee = $this->paymentFeeRepository->getByOrderId((int)$order->getEntityId());
            $feeTotals = $this->feeTotalCollector->getTotals($paymentFee, $storeId);

            $resultFeeTotals = [];

            /** @var DataObject $total */
            foreach ($feeTotals as $total) {
                $resultFeeTotals[] = [
                    'font_size' => $fontSize,
                    'label' => $total->getData('label'),
                    'amount' => $this->getOrder()->formatPriceTxt($total->getData('value'))
                ];
            }

            return $resultFeeTotals;
        } catch (NoSuchEntityException $exception) {
            return [];
        }
    }
}
