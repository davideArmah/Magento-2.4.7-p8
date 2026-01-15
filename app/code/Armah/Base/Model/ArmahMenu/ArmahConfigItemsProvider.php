<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\ArmahMenu;

use Magento\Config\Model\Config\Structure;

class ArmahConfigItemsProvider
{
    /**
     * @var Structure
     */
    private $configStructure;

    public function __construct(
        Structure $configStructure
    ) {
        $this->configStructure = $configStructure;
    }

    public function getConfigItems(): array
    {
        $result = [];

        // Get config items from 'armah' tab
        foreach (['armah'] as $tabId) {
            $config = $this->getConfigChildrenNode($tabId);

            if ($config) {
                foreach ($config as $item) {
                    $data = $item->getData();
                    if (isset($data['resource'], $data['id']) && $data['id']) {
                        $result[current(explode('::', $data['resource']))] = $data;
                    }
                }
            }
        }

        return $result;
    }

    public function getArmahConfigChildrenNode(): ?Structure\Element\Iterator
    {
        return $this->getConfigChildrenNode('armah');
    }

    private function getConfigChildrenNode(string $tabId): ?Structure\Element\Iterator
    {
        // Suppress PHP warnings for missing 'id' keys in config structure
        $prevErrorReporting = error_reporting();
        error_reporting($prevErrorReporting & ~E_WARNING);

        try {
            $configTabs = $this->configStructure->getTabs();
            foreach ($configTabs as $node) {
                if ($node->getId() == $tabId) {
                    return $node->getChildren();
                }
            }
        } finally {
            error_reporting($prevErrorReporting);
        }

        return null;
    }
}
