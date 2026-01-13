<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Api;

/**
 * Interface RelationRepositoryInterface
 *
 * @api
 */
interface RelationRepositoryInterface
{
    /**
     * @param \Armah\Orderattr\Api\Data\RelationInterface $relation
     *
     * @return \Armah\Orderattr\Api\Data\RelationInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Armah\Orderattr\Api\Data\RelationInterface $relation);

    /**
     * @param int $relationId
     *
     * @return \Armah\Orderattr\Api\Data\RelationInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($relationId);

    /**
     * @param \Armah\Orderattr\Api\Data\RelationInterface $relation
     *
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Armah\Orderattr\Api\Data\RelationInterface $relation);

    /**
     * @param int $ruleId
     *
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($ruleId);
}
