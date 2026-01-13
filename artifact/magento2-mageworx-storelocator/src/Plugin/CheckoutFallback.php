<?php declare(strict_types=1);
/**
 * Copyright © MageWorx. All rights reserved.
 * See https://www.mageworx.com/terms-and-conditions for license details.
 */

namespace Hyva\MageWorxStoreLocator\Plugin;

use Hyva\ThemeFallback\Config\ThemeFallback;
use Magento\Framework\App\RequestInterface;

class CheckoutFallback
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    public function __construct(
        RequestInterface $request
    ) {
        $this->request = $request;
    }

    public function afterGetListPartOfUrl(ThemeFallback $subject, $urlPaths)
    {
        $actionName = $this->request->getFullActionName();

        if (
            $actionName === 'mageworx_store_locator_location_searchLocations' ||
            $actionName === 'mageworx_store_locator_location_locationdetail'
        ) {
            $urlPaths[] = 'current_page=checkout_index_index';
        }
        
        return $urlPaths;
    }
}
