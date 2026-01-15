<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Plugin\AdminNotification\Block;

use Magento\AdminNotification\Block\ToolbarEntry as NativeToolbarEntry;

/**
 * Add html attributes to armah notifications
 */
class ToolbarEntry
{
    public const ARMAH_ATTRIBUTE = ' data-arbase-logo="1"';

    public function afterToHtml(
        NativeToolbarEntry $subject,
        $html
    ) {
        $collection = $subject->getLatestUnreadNotifications()
            ->clear()
            ->addFieldToFilter('is_armah', 1);

        foreach ($collection as $item) {
            $search = 'data-notification-id="' . $item->getId() . '"';
            if ($item->getData('image_url')) {
                $html = str_replace(
                    $search,
                    $search . ' style='
                    . '"background: url(' . $item->getData('image_url') . ') no-repeat 5px 7px; background-size: 30px;"'
                    . self::ARMAH_ATTRIBUTE,
                    $html
                );
            } else {
                $html = str_replace($search, $search . self::ARMAH_ATTRIBUTE, $html);
            }
        }

        return $html;
    }
}
