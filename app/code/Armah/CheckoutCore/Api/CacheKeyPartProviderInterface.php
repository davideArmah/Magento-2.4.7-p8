<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Api;

/**
 * Cache variator interface.
 * Return cache key/identifier part.
 * @since 3.0.0
 */
interface CacheKeyPartProviderInterface
{
    /**
     * @return string
     */
    public function getKeyPart();
}
