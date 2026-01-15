<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model\Source;

/**
 * Class Methods
 */
class Methods implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Armah\Sorting\Model\MethodProvider
     */
    private $methodProvider;

    public function __construct(
        \Armah\Sorting\Model\MethodProvider $methodProvider
    ) {
        $this->methodProvider = $methodProvider;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];

        foreach ($this->methodProvider->getMethods() as $methodObject) {
            $options[] = [
                'value' => $methodObject->getMethodCode(),
                'label' => $methodObject->getMethodName()
            ];
        }

        return $options;
    }
}
