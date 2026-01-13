<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout for Magento 2
 */

namespace Armah\Checkout\Api;

use Armah\Checkout\Api\Data\PlaceholderInterface;
use Magento\Framework\Api\SearchCriteria;

interface PlaceholderRepositoryInterface
{
    /**
     * @param int $placeholderId
     *
     * @return PlaceholderInterface
     */
    public function getById(int $placeholderId): PlaceholderInterface;

    /**
     * @param int $attributeId
     * @param int $storeId
     *
     * @return PlaceholderInterface
     */
    public function getByAttributeIdAndStoreId(int $attributeId, int $storeId): PlaceholderInterface;

    /**
     * @param SearchCriteria $searchCriteria
     *
     * @return array|null
     */
    public function getList(SearchCriteria $searchCriteria): ?array;

    /**
     * @param PlaceholderInterface $placeholderEntity
     *
     * @throws CouldNotDeleteException
     */
    public function delete(PlaceholderInterface $placeholderEntity): void;

    /**
     * @param PlaceholderInterface $placeholderEntity
     *
     * @throws CouldNotSaveException
     */
    public function save(PlaceholderInterface $placeholderEntity): void;
}
