<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Optimization;

use Armah\CheckoutCore\Model\Config;
use Magento\Framework\View\LayoutInterface;

class BundleService implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    public const COLLECT_SCRIPT_PATH = 'Armah_CheckoutCore/js/action/create-js-bundle';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var LayoutInterface
     */
    private $layout;

    /**
     * Flag is bundle file loaded (available)
     *
     * @var bool
     */
    private $bundleLoaded = false;

    public function __construct(Config $config, LayoutInterface $layout)
    {
        $this->config = $config;
        $this->layout = $layout;
    }

    /**
     * Is script which collecting bundle file can be initiated.
     *
     * @return bool
     */
    public function canCollectBundle()
    {
        return !$this->bundleLoaded && $this->isEnabled();
    }

    /**
     * @return bool
     */
    public function canLoadBundle()
    {
        return $this->isEnabled() && in_array('armah_checkout', $this->layout->getUpdate()->getHandles());
    }

    public function setBundleLoaded()
    {
        $this->bundleLoaded = true;
    }

    /**
     * @return bool
     */
    private function isEnabled()
    {
        return $this->config->isEnabled() && $this->config->isJsBundleEnabled();
    }
}
