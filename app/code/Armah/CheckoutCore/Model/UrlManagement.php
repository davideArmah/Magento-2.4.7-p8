<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model;

use Magento\Backend\Model\Url;

class UrlManagement extends Url
{
    /**
     * @inheritdoc
     */
    public function getUrl($routePath = null, $routeParams = null)
    {
        $this->getRouteParamsResolver()->unsetData('route_params');

        return parent::getUrl($routePath, $routeParams);
    }
}
