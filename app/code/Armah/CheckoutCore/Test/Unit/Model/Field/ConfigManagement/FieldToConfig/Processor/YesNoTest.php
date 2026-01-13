<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Test\Unit\Model\Field\ConfigManagement\FieldToConfig\Processor;

use Armah\CheckoutCore\Model\Field;
use Armah\CheckoutCore\Model\Field\ConfigManagement\FieldToConfig\Processor\YesNo;
use Armah\CheckoutCore\Model\Field\ConfigManagement\FieldToConfig\SaveConfigValue;
use Armah\CheckoutCore\Model\Field\ConfigManagement\YesNoOptions;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @see YesNo
 * @covers YesNo::execute
 */
class YesNoTest extends \PHPUnit\Framework\TestCase
{
    private const CONFIG_PATH = 'a/b/c';

    /**
     * @var SaveConfigValue|MockObject
     */
    private $saveConfigValueMock;

    /**
     * @var YesNo
     */
    private $subject;

    protected function setUp(): void
    {
        $this->saveConfigValueMock = $this->createMock(SaveConfigValue::class);
        $this->subject = new YesNo($this->saveConfigValueMock);
    }

    /**
     * @param bool $isEnabled
     * @param string $expectedResult
     * @dataProvider executeDataProvider
     */
    public function testExecute(bool $isEnabled, string $expectedResult): void
    {
        $fieldMock = $this->createMock(Field::class);
        $fieldMock
            ->expects($this->once())
            ->method('isEnabled')
            ->willReturn($isEnabled);

        $this->saveConfigValueMock
            ->expects($this->once())
            ->method('execute')
            ->with(self::CONFIG_PATH, $expectedResult);

        $this->subject->execute($fieldMock, self::CONFIG_PATH);
    }

    public function executeDataProvider(): array
    {
        return [
            [false, YesNoOptions::VALUE_NO],
            [true, YesNoOptions::VALUE_YES],
        ];
    }
}
