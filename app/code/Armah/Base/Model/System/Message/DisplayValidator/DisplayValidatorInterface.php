<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\System\Message\DisplayValidator;

interface DisplayValidatorInterface
{
    public function needToShow(): bool;
}
