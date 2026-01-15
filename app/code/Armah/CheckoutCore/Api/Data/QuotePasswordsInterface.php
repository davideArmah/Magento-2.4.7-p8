<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Api\Data;

interface QuotePasswordsInterface
{
    /**
     * Constants defined for keys of data array
     */
    public const ENTITY_ID = 'entity_id';
    public const QUOTE_ID = 'quote_id';
    public const PASSWORD_HASH = 'password_hash';

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entityId
     *
     * @return \Armah\CheckoutCore\Api\Data\QuotePasswordsInterface
     */
    public function setEntityId($entityId);

    /**
     * @return int
     */
    public function getQuoteId();

    /**
     * @param int $quoteId
     *
     * @return \Armah\CheckoutCore\Api\Data\QuotePasswordsInterface
     */
    public function setQuoteId($quoteId);

    /**
     * @return string|null
     */
    public function getPasswordHash();

    /**
     * @param string|null $passwordHash
     *
     * @return \Armah\CheckoutCore\Api\Data\QuotePasswordsInterface
     */
    public function setPasswordHash($passwordHash);
}
