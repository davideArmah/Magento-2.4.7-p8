<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Api;

/**
 * @api
 */
interface PaymentFeeRepositoryInterface
{
    /**
     * Save
     *
     * @param \Armah\CashOnDelivery\Api\Data\PaymentFeeInterface $paymentFee
     *
     * @return \Armah\CashOnDelivery\Api\Data\PaymentFeeInterface
     */
    public function save(\Armah\CashOnDelivery\Api\Data\PaymentFeeInterface $paymentFee);

    /**
     * Get by id
     *
     * @param int $entityId
     *
     * @return \Armah\CashOnDelivery\Api\Data\PaymentFeeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($entityId);

    /**
     * Get by id
     *
     * @param int $quoteId
     *
     * @return \Armah\CashOnDelivery\Api\Data\PaymentFeeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByQuoteId($quoteId);

    /**
     * Delete
     *
     * @param \Armah\CashOnDelivery\Api\Data\PaymentFeeInterface $paymentFee
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Armah\CashOnDelivery\Api\Data\PaymentFeeInterface $paymentFee);

    /**
     * Delete by id
     *
     * @param int $entityId
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($entityId);

    /**
     * Lists
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
