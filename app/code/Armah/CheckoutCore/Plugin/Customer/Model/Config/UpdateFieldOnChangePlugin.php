<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Plugin\Customer\Model\Config;

use Armah\CheckoutCore\Model\Field\ConfigManagement\ConfigToField\ProcessDeletedConfigValue;
use Magento\Customer\Model\Config\Backend\Show\Customer as Subject;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class UpdateFieldOnChangePlugin
{
    /**
     * @var ProcessDeletedConfigValue
     */
    private $processDeletedConfigValue;

    public function __construct(ProcessDeletedConfigValue $processDeletedConfigValue)
    {
        $this->processDeletedConfigValue = $processDeletedConfigValue;
    }

    /**
     * @param Subject $configValue
     * @throws AlreadyExistsException
     * @throws NoSuchEntityException
     * @see Subject::afterDelete
     */
    public function afterAfterDelete(Subject $configValue): void
    {
        $this->processDeletedConfigValue->execute($configValue);
    }
}
