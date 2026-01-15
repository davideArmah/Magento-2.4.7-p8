<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model\ResourceModel;

use Armah\CashOnDelivery\Api\Data\PaymentFeeInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PaymentFee extends AbstractDb
{
    public const TABLE_NAME = 'armah_cash_on_delivery_fee_quote';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, PaymentFeeInterface::ENTITY_ID);
    }
}
