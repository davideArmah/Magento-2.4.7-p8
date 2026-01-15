<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Model;

use Armah\Base\Model\ConfigProviderAbstract;

class ConfigProvider extends ConfigProviderAbstract
{
    /**
     * @var string '{section}/'
     */
    protected $pathPrefix = 'armeta/';

    private const ARMETA_PRODUCT_URL_TEMPLATE = 'product/url_template';
    private const ARMETA_AUTOMATICALLY_MODIFY_URL_KEY = 'product/automatically_modify_url_key';

    /**
     * @param int|null $storeId
     * @return string
     */
    public function getProductTemplate(?int $storeId = null): string
    {
        $urlTemplate = $this->getValue(self::ARMETA_PRODUCT_URL_TEMPLATE, $storeId);

        return trim((string)$urlTemplate);
    }

    /**
     * @param int|null $storeId
     * @return bool
     */
    public function isAutomaticallyModifyUrlKey(?int $storeId = null): bool
    {
        return (bool)$this->getValue(self::ARMETA_AUTOMATICALLY_MODIFY_URL_KEY, $storeId);
    }
}
