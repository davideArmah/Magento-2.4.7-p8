<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Source;

use Armah\Sorting\Model\Plugin\Catalog\Config\DisplayAllFlag;
use Magento\Catalog\Model\Config;
use Magento\Framework\Data\OptionSourceInterface;

class AllSortingAttributes implements OptionSourceInterface
{
    /**
     * @var Config
     */
    private $catalogConfig;

    /**
     * @var DisplayAllFlag
     */
    private $displayAllFlag;

    public function __construct(Config $catalogConfig, DisplayAllFlag $displayAllFlag)
    {
        $this->catalogConfig = $catalogConfig;
        $this->displayAllFlag = $displayAllFlag;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $options = [];

        $this->displayAllFlag->set(true);
        $allAttributes = $this->catalogConfig->getAttributeUsedForSortByArray();
        $this->displayAllFlag->set(false);

        foreach ($allAttributes as $code => $label) {
            $options[] = [
                'label' => $label,
                'value' => $code
            ];
        }

        return $options;
    }
}
