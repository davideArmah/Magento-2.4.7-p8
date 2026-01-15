<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Rich Snippets for Magento 2
 */

namespace Armah\SeoRichData\Model\Source;

use Magento\Framework\Option\ArrayInterface;

class Breadcrumbs implements ArrayInterface
{
    public const TYPE_LONG = 0;
    public const TYPE_SHORT = 1;

    public function toOptionArray()
    {
        return [
            self::TYPE_LONG => __('Default (Long)'),
            self::TYPE_SHORT => __('Short'),
        ];
    }
}
