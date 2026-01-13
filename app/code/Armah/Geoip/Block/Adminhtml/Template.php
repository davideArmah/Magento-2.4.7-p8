<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Block\Adminhtml;

class Template extends \Magento\Backend\Block\Template
{
    /**
     * @var \Armah\Geoip\Helper\Data
     */
    public $geoipHelper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Armah\Geoip\Helper\Data $geoipHelper
    ) {
        parent::__construct($context);

        $this->geoipHelper = $geoipHelper;
    }
}
