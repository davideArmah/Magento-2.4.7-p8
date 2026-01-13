<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model\ResourceModel\Link;

use Armah\CrossLinks\Model\Link;
use Armah\CrossLinks\Model\ResourceModel\Link as LinkResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @method Link getFirstItem()
 * @method Link[] getItems()
 */
class Collection extends AbstractCollection
{
    public const IS_GROUPED_FLAG = 'is_grouped';

    public const STORE_JOINED_FLAG = 'store_joined';

    /**
     * @var string
     */
    protected $_idFieldName = 'link_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            Link::class,
            LinkResourceModel::class
        );
    }

    /**
     * @param array $storeIds
     * @return $this
     */
    public function addStoreIdFilter(array $storeIds)
    {
        $this->joinStoreIds();
        $this->getSelect()
            ->where('link_store.store_id IN (?)', $storeIds);

        return $this;
    }

    public function joinStoreIds(): self
    {
        if (!$this->getFlag(self::STORE_JOINED_FLAG)) {
            $this->setFlag(self::STORE_JOINED_FLAG, true);

            $this->getSelect()
                ->joinInner(
                    ['link_store' => $this->getTable('armah_cross_link_store')],
                    'main_table.link_id = link_store.link_id',
                    ['store_ids' => new \Zend_Db_Expr('GROUP_CONCAT(store_id SEPARATOR ",")')]
                );

            $this->groupById();
        }

        return $this;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function addStatusFilter($status = Link::STATUS_ACTIVE)
    {
        $this->getSelect()->where('main_table.status = ?', $status);

        return $this;
    }

    /**
     * @param Link $item
     * @return Link
     */
    public function beforeAddLoadedItem(\Magento\Framework\DataObject $item)
    {
        if ($this->getFlag(self::STORE_JOINED_FLAG)) {
            $item->setStoreIds(explode(',', $item->getDataByKey('store_ids')));
        }

        return parent::beforeAddLoadedItem($item);
    }

    /**
     * @return $this
     */
    public function addPriorityOrder()
    {
        $this->getSelect()->order('main_table.priority ASC');

        return $this;
    }

    /**
     * @return $this
     */
    public function groupById()
    {
        if (!$this->getFlag(self::IS_GROUPED_FLAG)) {
            $this->getSelect()->group('main_table.link_id');
            $this->setFlag(self::IS_GROUPED_FLAG, true);
        }

        return $this;
    }
}
