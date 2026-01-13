<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Plugin\AdminNotification\Block\Grid\Renderer;

use Magento\AdminNotification\Block\Grid\Renderer\Notice as NativeNotice;
use Magento\Framework\DataObject;

class Notice
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterRender(NativeNotice $subject, string $result, DataObject $row): string
    {
        $armahLogo = $armahImage = '';
        if ($row->getData('is_armah')) {
            if ($row->getData('image_url')) {
                $armahImage = ' style="background: url(' . $row->getData("image_url") . ') no-repeat;"';
            } else {
                $armahLogo = ' armah-grid-logo';
            }
        }

        return '<div class="arbase-grid-message' . $armahLogo . '"' . $armahImage . '>' . $result . '</div>';
    }
}
