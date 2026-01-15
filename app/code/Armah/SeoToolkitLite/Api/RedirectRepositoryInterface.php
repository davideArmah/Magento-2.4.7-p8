<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Api;

interface RedirectRepositoryInterface
{
    /**
     * Save
     *
     * @param \Armah\SeoToolkitLite\Api\Data\RedirectInterface $redirect
     *
     * @return \Armah\SeoToolkitLite\Api\Data\RedirectInterface
     */
    public function save(\Armah\SeoToolkitLite\Api\Data\RedirectInterface $redirect);

    /**
     * Get by id
     *
     * @param int $id
     *
     * @return \Armah\SeoToolkitLite\Api\Data\RedirectInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * Delete
     *
     * @param \Armah\SeoToolkitLite\Api\Data\RedirectInterface $redirect
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Armah\SeoToolkitLite\Api\Data\RedirectInterface $redirect);

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
