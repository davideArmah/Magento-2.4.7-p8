<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Framework\View\Page\Config\Renderer;

use Armah\CheckoutCore\Model\Config as ConfigProvider;
use Magento\Framework\View\Page\Config\Renderer;

class DisableJsMixins
{
    /**
     * @var ConfigProvider
     */
    private ConfigProvider $checkoutConfig;

    public function __construct(
        ConfigProvider $checkoutConfig
    ) {
        $this->checkoutConfig = $checkoutConfig;
    }

    /**
     * Disable Amasty OSC js mixins if module is disabled.
     *
     * Script hash in csp_whitelist.
     * Script should be executed before requirejs-config.js.
     * Don't use renderHeadAssets for compatibility, it comes with 2.4.8
     *
     * @param Renderer $subject
     * @param string $result
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterRenderHeadContent(Renderer $subject, string $result): string
    {
        if (!$this->checkoutConfig->isEnabled()) {
            $result = '<script type="text/javascript">window.armah_checkout_disabled=true;</script>' . $result;
        }

        return $result;
    }
}
