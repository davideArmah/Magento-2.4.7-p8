<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model\Source;

/**
 * Class TargetType
 * @package Armah\CrossLinks\Model\Source
 */
class Faq implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    private $moduleManager;

    public function __construct(
        \Magento\Framework\Module\Manager $moduleManager
    ) {
        $this->moduleManager = $moduleManager;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $optionArray = [];
        $arr = $this->toArray();
        foreach ($arr as $value => $label) {
            $optionArray[] = [
                'value' => $value,
                'label' => $label
            ];
        }
        return $optionArray;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        if ($this->moduleManager->isEnabled('Armah_Faq')) {
            $result = [0 => __('No'), 1 => __('Yes')];
        } else {
            $result = [0 => __('No (Module was not installed)')];
        }

        return $result;
    }
}
