<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout for Magento 2
 */

namespace Armah\Checkout\Plugin\Base\Model\ModuleInfoProvider;

use Armah\Base\Model\ModuleInfoProvider;
use Magento\Framework\App\RequestInterface;

class ReplaceModuleInfo
{
    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        RequestInterface $request
    ) {
        $this->request = $request;
    }
    /**
     * @param ModuleInfoProvider $subject
     * @param string $moduleCode
     * @return array|string[]
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeGetModuleInfo(ModuleInfoProvider $subject, string $moduleCode)
    {
        if ($moduleCode === 'Armah_CheckoutCore' && $this->request->getParam('section') === 'armah_checkout') {
            $moduleCode = 'Armah_Checkout';
        }

        return [$moduleCode];
    }
}
