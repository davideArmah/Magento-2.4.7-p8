<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\ResourceModel;

use Armah\CheckoutCore\Api\Data\QuotePasswordsInterface;

class QuotePasswords extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public const MAIN_TABLE = 'armah_archeckout_quote_passwords';

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, QuotePasswordsInterface::ENTITY_ID);
    }
}
