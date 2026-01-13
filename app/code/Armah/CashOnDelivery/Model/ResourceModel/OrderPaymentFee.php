<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model\ResourceModel;

use Armah\CashOnDelivery\Api\Data\OrderPaymentFeeInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OrderPaymentFee extends AbstractDb
{
    public const TABLE_NAME = 'armah_cash_on_delivery_fee_order';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, OrderPaymentFeeInterface::ENTITY_ID);
    }
}
