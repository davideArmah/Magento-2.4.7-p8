<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\ResourceModel\Entity;

use Armah\Orderattr\Api\Data\CheckoutEntityInterface;

class Grid extends \Armah\Orderattr\Model\ResourceModel\Entity\EntityData\Collection
{
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->addFieldToFilter(
            CheckoutEntityInterface::PARENT_ENTITY_TYPE,
            CheckoutEntityInterface::ENTITY_TYPE_ORDER
        );
        $this->getSelect()->group($this->getIdFieldName());

        return $this;
    }
}
