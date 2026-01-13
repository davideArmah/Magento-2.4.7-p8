<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Entity\Adapter\Order\Plugin\Admin;

use Armah\Orderattr\Model\Entity\Adapter\Order\Admin\CreateProcessor;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Model\AdminOrder\Create;

class CreateOrderPlugin
{
    /**
     * @var CreateProcessor
     */
    private $createProcessor;

    public function __construct(
        CreateProcessor $createProcessor
    ) {
        $this->createProcessor = $createProcessor;
    }

    /**
     * @param Create $subject
     * @param array $data
     * @return void
     * @throws LocalizedException
     */
    public function beforeImportPostData(Create $subject, array $data): void
    {
        $this->createProcessor->processAttributesDataFromAdminForm(
            $subject->getQuote(),
            $subject->getSession()->getStore(),
            $data
        );
    }
}
