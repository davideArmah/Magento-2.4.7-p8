<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Test\Unit\Model\Field\Form\Processor;

use Armah\CheckoutCore\Model\Field;
use Armah\CheckoutCore\Model\Field\Form\GetOrderAttributes;
use Armah\CheckoutCore\Model\Field\Form\Processor\OrderAttributes;
use Armah\CheckoutCore\Model\Field\SetAttributeFrontendLabel;
use Armah\CheckoutCore\Model\ModuleEnable;
use Armah\CheckoutCore\Observer\OrderAttribute\InvalidateCache;
use Armah\CheckoutCore\Model\OrderAttribute\UpdateSortOrder;
use Magento\Eav\Model\Attribute;
use Magento\Eav\Model\ResourceModel\Entity\Attribute as AttributeResource;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @see OrderAttributes
 * @covers OrderAttributes::process
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class OrderAttributesTest extends \PHPUnit\Framework\TestCase
{
    private const DEFAULT_STORE_ID = Field::DEFAULT_STORE_ID;
    private const STORE_ID = 1;
    private const LABEL = 'some label';

    /**
     * @var ModuleEnable|MockObject
     */
    private $moduleEnableMock;

    /**
     * @var GetOrderAttributes|MockObject
     */
    private $getOrderAttributesMock;

    /**
     * @var SetAttributeFrontendLabel|MockObject
     */
    private $setAttributeFrontendLabelMock;

    /**
     * @var AttributeResource|MockObject
     */
    private $attributeResourceMock;

    /**
     * @var OrderAttributes
     */
    private $subject;

    protected function setUp(): void
    {
        $this->moduleEnableMock = $this->createMock(ModuleEnable::class);
        $this->getOrderAttributesMock = $this->createMock(GetOrderAttributes::class);
        $this->setAttributeFrontendLabelMock = $this->createMock(SetAttributeFrontendLabel::class);
        $this->attributeResourceMock = $this->createMock(AttributeResource::class);

        $this->subject = new OrderAttributes(
            $this->moduleEnableMock,
            $this->getOrderAttributesMock,
            $this->setAttributeFrontendLabelMock,
            $this->attributeResourceMock
        );
    }

    public function testProcessWithModuleDisabled(): void
    {
        $dummyFieldData = ['attribute_id' => 1];

        $this->moduleEnableMock->expects($this->once())->method('isOrderAttributesEnable')->willReturn(false);
        $this->setAttributeFrontendLabelMock->expects($this->never())->method('execute');
        $this->attributeResourceMock->expects($this->never())->method('save');
        $this->assertEquals([$dummyFieldData], $this->subject->process([$dummyFieldData], self::DEFAULT_STORE_ID));
    }

    public function testProcessWithNoFields(): void
    {
        $this->moduleEnableMock->expects($this->once())->method('isOrderAttributesEnable')->willReturn(true);
        $this->setAttributeFrontendLabelMock->expects($this->never())->method('execute');
        $this->attributeResourceMock->expects($this->never())->method('save');
        $this->assertEquals([], $this->subject->process([], self::DEFAULT_STORE_ID));
    }

    public function testProcessWithoutAttributes(): void
    {
        $dummyFieldData = ['attribute_id' => 1];

        $this->moduleEnableMock->expects($this->once())->method('isOrderAttributesEnable')->willReturn(true);
        $this->getOrderAttributesMock->expects($this->once())->method('execute')->willReturn([]);
        $this->setAttributeFrontendLabelMock->expects($this->never())->method('execute');
        $this->attributeResourceMock->expects($this->never())->method('save');
        $this->assertEquals([$dummyFieldData], $this->subject->process([$dummyFieldData], self::DEFAULT_STORE_ID));
    }

    /**
     * @param MockObject $attributeMock
     * @param array $fields
     * @dataProvider processWithNoMatchingAttributesDataProvider
     */
    public function testProcessWithNoMatchingAttributes(MockObject $attributeMock, array $fields): void
    {
        $this->moduleEnableMock->expects($this->once())->method('isOrderAttributesEnable')->willReturn(true);
        $this->getOrderAttributesMock->expects($this->once())->method('execute')->willReturn([$attributeMock]);
        $this->setAttributeFrontendLabelMock->expects($this->never())->method('execute');
        $this->attributeResourceMock->expects($this->never())->method('save');
        $this->assertSame($fields, $this->subject->process($fields, self::DEFAULT_STORE_ID));
    }

    /**
     * @param MockObject $attributeMock
     * @param array $fields
     * @dataProvider processWithFieldWithUseDefaultDataProvider
     */
    public function testProcessWithFieldWithUseDefault(MockObject $attributeMock, array $fields): void
    {
        $this->moduleEnableMock->expects($this->once())->method('isOrderAttributesEnable')->willReturn(true);
        $this->getOrderAttributesMock->expects($this->once())->method('execute')->willReturn([$attributeMock]);
        $this->setAttributeFrontendLabelMock->expects($this->never())->method('execute');
        $this->attributeResourceMock->expects($this->never())->method('save');
        $this->assertEquals([], $this->subject->process($fields, self::DEFAULT_STORE_ID));
    }

    /**
     * @param MockObject $attributeMock
     * @param array $fields
     * @param bool $expectedIsRequired
     * @param int $expectedSortingOrder
     * @param bool $expectedIsVisibleOnFront
     * @param bool $expectedIsVisibleOnBack
     * @throws \Exception
     * @dataProvider processWithMatchingAttributeAndDefaultStoreDataProvider
     */
    public function testProcessWithDefaultStoreId(
        MockObject $attributeMock,
        array $fields,
        int $expectedSortingOrder,
        bool $expectedIsRequired,
        bool $expectedIsVisibleOnFront,
        bool $expectedIsVisibleOnBack
    ): void {
        $this->moduleEnableMock
            ->expects($this->once())
            ->method('isOrderAttributesEnable')
            ->willReturn(true);

        $this->getOrderAttributesMock
            ->expects($this->once())
            ->method('execute')
            ->willReturn([$attributeMock]);

        $attributeMock
            ->expects($this->once())
            ->method('setIsRequired')
            ->with($expectedIsRequired);
        $attributeMock
            ->expects($this->exactly(6))
            ->method('setData')
            ->willReturnCallback(
                function (
                    $key,
                    $value
                ) use (
                    $attributeMock,
                    $expectedSortingOrder,
                    $expectedIsVisibleOnFront,
                    $expectedIsVisibleOnBack
                ) {
                    switch ($key) {
                        case 'sorting_order':
                            $this->assertSame($expectedSortingOrder, $value);
                            break;
                        case 'is_visible_on_front':
                            $this->assertSame($expectedIsVisibleOnFront, $value);
                            break;
                        case 'is_visible_on_back':
                            $this->assertSame($expectedIsVisibleOnBack, $value);
                            break;
                        case 'required_on_front_only':
                            $this->assertFalse($value);
                            break;
                        case InvalidateCache::FLAG_NO_INVALIDATE:
                        case UpdateSortOrder::FLAG_NO_UPDATE:
                            $this->assertTrue($value);
                            break;
                    }

                    return $attributeMock;
                }
            );

        $this->setAttributeFrontendLabelMock
            ->expects($this->once())
            ->method('execute')
            ->with($attributeMock, self::DEFAULT_STORE_ID, self::LABEL);

        $this->attributeResourceMock
            ->expects($this->once())
            ->method('save')
            ->with($attributeMock);

        $this->assertEquals([], $this->subject->process($fields, self::DEFAULT_STORE_ID));
    }

    /**
     * @param MockObject $attributeMock
     * @param array $fields
     * @dataProvider processWithMatchingAttributeDataProvider
     */
    public function testProcessWithStoreId(MockObject $attributeMock, array $fields): void
    {
        $this->moduleEnableMock
            ->expects($this->once())
            ->method('isOrderAttributesEnable')
            ->willReturn(true);

        $this->getOrderAttributesMock
            ->expects($this->once())
            ->method('execute')
            ->willReturn([$attributeMock]);

        $this->setAttributeFrontendLabelMock
            ->expects($this->once())
            ->method('execute')
            ->with($attributeMock, self::STORE_ID, self::LABEL);

        $this->attributeResourceMock
            ->expects($this->once())
            ->method('save')
            ->with($attributeMock);

        $attributeMock
            ->expects($this->exactly(2))
            ->method('setData')
            ->willReturnCallback(function ($key, $value) use ($attributeMock) {
                if ($key === InvalidateCache::FLAG_NO_INVALIDATE || $key === UpdateSortOrder::FLAG_NO_UPDATE) {
                    $this->assertTrue($value);
                }
                return $attributeMock;
            });
        $attributeMock->expects($this->never())->method('setIsRequired');
        $this->assertEquals([], $this->subject->process($fields, self::STORE_ID));
    }

    public function processWithNoMatchingAttributesDataProvider(): array
    {
        return [
            [
                $this->createConfiguredMock(Attribute::class, ['getAttributeId' => '1']),
                [
                    2 => ['attribute_id' => 2]
                ]
            ]
        ];
    }

    public function processWithFieldWithUseDefaultDataProvider(): array
    {
        return [
            [
                $this->createConfiguredMock(Attribute::class, ['getAttributeId' => '1']),
                [
                    1 => ['attribute_id' => 1, 'use_default' => 1]
                ]
            ]
        ];
    }

    public function processWithMatchingAttributeAndDefaultStoreDataProvider(): array
    {
        return [
            [
                $this->createConfiguredMock(Attribute::class, ['getAttributeId' => '1']),
                [
                    1 => ['attribute_id' => 1, 'enabled' => 1, 'sort_order' => 0, 'label' => self::LABEL]
                ],
                0,
                false,
                true,
                true
            ],
            [
                $this->createConfiguredMock(Attribute::class, ['getAttributeId' => '1']),
                [
                    1 => [
                        'attribute_id'  => 1,
                        'enabled'       => 1,
                        'required'      => 1,
                        'sort_order'    => 0,
                        'label'         => self::LABEL
                    ]
                ],
                0,
                true,
                true,
                true
            ],
            [
                $this->createConfiguredMock(Attribute::class, ['getAttributeId' => '1']),
                [
                    1 => ['attribute_id' => 1, 'enabled' => 0, 'sort_order' => 0, 'label' => self::LABEL]
                ],
                0,
                false,
                false,
                false
            ],
            [
                $this->createConfiguredMock(Attribute::class, ['getAttributeId' => '1']),
                [
                    1 => [
                        'attribute_id'  => 1,
                        'enabled'       => 0,
                        'required'      => 1,
                        'sort_order'    => 0,
                        'label'         => self::LABEL
                    ]
                ],
                0,
                false,
                false,
                false
            ]
        ];
    }

    public function processWithMatchingAttributeDataProvider(): array
    {
        return [
            [
                $this->createConfiguredMock(Attribute::class, ['getAttributeId' => '1']),
                [
                    1 => ['attribute_id' => 1, 'enabled' => 0, 'sort_order' => 0, 'label' => self::LABEL]
                ]
            ],
            [
                $this->createConfiguredMock(Attribute::class, ['getAttributeId' => '1']),
                [
                    1 => [
                        'attribute_id'  => 1,
                        'enabled'       => 0,
                        'required'      => 1,
                        'sort_order'    => 0,
                        'label'         => self::LABEL
                    ]
                ]
            ],
            [
                $this->createConfiguredMock(Attribute::class, ['getAttributeId' => '1']),
                [
                    1 => ['attribute_id' => 1, 'enabled' => 1, 'sort_order' => 0, 'label' => self::LABEL]
                ]
            ],
            [
                $this->createConfiguredMock(Attribute::class, ['getAttributeId' => '1']),
                [
                    1 => [
                        'attribute_id'  => 1,
                        'enabled'       => 1,
                        'required'      => 1,
                        'sort_order'    => 0,
                        'label'         => self::LABEL
                    ]
                ]
            ],
        ];
    }
}
