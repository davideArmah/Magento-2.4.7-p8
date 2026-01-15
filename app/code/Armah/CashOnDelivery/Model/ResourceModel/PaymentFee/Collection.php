<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model\ResourceModel\PaymentFee;

use Armah\CashOnDelivery\Model\PaymentFee;
use Armah\CashOnDelivery\Model\ResourceModel\PaymentFee as PaymentFeeResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(PaymentFee::class, PaymentFeeResource::class);
    }
}
