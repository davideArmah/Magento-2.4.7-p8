<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\ResourceModel\AdditionalFields;

/**
 * @method \Armah\CheckoutCore\Model\AdditionalFields[] getItems()
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(
            \Armah\CheckoutCore\Model\AdditionalFields::class,
            \Armah\CheckoutCore\Model\ResourceModel\AdditionalFields::class
        );
    }
}
