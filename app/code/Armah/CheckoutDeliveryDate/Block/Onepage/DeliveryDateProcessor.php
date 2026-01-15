<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Delivery Date for Magento 2 (System)
 */

namespace Armah\CheckoutDeliveryDate\Block\Onepage;

use Armah\CheckoutCore\Block\Onepage\LayoutWalker;
use Armah\CheckoutCore\Block\Onepage\LayoutWalkerFactory;
use Armah\CheckoutCore\Model\Config;
use Armah\CheckoutDeliveryDate\Model\ConfigProvider;
use Armah\CheckoutDeliveryDate\Model\DeliveryDateProvider;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Additional Layout processor with all private and dynamic data
 */
class DeliveryDateProcessor implements LayoutProcessorInterface
{
    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var Config
     */
    private $checkoutConfig;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var DeliveryDateProvider
     */
    private $deliveryProvider;

    /**
     * @var LayoutWalker
     */
    private $walker;

    /**
     * @var LayoutWalkerFactory
     */
    private $walkerFactory;

    public function __construct(
        TimezoneInterface $timezone,
        CheckoutSession $checkoutSession,
        Config $checkoutConfig,
        ConfigProvider $configProvider,
        DeliveryDateProvider $deliveryProvider,
        LayoutWalkerFactory $walkerFactory
    ) {
        $this->timezone = $timezone;
        $this->checkoutSession = $checkoutSession;
        $this->checkoutConfig = $checkoutConfig;
        $this->configProvider = $configProvider;
        $this->deliveryProvider = $deliveryProvider;
        $this->walkerFactory = $walkerFactory;
    }

    /**
     * @param array $jsLayout
     * @return array
     */
    public function process($jsLayout)
    {
        if (!$this->checkoutConfig->isEnabled()) {
            return $jsLayout;
        }
        $this->walker = $this->walkerFactory->create(['layoutArray' => $jsLayout]);

        if (!$this->configProvider->isDeliveryDateEnabled()
            || $this->checkoutSession->getQuote()->isVirtual()
        ) {
            $this->walker->unsetByPath('{ARCHECKOUT_DELIVERY_DATE}');
        } else {
            $this->processDDConfiguration();
            $this->processDDQuoteData();
        }

        return $this->walker->getResult();
    }

    private function processDDConfiguration(): void
    {
        $this->walker->setValue(
            '{ARCHECKOUT_DELIVERY_DATE}.>>.date.archeckout_days',
            $this->configProvider->getDeliveryDays()
        );

        $this->walker->setValue(
            '{ARCHECKOUT_DELIVERY_DATE}.>>.date.options.dateFormat',
            $this->timezone->getDateFormat()
        );

        $this->walker->setValue(
            '{ARCHECKOUT_DELIVERY_DATE}.>>.date.archeckout_firstDay',
            $this->configProvider->getFirstDay()
        );

        if ($this->configProvider->isDeliveryDateRequired()) {
            $this->walker->setValue(
                '{ARCHECKOUT_DELIVERY_DATE}.>>.date.validation.required-entry',
                'true'
            );
        }

        $this->walker->setValue('{ARCHECKOUT_DELIVERY_DATE}.>>.date.required-entry', true);
        $this->walker->setValue(
            '{ARCHECKOUT_DELIVERY_DATE}.>>.time.options',
            $this->configProvider->getDeliveryHours()
        );

        if (!$this->configProvider->isCommentEnabled()) {
            $this->walker->unsetByPath('{ARCHECKOUT_DELIVERY_DATE}.>>.comment');
        } else {
            $comment = $this->configProvider->getDefaultComment();
            $this->walker->setValue('{ARCHECKOUT_DELIVERY_DATE}.>>.comment.placeholder', $comment);
        }
    }

    private function processDDQuoteData(): void
    {
        $delivery = $this->deliveryProvider->findByQuoteId((int)$this->checkoutSession->getQuoteId());

        $archeckoutDelivery = [
            'date' => $delivery->getDate(),
            'time' => $delivery->getTime(),
            'comment' => $delivery->getComment(),
        ];
        $this->walker->setValue('components.checkoutProvider.archeckoutDelivery', $archeckoutDelivery);
    }
}
