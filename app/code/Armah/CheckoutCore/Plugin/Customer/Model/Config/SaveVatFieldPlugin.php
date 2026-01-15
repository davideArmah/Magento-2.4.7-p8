<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Customer\Model\Config;

use Armah\CheckoutCore\Model\Field\ConfigManagement\ConfigToField\ProcessConfigValue;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;

class SaveVatFieldPlugin
{
    public const CONFIG_PATH = 'customer/create_account/vat_frontend_visibility';

    /**
     * @var ProcessConfigValue
     */
    private $processConfigValue;

    public function __construct(ProcessConfigValue $processConfigValue)
    {
        $this->processConfigValue = $processConfigValue;
    }

    /**
     * @param Value $configValue
     * @return Value
     * @throws AlreadyExistsException
     * @throws NoSuchEntityException
     * @see Value::afterSave
     */
    public function afterAfterSave(Value $configValue): Value
    {
        if ($configValue->getPath() !== self::CONFIG_PATH
            || $configValue->getScope() === ScopeInterface::SCOPE_STORES
        ) {
            return $configValue;
        }

        $websiteId = $configValue->getScope() === ScopeInterface::SCOPE_WEBSITES ?
            (int) $configValue->getScopeId() :
            null;

        $this->processConfigValue->execute($configValue, $configValue->getValue(), $websiteId);

        return $configValue;
    }
}
