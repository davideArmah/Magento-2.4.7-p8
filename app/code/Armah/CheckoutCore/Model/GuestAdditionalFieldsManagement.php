<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model;

use Armah\CheckoutCore\Api\GuestAdditionalFieldsManagementInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;

class GuestAdditionalFieldsManagement implements GuestAdditionalFieldsManagementInterface
{
    /**
     * @var QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;

    /**
     * @var AdditionalFieldsManagement
     */
    private $fieldsManagement;

    public function __construct(
        QuoteIdMaskFactory $quoteIdMaskFactory,
        AdditionalFieldsManagement $fieldsManagement
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->fieldsManagement = $fieldsManagement;
    }

    /**
     * @inheritdoc
     */
    public function save($cartId, $comment)
    {
        /** @var $quoteIdMask \Magento\Quote\Model\QuoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        return $this->fieldsManagement->save(
            $quoteIdMask->getQuoteId(),
            $comment
        );
    }
}
