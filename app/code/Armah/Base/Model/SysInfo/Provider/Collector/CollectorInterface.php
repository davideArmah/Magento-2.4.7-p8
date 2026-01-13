<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.com)
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\SysInfo\Provider\Collector;

interface CollectorInterface
{
    /**
     * Uses to get information about system;
     * mixed because that data must be processed
     * in class that called group
     *
     * @return mixed
     */
    public function get();
}
