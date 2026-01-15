<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Delivery Date for Magento 2 (System)
 */

namespace Armah\CheckoutDeliveryDate\Test\Integration\Model;

use Armah\CheckoutDeliveryDate\Model\DeliveryInformationManagement;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\TestFramework\Helper\Bootstrap;

/**
 * @see DeliveryInformationManagement
 * @magentoAppArea frontend
 * @magentoAppIsolation disabled
 * @magentoDbIsolation disabled
 */
class DeliveryInformationManagementTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->objectManager->get(ResolverInterface::class)->setLocale(null);
        parent::tearDown();
    }

    /**
     * @dataProvider formatDateDataProvider
     */
    public function testFormatDate(string $date, string $locale, ?string $timestamp): void
    {
        $this->objectManager->get(ResolverInterface::class)->setLocale($locale);
        $model = $this->objectManager->get(DeliveryInformationManagement::class);
        $timezone = $this->objectManager->get(TimezoneInterface::class);

        $method = new \ReflectionMethod(DeliveryInformationManagement::class, 'formatDate');
        $method->setAccessible(true);

        $this->assertSame(
            $timestamp,
            $method->invoke($model, $date),
            'Wrong result for date="' . $date . '", locale="' . $locale . '"' .
            ', dateFormat="' . $timezone->getDateFormat() . '"'
        );
    }

    private function formatDateDataProvider(): array
    {
        return [
            'US regular' => ['1/02/1970', 'en_US', '86400'],
            'US short' => ['1/2/70', 'en_US', '86400'],
            'empty' => ['', 'en_US', null],
            'Canada' => ['1970-01-02', 'fr_CA', '86400'],
            'Swedish short' => ['1970-1-2', 'en_SE', '86400'],
            'Akan' => ['1970/01/02', 'ak_GH', '86400'],
            'Arabic' => ['۲/۱/۱۹۷۰', 'ar', '86400'],
            'Belarus' => ['2.01.1970', 'ru_BY', '86400'],
            'Magento custom format' => ['2/01/1970', 'ar_SA', '86400'],
        ];
    }
}
