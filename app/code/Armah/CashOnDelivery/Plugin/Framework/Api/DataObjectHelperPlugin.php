<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cash on Delivery for Magento 2
 */

namespace Armah\CashOnDelivery\Plugin\Framework\Api;

use Armah\CashOnDelivery\Plugin\Cart\CartTotalRepositoryPlugin;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Registry;
use Magento\Quote\Api\Data\TotalsInterface;

class DataObjectHelperPlugin
{
    /**
     * @var Registry
     */
    private $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * resolve fatal
     *
     * @see CartTotalRepositoryPlugin::beforeGet
     *
     * @param DataObjectHelper $subject
     * @param object $dataObject
     * @param array $data
     * @param string $interfaceName
     *
     * @return array
     * @codingStandardsIgnoreStart
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforePopulateWithArray(
        DataObjectHelper $subject,
        $dataObject,
        array $data,
        $interfaceName
    ) {
        if (is_a($interfaceName, TotalsInterface::class, true)
            && $this->registry->registry(CartTotalRepositoryPlugin::REGISTRY_IGNORE_EXTENSION_ATTRIBUTES_KEY)
        ) {
            unset($data[ExtensibleDataInterface::EXTENSION_ATTRIBUTES_KEY]);
        }

        return [$dataObject, $data, $interfaceName];
    }
}
