<?php

declare(strict_types=1);

/**
 * @package Magento 2 Base Package
 */

namespace Armah\Base\Block\Adminhtml;

use Armah\Base\Model\Feed\FeedTypes\Extensions as ExtensionsFeed;
use Armah\Base\Model\ModuleInfoProvider;
use Armah\Base\Model\ModuleListProcessor;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Module\ModuleListInterface;

class Extensions extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var string
     */
    protected $_template = 'Armah_Base::modules.phtml';

    /**
     * @var ExtensionsFeed
     */
    private $extensionsFeed;

    /**
     * @var ModuleInfoProvider
     */
    private $moduleInfoProvider;

    /**
     * @var ModuleListProcessor
     */
    private $moduleListProcessor;

    /**
     * @var ModuleListInterface
     */
    private $moduleList;

    public function __construct(
        Context $context,
        ExtensionsFeed $extensionsFeed,
        ModuleInfoProvider $moduleInfoProvider,
        ModuleListProcessor $moduleListProcessor,
        ModuleListInterface $moduleList,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->extensionsFeed = $extensionsFeed;
        $this->moduleInfoProvider = $moduleInfoProvider;
        $this->moduleListProcessor = $moduleListProcessor;
        $this->moduleList = $moduleList;
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->toHtml();
    }

    /**
     * @return string
     */
    public function getModulesDataJson(): string
    {
        try {
            $modules = $this->getInstalledModules();
            return json_encode($modules);
        } catch (\Exception $e) {
            return json_encode([]);
        }
    }

    /**
     * @return array
     */
    private function getInstalledModules(): array
    {
        $modules = [];
        $allModules = $this->moduleList->getNames();

        foreach ($allModules as $moduleName) {
            if (strpos($moduleName, 'Armah_') === 0) {
                $moduleData = $this->moduleList->getOne($moduleName);
                $modules[] = [
                    'name' => $moduleName,
                    'version' => $moduleData['setup_version'] ?? '1.0.0'
                ];
            }
        }

        return $modules;
    }

    /**
     * @return bool
     */
    public function isOriginMarketplace(): bool
    {
        return $this->moduleInfoProvider->isOriginMarketplace();
    }

    /**
     * @return string
     */
    public function getSeoparams(): string
    {
        return '';
    }
}
