<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model;

use Armah\CheckoutCore\Api\Data\QuotePasswordsInterface;
use Magento\Framework\Model\AbstractModel;

class QuotePasswords extends AbstractModel implements QuotePasswordsInterface
{
    protected function _construct()
    {
        $this->_init(\Armah\CheckoutCore\Model\ResourceModel\QuotePasswords::class);
    }

    /**
     * @inheritdoc
     */
    public function getQuoteId()
    {
        return $this->_getData(QuotePasswordsInterface::QUOTE_ID);
    }

    /**
     * @inheritdoc
     */
    public function setQuoteId($quoteId)
    {
        $this->setData(QuotePasswordsInterface::QUOTE_ID, $quoteId);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPasswordHash()
    {
        return $this->_getData(QuotePasswordsInterface::PASSWORD_HASH);
    }

    /**
     * @inheritdoc
     */
    public function setPasswordHash($passwordHash)
    {
        $this->setData(QuotePasswordsInterface::PASSWORD_HASH, $passwordHash);

        return $this;
    }
}
