<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Field extends AbstractDb
{
    public const MAIN_TABLE = 'armah_archeckout_field';

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, 'id');
    }
}
