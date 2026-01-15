<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Cache\ConditionVariator;

use Armah\CheckoutCore\Api\CacheKeyPartProviderInterface;

/**
 * Add cache variation for each customer group
 */
class CustomerGroup implements CacheKeyPartProviderInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    public function __construct(\Magento\Customer\Model\Session $customerSession)
    {
        $this->customerSession = $customerSession;
    }

    /**
     * @return string
     */
    public function getKeyPart()
    {
        return 'cusGroup=' . $this->customerSession->getCustomerGroupId();
    }
}
