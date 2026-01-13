<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Plugin\Backend\Model\Config;

use Armah\Base\Block\Adminhtml\System\Config\Information;
use Magento\Config\Model\Config\ScopeDefiner;
use Magento\Config\Model\Config\Structure;
use Magento\Config\Model\Config\Structure\Element\Section;
use Magento\Config\Model\Config\StructureElementInterface;

class AddInformationBlockPlugin
{
    /**
     * Tab name
     */
    public const ARMAH_TAB_NAME = 'armah';

    /**
     * @var ScopeDefiner
     */
    private $scopeDefiner;

    public function __construct(
        ScopeDefiner $scopeDefiner
    ) {
        $this->scopeDefiner = $scopeDefiner;
    }

    /**
     * @param Structure $subject
     * @param Section $result
     * @return StructureElementInterface
     */
    public function afterGetElementByPathParts(
        Structure $subject,
        StructureElementInterface $result
    ): StructureElementInterface {
        if (!$result->getAttribute('tab')
            || $result->getAttribute('tab') !== self::ARMAH_TAB_NAME
            || !$result->getAttribute('resource')
        ) {
            return $result;
        }
        $moduleChildes = $result->getAttribute('children');
        if (isset($moduleChildes['armah_information'])) {
            return $result; //backward compatibility
        }
        $moduleCode = strtok($result->getAttribute('resource'), '::');
        $moduleChildes =
            [
                'armah_information' => [
                    'id' => 'armah_information',
                    'translate' => 'label',
                    'type' => 'text',
                    'sortOrder' => '1',
                    'showInDefault' => '1',
                    'showInWebsite' => '1',
                    'showInStore' => '1',
                    'label' => 'Information',
                    'frontend_model' => Information::class,
                    '_elementType' => 'group',
                    'path' => $result->getAttribute('id') ?? '',
                    'module_code' => $moduleCode
                ]
            ] + $moduleChildes;
        $result->getChildren()->setElements($moduleChildes, $this->scopeDefiner->getScope());

        return $result;
    }
}
