<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model\Source;

use Magento\Framework\Option\ArrayInterface;

class ReferenceType implements ArrayInterface
{
    public const REFERENCE_TYPE_CUSTOM   = 0;
    public const REFERENCE_TYPE_PRODUCT  = 1;
    public const REFERENCE_TYPE_CATEGORY = 2;

    /**
     * @var array
     */
    private $options;

    public function __construct(
        array $options
    ) {
        $this->options = $options;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $array = [];
        foreach ($this->options as $label => $value) {
            $array[] = ['value' => $value, 'label' => $label];
        }

        return $array;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];
        foreach ($this->options as $label => $value) {
            $array[$value] = $label;
        }

        return $array;
    }
}
