<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Api;

use Armah\Orderattr\Api\Data\CheckoutEntityInterface;

/**
 * @api
 */
interface EntityDataRepositoryInterface
{
    /**
     * Save
     *
     * @param \Armah\Orderattr\Api\Data\EntityDataInterface $entityData
     * @return \Armah\Orderattr\Api\Data\EntityDataInterface
     */
    public function save(\Armah\Orderattr\Api\Data\EntityDataInterface $entityData);

    /**
     * Get by id
     *
     * @param int $entityId
     * @return \Armah\Orderattr\Api\Data\EntityDataInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($entityId);

    /**
     * Get by Order id
     *
     * @param int $orderId
     * @param int|null $quoteId
     * @return \Armah\Orderattr\Api\Data\EntityDataInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByOrderId($orderId, $quoteId = null);

    /**
     * Delete
     *
     * @param \Armah\Orderattr\Api\Data\EntityDataInterface $entityData
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Armah\Orderattr\Api\Data\EntityDataInterface $entityData);

    /**
     * Delete by id
     *
     * @param int $entityId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($entityId);

    /**
     * Lists
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param int|null $parentEntityType
     * @return \Armah\Orderattr\Api\Data\EntityDataSearchResultsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        ?int $parentEntityType = CheckoutEntityInterface::ENTITY_TYPE_ORDER
    );
}
