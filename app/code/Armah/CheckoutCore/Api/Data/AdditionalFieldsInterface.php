<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Api\Data;

interface AdditionalFieldsInterface
{
    /**
     * Constants defined for keys of data array
     */
    public const ID = 'id';
    public const QUOTE_ID = 'quote_id';
    public const COMMENT = 'comment';
    public const IS_SUBSCRIBE = 'is_subscribe';
    public const IS_REGISTER = 'is_register';
    public const REGISTER_DOB = 'register_dob';

    /**
     * @return string|null
     */
    public function getComment();

    /**
     * @param string|null $comment
     *
     * @return \Armah\CheckoutCore\Api\Data\AdditionalFieldsInterface
     */
    public function setComment($comment);

    /**
     * @return bool|int|null
     */
    public function getSubscribe();

    /**
     * @param bool|int|null $isSubscribe
     *
     * @return \Armah\CheckoutCore\Api\Data\AdditionalFieldsInterface
     */
    public function setSubscribe($isSubscribe);

    /**
     * @return bool|int|null
     */
    public function getRegister();

    /**
     * @param bool|int|null $isRegister
     *
     * @return \Armah\CheckoutCore\Api\Data\AdditionalFieldsInterface
     */
    public function setRegister($isRegister);

    /**
     * @return string|null
     */
    public function getDateOfBirth();

    /**
     * @param string|null $registerDob
     *
     * @return \Armah\CheckoutCore\Api\Data\AdditionalFieldsInterface
     */
    public function setDateOfBirth($registerDob);
}
