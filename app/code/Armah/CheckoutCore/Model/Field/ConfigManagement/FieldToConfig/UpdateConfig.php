<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field\ConfigManagement\FieldToConfig;

use Armah\CheckoutCore\Model\Field;
use Armah\CheckoutCore\Model\Field\ConfigManagement\FieldToConfig\Processor\ProcessorInterface;
use Magento\Config\Model\Config\Structure\SearchInterface;

class UpdateConfig
{
    /**
     * @var SearchInterface
     */
    private $systemConfigSearch;

    /**
     * @var GetAttributeCode
     */
    private $getAttributeCode;

    /**
     * @var ProcessorInterface[]
     */
    private $processors;

    /**
     * @var array<string, string>
     */
    private $configPaths;

    /**
     * @param SearchInterface $systemConfigSearch
     * @param GetAttributeCode $getAttributeCode
     * @param ProcessorInterface[] $processors
     * @param array<string, string> $configPaths
     */
    public function __construct(
        SearchInterface $systemConfigSearch,
        GetAttributeCode $getAttributeCode,
        array $processors = [],
        array $configPaths = []
    ) {
        $this->systemConfigSearch = $systemConfigSearch;
        $this->getAttributeCode = $getAttributeCode;
        $this->processors = $processors;
        $this->configPaths = $configPaths;
    }

    /**
     * @param Field $field
     * @return void
     * @SuppressWarnings(PHPMD.MissingImport)
     */
    public function execute(Field $field): void
    {
        if (empty($this->processors)) {
            return;
        }

        foreach ($this->processors as $processor) {
            if (!$processor instanceof ProcessorInterface) {
                throw new \InvalidArgumentException(
                    sprintf('Processor must implement %s', ProcessorInterface::class)
                );
            }
        }

        $attributeCode = $this->getAttributeCode->execute($field);
        if (!$attributeCode) {
            return;
        }

        $configPath = $this->getConfigPath($attributeCode);
        $configElement = $this->systemConfigSearch->getElement($configPath);
        if (!$configElement) {
            return;
        }

        if (!isset($configElement->getData()['source_model'])) {
            return;
        }

        $sourceModel = $configElement->getData()['source_model'];
        if (isset($this->processors[$sourceModel])) {
            $this->processors[$sourceModel]->execute($field, $configPath);
        }
    }

    private function getConfigPath(string $attributeCode): string
    {
        return $this->configPaths[$attributeCode] ?? sprintf('customer/address/%s_show', $attributeCode);
    }
}
