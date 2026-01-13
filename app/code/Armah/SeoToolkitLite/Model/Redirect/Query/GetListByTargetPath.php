<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Model\Redirect\Query;

use Armah\SeoToolkitLite\Api\Data\RedirectInterface;
use Armah\SeoToolkitLite\Model\ResourceModel\Redirect\Collection;
use Armah\SeoToolkitLite\Model\ResourceModel\Redirect\CollectionFactory;

class GetListByTargetPath implements GetListByTargetPathInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    public function execute(string $targetPath): Collection
    {
        $collection =  $this->collectionFactory->create()
            ->addFieldToFilter(RedirectInterface::TARGET_PATH, $targetPath);
        $collection->getSelect()->joinLeft(
            ['stores' => $collection->getTable(RedirectInterface::STORE_TABLE_NAME)],
            sprintf('main_table.%1$s = stores.%1$s', RedirectInterface::REDIRECT_ID),
            sprintf('GROUP_CONCAT(stores.%s) as store_ids', RedirectInterface::STORE_ID)
        )->group(sprintf('main_table.%s', RedirectInterface::REDIRECT_ID));
        
        return $collection;
    }
}
