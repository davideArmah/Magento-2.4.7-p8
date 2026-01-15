<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Controller\Adminhtml\Link;

/**
 * Class NewAction
 * @package Armah\CrossLinks\Controller\Adminhtml\Link
 */
class NewAction extends \Armah\CrossLinks\Controller\Adminhtml\Link
{
    /**
     * Create new link
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
