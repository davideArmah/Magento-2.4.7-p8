<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\ResourceModel;

class Fee extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public const MAIN_TABLE = 'armah_archeckout_additional_fee';

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, 'id');
    }
}
