<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Plugin\Config\Block\System\Config\Edit;

use Armah\Base\Block\Adminhtml\InstanceRegistrationMessages;
use Magento\Config\Block\System\Config\Edit;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\LayoutInterface;

class RemoveSaveButton
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSetLayout(Edit $subject, Edit $result, LayoutInterface $layout): Edit
    {
        if ($subject->getRequest()->getParam('section') === InstanceRegistrationMessages::SECTION_NAME) {
            /** @var AbstractBlock $toolbar */
            $toolbar = $subject->getToolbar();
            if ($toolbar) {
                $toolbar->unsetChild('save_button');
            }
        }

        return $result;
    }
}
