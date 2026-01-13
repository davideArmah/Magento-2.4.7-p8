<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Rich Snippets for Magento 2
 */

namespace Armah\SeoRichData\Model\Backend\Product;

use Magento\Framework\App\Config\Value as ConfigValue;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Module\Manager as ModuleManager;

class YotpoReviews extends ConfigValue
{
    /**
     * @return YotpoReviews
     * @throws LocalizedException
     */
    public function beforeSave(): YotpoReviews
    {
        if ($this->isValueChanged()
            && $this->getValue()
            && !$this->getModuleManager()->isEnabled('Armah_SeoRichDataYotpo')
        ) {
            throw new LocalizedException(__(
                'Enable armah/module-seo-rich-data-yotpo module to use product reviews from Yotpo in rich data.'
                . ' '
                . 'Please, run the following command in the SSH: composer require armah/module-seo-rich-data-yotpo'
            ));
        }

        return parent::beforeSave();
    }

    private function getModuleManager(): ModuleManager
    {
        return $this->getData('module_manager');
    }
}
