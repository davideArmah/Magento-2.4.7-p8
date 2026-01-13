<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) 2023 Amasty (https://www.armah.it)
 * @package One Step Checkout Gift Wrap for Magento 2 (System)
 */

namespace Armah\CheckoutGiftWrap\Block\Onepage;

use Armah\CheckoutCore\Api\FeeRepositoryInterface;
use Armah\CheckoutCore\Block\Onepage\LayoutWalker;
use Armah\CheckoutCore\Block\Onepage\LayoutWalkerFactory;
use Armah\CheckoutCore\Model\Config;
use Armah\CheckoutGiftWrap\Model\ConfigProvider;
use Armah\CheckoutGiftWrap\Model\Messages;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\GiftMessage\Model\Message;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Additional Layout processor with all private and dynamic data
 */
class GiftWrapProcessor implements LayoutProcessorInterface
{
    /**
     * @var Messages
     */
    private $giftMessages;

    /**
     * @var Config
     */
    private $checkoutConfig;

    /**
     * @var LayoutWalker
     */
    private $walker;

    /**
     * @var LayoutWalkerFactory
     */
    private $walkerFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var PriceCurrencyInterface
     */
    private $priceCurrency;

    /**
     * @var FeeRepositoryInterface
     */
    private $feeRepository;

    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(
        Messages $giftMessages,
        Config $checkoutConfig,
        LayoutWalkerFactory $walkerFactory,
        StoreManagerInterface $storeManager,
        PriceCurrencyInterface $priceCurrency,
        FeeRepositoryInterface $feeRepository,
        CheckoutSession $checkoutSession,
        ConfigProvider $configProvider
    ) {
        $this->giftMessages = $giftMessages;
        $this->checkoutConfig = $checkoutConfig;
        $this->walkerFactory = $walkerFactory;
        $this->storeManager = $storeManager;
        $this->priceCurrency = $priceCurrency;
        $this->feeRepository = $feeRepository;
        $this->checkoutSession = $checkoutSession;
        $this->configProvider = $configProvider;
    }

    /**
     * Gift Wrap and Gift Messages processor
     */
    public function process($jsLayout)
    {
        if (!$this->checkoutConfig->isEnabled()) {
            return $jsLayout;
        }
        $this->walker = $this->walkerFactory->create(['layoutArray' => $jsLayout]);

        $this->processGiftWrap();
        $this->processGiftMessage();

        return $this->walker->getResult();
    }

    /**
     * Gift Wrap processor
     *
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function processGiftWrap()
    {
        if (!$this->configProvider->isGiftWrapEnabled() || $this->configProvider->isGiftWrapModuleEnabled()) {
            $this->walker->unsetByPath('{GIFT_WRAP}');
        } else {
            $amount = $this->configProvider->getGiftWrapFee();

            $rate = $this->storeManager->getStore()->getBaseCurrency()->getRate(
                $this->storeManager->getStore()->getCurrentCurrency()
            );

            $amount *= $rate;

            $formattedPrice = $this->priceCurrency->format($amount, false);

            $this->walker->setValue('{GIFT_WRAP}.description', __('Gift wrap %1', $formattedPrice));
            $this->walker->setValue('{GIFT_WRAP}.fee', $amount);

            $fee = $this->feeRepository->getByQuoteId($this->checkoutSession->getQuoteId());

            if ($fee->getId()) {
                $this->walker->setValue('{GIFT_WRAP}.checked', true);
            }
        }
    }

    /**
     * Gift Messages processor
     *
     * @throws NoSuchEntityException
     */
    public function processGiftMessage()
    {
        if (empty($messages = $this->giftMessages->getGiftMessages())) {
            $this->walker->unsetByPath('{GIFT_MESSAGE_CONTAINER}');
        } else {
            $itemMessage = $quoteMessage = [
                'component' => 'uiComponent',
                'children' => [],
            ];
            $checked = false;

            /** @var Message $message */
            foreach ($messages as $key => $message) {
                if ($message->getId()) {
                    $checked = true;
                }

                $node = $message
                    ->setData('item_id', $key)
                    ->toArray(['item_id', 'sender', 'recipient', 'message', 'title']);

                $node['component'] = 'Armah_CheckoutGiftWrap/js/view/additional/gift-messages/message';
                if ($key) {
                    $itemMessage['children'][] = $node;
                } else {
                    $quoteMessage['children'][] = $node;
                }
            }
            $this->walker->setValue(
                '{GIFT_MESSAGE_CONTAINER}.config.popUpForm.options.messages',
                $this->translateTextForCheckout()
            );
            $this->walker->setValue('{GIFT_MESSAGE_CONTAINER}.>>.checkbox.checked', $checked);
            $this->walker->setValue('{GIFT_MESSAGE_CONTAINER}.>>.checkbox.checked', $checked);
            $this->walker->setValue('{GIFT_MESSAGE_CONTAINER}.>>.item_messages', $itemMessage);
            $this->walker->setValue('{GIFT_MESSAGE_CONTAINER}.>>.quote_message', $quoteMessage);
        }
    }

    /**
     * @return array
     */
    public function translateTextForCheckout(): array
    {
        $messages['gift'] = __('Gift messages has been successfully updated')->render();
        $messages['update'] = __('Update')->render();
        $messages['close'] = __('Close')->render();

        return $messages;
    }
}
