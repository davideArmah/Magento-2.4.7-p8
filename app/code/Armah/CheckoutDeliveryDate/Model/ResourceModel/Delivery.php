<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Delivery Date for Magento 2 (System)
 */

namespace Armah\CheckoutDeliveryDate\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Delivery extends AbstractDb
{
    public const MAIN_TABLE = 'armah_archeckout_delivery';

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, 'id');
    }
}
