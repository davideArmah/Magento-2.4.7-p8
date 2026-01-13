<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model;

use Armah\CheckoutCore\Model\Config;

class Color
{
    /**
     * @var \Less_Functions
     */
    private $less;

    /**
     * @var \Less_Tree_Dimension
     */
    private $darken;

    /**
     * @var Config
     */
    private $configProvider;

    public function __construct(
        Config $configProvider
    ) {
        $this->configProvider = $configProvider;
        $this->less = new \Less_Functions(null);
        $this->darken = new \Less_Tree_Dimension(10, '%');
    }

    /**
     * @return array|bool
     * @throws \Less_Exception_Compiler
     */
    public function getButtonColor()
    {
        $colorCode = $this->configProvider->getRgbSetting(Config::DESIGN_BLOCK . 'button_color');

        if ($colorCode) {
            $color = new \Less_Tree_Color(ltrim($colorCode, '#'));

            $hoverColor = $this->less->darken($color, $this->darken);

            return [
                'normal' => $colorCode,
                'hover' => $hoverColor->toRGB()
            ];
        }

        return false;
    }

    /**
     * @return bool|string
     */
    public function getHeadingTextColor()
    {
        return $this->configProvider->getRgbSetting(Config::DESIGN_BLOCK . 'heading_color');
    }

    /**
     * @return bool|string
     */
    public function getSummaryBackgroundColor()
    {
        return $this->configProvider->getRgbSetting(Config::DESIGN_BLOCK . 'summary_color');
    }

    /**
     * @return bool|string
     */
    public function getBackgroundColor()
    {
        return $this->configProvider->getRgbSetting(Config::DESIGN_BLOCK . 'bg_color');
    }
}
