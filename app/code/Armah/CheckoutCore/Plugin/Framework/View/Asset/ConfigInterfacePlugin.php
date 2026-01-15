<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Framework\View\Asset;

class ConfigInterfacePlugin
{
    /**
     * @var \Armah\CheckoutCore\Model\Optimization\BundleService
     */
    private $bundleService;

    public function __construct(\Armah\CheckoutCore\Model\Optimization\BundleService $bundleService)
    {
        $this->bundleService = $bundleService;
    }

    /**
     * Force enable bundling for checkout
     *
     * @param \Magento\Framework\View\Asset\ConfigInterface $subject
     * @param bool $result
     *
     * @return bool
     */
    public function afterIsBundlingJsFiles(\Magento\Framework\View\Asset\ConfigInterface $subject, $result)
    {
        if (!$result && $this->bundleService->canLoadBundle()) {
            return true;
        }

        return $result;
    }
}
