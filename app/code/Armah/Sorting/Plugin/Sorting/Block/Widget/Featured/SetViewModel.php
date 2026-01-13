<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Plugin\Sorting\Block\Widget\Featured;

use Armah\Sorting\Block\Widget\Featured;
use Armah\Sorting\ViewModel\Helpers;

class SetViewModel
{
    /**
     * @var Helpers
     */
    private $helpers;

    public function __construct(Helpers $helpers)
    {
        $this->helpers = $helpers;
    }

    /**
     * @param Featured $featuredWidget
     */
    public function beforeToHtml(Featured $featuredWidget): void
    {
        $featuredWidget->setData('helpers', $this->helpers);
    }
}
