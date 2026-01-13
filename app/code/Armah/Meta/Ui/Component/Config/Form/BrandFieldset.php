<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Ui\Component\Config\Form;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Module\Manager;

class BrandFieldset extends Fieldset
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Manager
     */
    private $moduleManager;

    public function __construct(
        ContextInterface $context,
        StoreManagerInterface $storeManager,
        Manager $moduleManager,
        array $components = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $components, $data);
    }

    public function prepare()
    {
        if (!$this->moduleManager->isEnabled('Armah_ShopbyBrand')) {
            $this->_data['config']['componentDisabled'] = true;
        } else {
            foreach ($this->storeManager->getStores() as $store) {
                $this->_data['config']['defaultCategories'][] = $store->getRootCategoryId();
            }
        }

        parent::prepare();
    }
}
