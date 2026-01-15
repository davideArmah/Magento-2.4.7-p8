<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Model\ResourceModel\OrderPaymentFee;

use Armah\CashOnDelivery\Api\Data\OrderPaymentFeeInterface;
use Armah\CashOnDelivery\Model\OrderPaymentFee;
use Armah\CashOnDelivery\Model\ResourceModel\OrderPaymentFee as OrderPaymentFeeResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = OrderPaymentFeeInterface::ENTITY_ID;

    public function _construct()
    {
        $this->_init(OrderPaymentFee::class, OrderPaymentFeeResource::class);
    }
}
