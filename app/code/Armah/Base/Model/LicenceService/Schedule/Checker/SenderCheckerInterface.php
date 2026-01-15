<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\LicenceService\Schedule\Checker;

interface SenderCheckerInterface
{
    /**
     * @param string $flag
     * @return bool
     */
    public function isNeedToSend(string $flag): bool;
}
