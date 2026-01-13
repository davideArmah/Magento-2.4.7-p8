<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model;

class Logger
{
    public const DEBUG_CONFIG_PATH = 'armahsorting/general/debug';
    public const DEBUG_REQUEST_VAR = 'amdebug';

    /**
     * @var \Armah\Base\Debug\VarDump
     */
    private $logger;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    public function __construct(
        \Armah\Base\Debug\VarDump $logger,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
    }

    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $collection
     * @return $this
     */
    public function logCollectionQuery($collection)
    {
        if ($this->scopeConfig->isSetFlag(self::DEBUG_CONFIG_PATH)
            && $this->request->getParam(self::DEBUG_REQUEST_VAR, false)
        ) {
            $this->logger->armahEcho($collection->getSelect()->__toString());
        }
        return $this;
    }
}
