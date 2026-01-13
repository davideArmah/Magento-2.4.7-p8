<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Test\Unit\Traits;

/**
 * Create Object Manager instance for test purposes.
 *
 * phpcs:ignoreFile
 */
trait ObjectManagerTrait
{
    /**
     * @var \Magento\Framework\TestFramework\Unit\Helper\ObjectManager
     */
    private $objectManager;

    /**
     * @return \Magento\Framework\TestFramework\Unit\Helper\ObjectManager
     */
    private function getObjectManager()
    {
        if (!$this->objectManager) {
            $this->objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        }

        return $this->objectManager;
    }
}
