<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Block\Adminhtml\System\Config\SysInfo;

use Armah\Base\Model\SysInfo\Provider\Collector;
use Armah\Base\Model\SysInfo\Provider\Collector\CacheService\Info\CacheInfoInterface;
use Armah\Base\Model\SysInfo\Provider\CollectorPool;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Element\Template;

class CacheInfo extends Template
{
    /**
     * @var Collector
     */
    private $collector;

    /**
     * @var string
     */
    protected $_template = 'Armah_Base::cache_info.phtml';

    public function __construct(
        Template\Context $context,
        Collector $collector,
        array $data = []
    ) {
        $this->collector = $collector;
        parent::__construct($context, $data);
    }

    /**
     * @return CacheInfoInterface[]
     */
    public function getCacheTypesInfo(): array
    {
        try {
            return $this->collector->collect(CollectorPool::CACHE_INFO_SERVICE_GROUP);
        } catch (NotFoundException $e) {
            $this->_logger->error($e->getMessage());
        }

        return [];
    }
}
