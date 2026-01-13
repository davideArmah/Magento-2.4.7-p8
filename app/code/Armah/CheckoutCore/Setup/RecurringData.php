<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Setup;

use Armah\CheckoutCore\Setup\Operation\AddAttributesToManageCheckoutFields;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class RecurringData implements InstallDataInterface
{
    /**
     * @var AddAttributesToManageCheckoutFields
     */
    private $addAttributesToManageCheckoutFields;

    public function __construct(
        AddAttributesToManageCheckoutFields $addAttributesToManageCheckoutFields
    ) {
        $this->addAttributesToManageCheckoutFields = $addAttributesToManageCheckoutFields;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context): void
    {
        $this->addAttributesToManageCheckoutFields->execute();
    }
}
