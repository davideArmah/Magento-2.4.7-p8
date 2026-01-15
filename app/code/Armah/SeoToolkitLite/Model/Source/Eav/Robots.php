<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Model\Source\Eav;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Robots extends AbstractSource
{
    public const DEFAULT = 'default';
    public const ROBOTS_INDEX_FOLLOW = 'index,follow';
    public const ROBOTS_NOINDEX_FOLLOW = 'noindex,follow';
    public const ROBOTS_INDEX_NOFOLLOW = 'index,nofollow';
    public const ROBOTS_NOINDEX_NOFOLLOW = 'noindex,nofollow';

    /**
     * @return array
     */
    public function getAllOptions(): array
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => self::DEFAULT, 'label' => __('Default')],
                ['value' => self::ROBOTS_INDEX_FOLLOW, 'label' => __('INDEX, FOLLOW')],
                ['value' => self::ROBOTS_NOINDEX_FOLLOW, 'label' => __('NOINDEX, FOLLOW')],
                ['value' => self::ROBOTS_INDEX_NOFOLLOW, 'label' => __('INDEX, NOFOLLOW')],
                ['value' => self::ROBOTS_NOINDEX_NOFOLLOW, 'label' => __('NOINDEX, NOFOLLOW')]
            ];
        }

        return $this->_options;
    }
}
