<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */
namespace Armah\Orderattr\Block\Adminhtml\Order\Create\Form\Attributes\Data;

use Magento\Framework\Data\Form as FrameworkForm;

class Form extends FrameworkForm
{
    /**
     * Escape suffix for file input
     *
     * @param string $suffix
     * @return $this
     */
    public function addFieldNameSuffix($suffix)
    {
        foreach ($this->_allElements as $element) {
            if ($element->getType() === 'file') {
                continue;
            }
            $name = $element->getName();
            if ($name) {
                $element->setName($this->addSuffixToName($name, $suffix));
            }
        }
        return $this;
    }
}
