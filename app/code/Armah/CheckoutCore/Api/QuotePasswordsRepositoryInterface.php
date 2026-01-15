<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Api;

/**
 * @api
 */
interface QuotePasswordsRepositoryInterface
{
    /**
     * Save
     *
     * @param \Armah\CheckoutCore\Api\Data\QuotePasswordsInterface $quotePasswords
     *
     * @return \Armah\CheckoutCore\Api\Data\QuotePasswordsInterface
     */
    public function save(\Armah\CheckoutCore\Api\Data\QuotePasswordsInterface $quotePasswords);

    /**
     * Get by id
     *
     * @param int $entityId
     *
     * @return \Armah\CheckoutCore\Api\Data\QuotePasswordsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($entityId);

    /**
     * Get by quote id
     *
     * @param int $quoteId
     *
     * @return \Armah\CheckoutCore\Api\Data\QuotePasswordsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByQuoteId($quoteId);

    /**
     * Delete
     *
     * @param \Armah\CheckoutCore\Api\Data\QuotePasswordsInterface $quotePasswords
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Armah\CheckoutCore\Api\Data\QuotePasswordsInterface $quotePasswords);

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
