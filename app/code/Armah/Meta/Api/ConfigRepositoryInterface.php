<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Api;

/**
 * @api
 */
interface ConfigRepositoryInterface
{
    /**
     * Save
     *
     * @param \Armah\Meta\Api\Data\ConfigInterface $config
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     */
    public function save(\Armah\Meta\Api\Data\ConfigInterface $config);

    /**
     * Get by id
     *
     * @param int $id
     *
     * @return \Armah\Meta\Api\Data\ConfigInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * Delete
     *
     * @param \Armah\Meta\Api\Data\ConfigInterface $config
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Armah\Meta\Api\Data\ConfigInterface $config);

    /**
     * Delete by id
     *
     * @param int $id
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($id);

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
