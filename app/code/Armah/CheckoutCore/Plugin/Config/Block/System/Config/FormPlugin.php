<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Config\Block\System\Config;

use Armah\CheckoutCore\Block\Adminhtml\System\Config\Expander;
use Magento\Config\Block\System\Config\Form;

class FormPlugin
{
    /**
     * @param Form $subject
     * @param string $result
     * @return string
     */
    public function afterToHtml(Form $subject, $result)
    {
        if ($subject->getRequest()->getParam('expand')) {
            $layout = $subject->getLayout();
            $blockExpander = $layout->createBlock(Expander::class);
            $result = $result . $blockExpander->toHtml();
        }

        return $result;
    }
}
