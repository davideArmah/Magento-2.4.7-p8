<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Test\Unit\Model;

use Armah\CheckoutCore\Model\GuestAdditionalFieldsManagement;
use Armah\CheckoutCore\Test\Unit\Traits;

/**
 * @see GuestAdditionalFieldsManagement
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * phpcs:ignoreFile
 */
class GuestAdditionalFieldsManagementTest extends \PHPUnit\Framework\TestCase
{
    use Traits\ObjectManagerTrait;
    use Traits\ReflectionTrait;

    const QUOTE_ID = 1;

    /**
     * @covers GuestAdditionalFieldsManagement::save
     */
    public function testSave()
    {
        $cartId = 1;
        $fields = $this->createMock(\Armah\CheckoutCore\Model\AdditionalFields::class);
        $guestFieldsManagment = $this->createPartialMock(GuestAdditionalFieldsManagement::class, []);

        $quoteMaskId = $this->createPartialMock(
            \Magento\Quote\Model\QuoteIdMask::class,
            ['load']
        );
        $quoteMaskId->expects($this->any())->method('load')->with($cartId, 'masked_id')
            ->willReturn($quoteMaskId);
        $quoteMaskId->setQuoteId(self::QUOTE_ID);

        $quoteIdMaskFactory = $this->createPartialMock(
            \Magento\Quote\Model\QuoteIdMaskFactory::class,
            ['create']
        );
        $quoteIdMaskFactory->expects($this->any())->method('create')
            ->willReturn($quoteMaskId);

        $fieldsManagement = $this->createPartialMock(
            \Armah\CheckoutCore\Model\AdditionalFieldsManagement::class,
            ['save']
        );
        $fieldsManagement->expects($this->any())->method('save')
            ->with(self::QUOTE_ID, $fields)
            ->willReturn(true);

        $this->setProperty(
            $guestFieldsManagment,
            'quoteIdMaskFactory',
            $quoteIdMaskFactory,
            GuestAdditionalFieldsManagement::class
        );
        $this->setProperty(
            $guestFieldsManagment,
            'fieldsManagement',
            $fieldsManagement,
            GuestAdditionalFieldsManagement::class
        );

        $this->assertTrue($guestFieldsManagment->save($cartId, $fields));
    }
}
