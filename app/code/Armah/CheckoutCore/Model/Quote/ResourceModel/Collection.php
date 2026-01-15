<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Quote\ResourceModel;

class Collection extends \Magento\Quote\Model\ResourceModel\Quote\Collection
{
    /**
     * @return int|string
     */
    public function getSize()
    {
        return $this->getConnection()->fetchOne($this->getSelectCountSql(), $this->_bindParams);
    }
}
