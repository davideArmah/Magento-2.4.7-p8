<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Observer\Adminhtml;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\DesignInterface;
use Magento\Framework\View\Page\Config;

/**
 * adminhtml observer
 * event layout_load_before
 * observer name Armah_Base::MarkAdminTheme
 * @since 1.21.0
 */
class MarkAdminTheme implements ObserverInterface
{
    /**
     * @var DesignInterface
     */
    private DesignInterface $design;

    /**
     * @var Config
     */
    private Config $pageConfig;

    public function __construct(
        DesignInterface $design,
        Config $pageConfig
    ) {
        $this->design = $design;
        $this->pageConfig = $pageConfig;
    }

    public function execute(Observer $observer): void
    {
        switch ($this->design->getDesignTheme()->getCode()) {
            case 'Hyva/commerce':
                $this->pageConfig->addBodyClass('am-hyvacomm-compat');
            // no break because hyva extends MageOS
            case 'MageOS/m137-admin-theme':
                $this->pageConfig->addBodyClass('am-mageos-compat');
                break;
        }
    }
}
