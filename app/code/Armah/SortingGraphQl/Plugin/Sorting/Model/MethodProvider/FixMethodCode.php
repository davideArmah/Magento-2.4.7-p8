<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Armah Improved Sorting GraphQl for Magento 2 (System)
 */

namespace Armah\SortingGraphQl\Plugin\Sorting\Model\MethodProvider;

use Armah\Sorting\Model\MethodProvider;
use Armah\SortingGraphQl\Model\MethodProvider\CodeMap;

class FixMethodCode
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
     * Need in case when we replace order code in criteria for correct elastic search.
     *
     * @see MethodProvider::getMethodByCode
     *
     * @param MethodProvider $subject
     * @param string $code
     * @return array
     */
    public function beforeGetMethodByCode(MethodProvider $subject, string $code): array
    {
        if ($originalCode = $this->codeMap->get($code)) {
            $code = $originalCode;
        }

        return [$code];
    }
}
