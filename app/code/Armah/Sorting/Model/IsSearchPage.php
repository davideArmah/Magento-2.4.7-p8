<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model;

use Magento\Framework\App\RequestInterface;

class IsSearchPage
{
    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        return in_array(
            $this->request->getModuleName(),
            ['sqli_singlesearchresult', 'catalogsearch', 'armah_xsearch']
        );
    }
}
