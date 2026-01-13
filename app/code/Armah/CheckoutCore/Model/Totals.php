<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model;

use Magento\Framework\DataObject;
use Armah\CheckoutCore\Api\Data\TotalsInterface;

class Totals extends DataObject implements TotalsInterface
{
    /**
     * @inheritdoc
     */
    public function getTotals()
    {
        return $this->getData(self::TOTALS);
    }

    /**
     * @inheritdoc
     */
    public function getShipping()
    {
        return $this->getData(self::SHIPPING);
    }

    /**
     * @inheritdoc
     */
    public function getPayment()
    {
        return $this->getData(self::PAYMENT);
    }

    /**
     * @return string
     */
    public function getQuoteMessages()
    {
        return $this->getData(self::QUOTE_MESSAGES);
    }
}
