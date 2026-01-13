<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) 2023 Amasty (https://www.armah.it)
 * @package One Step Checkout Gift Wrap for Magento 2 (System)
 */

namespace Armah\CheckoutGiftWrap\Model;

use Armah\CheckoutGiftWrap\Api\GiftMessageInformationManagementInterface;
use Armah\CheckoutGiftWrap\Api\GuestGiftMessageInformationManagementInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;

class GuestGiftMessageInformationManagement implements GuestGiftMessageInformationManagementInterface
{
    /**
     * @var QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;

    /**
     * @var GiftMessageInformationManagementInterface
     */
    protected $giftMessageInformationManagement;

    public function __construct(
        QuoteIdMaskFactory $quoteIdMaskFactory,
        GiftMessageInformationManagementInterface $giftMessageInformationManagement
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->giftMessageInformationManagement = $giftMessageInformationManagement;
    }

    /**
     * @param string $cartId
     * @param mixed $giftMessage
     * @return bool
     */
    public function update($cartId, $giftMessage): bool
    {
        /** @var $quoteIdMask \Magento\Quote\Model\QuoteIdMask */
        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
        return $this->giftMessageInformationManagement->update(
            $quoteIdMask->getQuoteId(),
            $giftMessage
        );
    }
}
