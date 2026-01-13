<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Cache\ConditionVariator;

/**
 * Add cache variation for virtual quote.
 */
class IsVirtual implements \Armah\CheckoutCore\Api\CacheKeyPartProviderInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    public function __construct(\Magento\Checkout\Model\Session $checkoutSession)
    {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @return string
     */
    public function getKeyPart()
    {
        if ($this->checkoutSession->getQuote()->isVirtual()) {
            return 'virtual';
        }

        return 'virtual=fls';
    }
}
