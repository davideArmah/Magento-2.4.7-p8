<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\ResourceModel;

use Armah\CheckoutCore\Api\Data\OrderCustomFieldsInterface;

class OrderCustomFields extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public const MAIN_TABLE = 'armah_archeckout_order_custom_fields';

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, OrderCustomFieldsInterface::ID);
    }
}
