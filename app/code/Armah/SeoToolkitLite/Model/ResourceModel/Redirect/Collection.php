<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Model\ResourceModel\Redirect;

use Armah\SeoToolkitLite\Api\Data\RedirectInterface;
use Armah\SeoToolkitLite\Model\Redirect;
use Armah\SeoToolkitLite\Model\ResourceModel\Redirect as ResourceRedirect;
use Magento\Store\Model\Store;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public function _construct()
    {
        $this->_init(Redirect::class, ResourceRedirect::class);
        $this->_setIdFieldName(RedirectInterface::REDIRECT_ID);
    }

    /**
     * @param array $orders
     */
    public function setOrders(array $orders)
    {
        $this->_orders = $orders;

        return $this;
    }

    /**
     * @param int $storeId
     * @return $this
     */
    public function addStoreFilter(int $storeId)
    {
        $storeIds = [$storeId, Store::DEFAULT_STORE_ID];
        $this->getSelect()->joinLeft(
            ['stores' => $this->getTable(RedirectInterface::STORE_TABLE_NAME)],
            'main_table.redirect_id = stores.redirect_id',
            ['store_id']
        )
            ->where('store_id IN (?)', $storeIds)
            ->group('main_table.redirect_id');

        return $this;
    }
}
