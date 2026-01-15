<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model\Repository;

use Armah\CashOnDelivery\Api\Data\OrderPaymentFeeInterface;
use Armah\CashOnDelivery\Api\OrderPaymentFeeRepositoryInterface;
use Armah\CashOnDelivery\Model\OrderPaymentFeeFactory;
use Armah\CashOnDelivery\Model\ResourceModel\OrderPaymentFee as PaymentFeeResource;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class OrderPaymentFeeRepository implements OrderPaymentFeeRepositoryInterface
{
    /**
     * @var OrderPaymentFeeFactory
     */
    private $paymentFeeFactory;

    /**
     * @var PaymentFeeResource
     */
    private $paymentFeeResource;

    /**
     * Model data storage
     *
     * @var array
     */
    private $paymentFees;

    public function __construct(
        OrderPaymentFeeFactory $paymentFeeFactory,
        PaymentFeeResource $paymentFeeResource
    ) {
        $this->paymentFeeFactory = $paymentFeeFactory;
        $this->paymentFeeResource = $paymentFeeResource;
    }

    /**
     * @param OrderPaymentFeeInterface $paymentFee
     * @return OrderPaymentFeeInterface
     * @throws CouldNotSaveException
     */
    public function save(OrderPaymentFeeInterface $paymentFee): OrderPaymentFeeInterface
    {
        try {
            if ($paymentFee->getEntityId()) {
                $paymentFee = $this->getById($paymentFee->getEntityId())->addData($paymentFee->getData());
            }
            $this->paymentFeeResource->save($paymentFee);
            unset($this->paymentFees[$paymentFee->getEntityId()]);
        } catch (\Exception $e) {
            if ($paymentFee->getEntityId()) {
                throw new CouldNotSaveException(
                    __(
                        'Unable to save payment fee with ID %1. Error: %2',
                        [$paymentFee->getEntityId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotSaveException(__('Unable to save new payment fee. Error: %1', $e->getMessage()));
        }

        return $paymentFee;
    }

    /**
     * @param int $entityId
     * @return OrderPaymentFeeInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $entityId): OrderPaymentFeeInterface
    {
        if (!isset($this->paymentFees[$entityId])) {
            /** @var \Armah\CashOnDelivery\Model\PaymentFee $paymentFee */
            $paymentFee = $this->paymentFeeFactory->create();
            $this->paymentFeeResource->load($paymentFee, $entityId);
            if (!$paymentFee->getEntityId()) {
                throw new NoSuchEntityException(__('Payment fee with specified ID "%1" not found.', $entityId));
            }
            $this->paymentFees[$entityId] = $paymentFee;
        }

        return $this->paymentFees[$entityId];
    }

    /**
     * @param int $orderId
     * @return OrderPaymentFeeInterface
     * @throws NoSuchEntityException
     */
    public function getByOrderId(int $orderId): OrderPaymentFeeInterface
    {
        /** @var \Armah\CashOnDelivery\Model\OrderPaymentFee $paymentFee */
        $paymentFee = $this->paymentFeeFactory->create();
        $this->paymentFeeResource->load($paymentFee, $orderId, OrderPaymentFeeInterface::ORDER_ID);
        if (!$paymentFee->getEntityId()) {
            throw new NoSuchEntityException(__('Payment fee with specified ID "%1" not found.', $orderId));
        }

        return $paymentFee;
    }

    /**
     * @param OrderPaymentFeeInterface $paymentFee
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(OrderPaymentFeeInterface $paymentFee): bool
    {
        try {
            $this->paymentFeeResource->delete($paymentFee);
            unset($this->paymentFees[$paymentFee->getEntityId()]);
        } catch (\Exception $e) {
            if ($paymentFee->getEntityId()) {
                throw new CouldNotDeleteException(
                    __(
                        'Unable to remove payment fee with ID %1. Error: %2',
                        [$paymentFee->getEntityId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotDeleteException(__('Unable to remove payment fee. Error: %1', $e->getMessage()));
        }

        return true;
    }

    /**
     * @param int $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $entityId): bool
    {
        $paymentFeeModel = $this->getById($entityId);
        $this->delete($paymentFeeModel);

        return true;
    }
}
