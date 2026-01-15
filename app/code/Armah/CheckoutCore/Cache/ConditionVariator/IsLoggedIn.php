<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Cache\ConditionVariator;

use Armah\CheckoutCore\Api\CacheKeyPartProviderInterface;

/**
 * Add cache variation for logged customer and guest
 */
class IsLoggedIn implements CacheKeyPartProviderInterface
{
    /**
     * @var \Magento\Framework\App\Http\Context
     */
    private $httpContext;

    public function __construct(\Magento\Framework\App\Http\Context $httpContext)
    {
        $this->httpContext = $httpContext;
    }

    /**
     * @return string
     */
    public function getKeyPart()
    {
        if ($this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH)) {
            return 'logged';
        }

        return 'guest';
    }
}
