<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Armah Improved Sorting GraphQl for Magento 2 (System)
 */

namespace Armah\SortingGraphQl\Plugin\Sorting\Model\Method\GetAttributeCodesForSorting;

use Armah\Sorting\Model\Method\GetAttributeCodesForSorting;
use Armah\SortingGraphQl\Model\MethodProvider\CodeMap;

class DisableCodeMap
{
    /**
     * @var CodeMap
     */
    private $codeMap;

    public function __construct(CodeMap $codeMap)
    {
        $this->codeMap = $codeMap;
    }

    /**
     * @see GetAttributeCodesForSorting::execute
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundExecute(GetAttributeCodesForSorting $subject, callable $proceed)
    {
        $codeMap = $this->codeMap->getMap();

        $this->codeMap->setMap(null);
        $result = $proceed();
        $this->codeMap->setMap($codeMap);

        return $result;
    }
}
