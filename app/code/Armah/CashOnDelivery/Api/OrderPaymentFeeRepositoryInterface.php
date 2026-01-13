<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Api;

use Armah\CashOnDelivery\Api\Data\OrderPaymentFeeInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @api
 */
interface OrderPaymentFeeRepositoryInterface
{
    /**
     * @param OrderPaymentFeeInterface $paymentFee
     * @return OrderPaymentFeeInterface
     */
    public function save(OrderPaymentFeeInterface $paymentFee): OrderPaymentFeeInterface;

    /**
     * @param int $entityId
     * @return OrderPaymentFeeInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $entityId): OrderPaymentFeeInterface;

    /**
     * @param int $orderId
     * @return OrderPaymentFeeInterface
     * @throws NoSuchEntityException
     */
    public function getByOrderId(int $orderId): OrderPaymentFeeInterface;

    /**
     * @param OrderPaymentFeeInterface $paymentFee
     * @return bool true on success
     * @throws CouldNotDeleteException
     */
    public function delete(OrderPaymentFeeInterface $paymentFee): bool;

    /**
     * @param int $entityId
     * @return bool true on success
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $entityId): bool;
}
