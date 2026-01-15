<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Module\Manager;

class CustomTabs implements OptionSourceInterface
{
    /**
     * @var Manager
     */
    private $moduleManager;

    public function __construct(
        Manager $moduleManager
    ) {
        $this->moduleManager = $moduleManager;
    }

    public function toOptionArray(): array
    {
        $optionArray = [];
        foreach ($this->toArray() as $value => $label) {
            $optionArray[] = [
                'value' => $value,
                'label' => $label
            ];
        }

        return $optionArray;
    }

    public function toArray(): array
    {
        if ($this->moduleManager->isEnabled('Armah_CustomTabs')
            && $this->moduleManager->isEnabled('Armah_CrossLinkingCustomTabsReference')
        ) {
            $result = [
                0 => __('No'),
                1 => __('Yes')
            ];
        } else {
            $result = [
                0 => __('No (Module was not installed)')
            ];
        }

        return $result;
    }
}
