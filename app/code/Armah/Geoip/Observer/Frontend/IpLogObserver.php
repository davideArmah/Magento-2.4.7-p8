<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Observer\Frontend;

use Armah\Geoip\Model\ConfigProvider;
use Armah\Geoip\Model\IpLog\LogFlag;
use Armah\Geoip\Model\IpLog\SaveCurrenIp;
use Armah\Geoip\Model\Source\RefreshIpBehaviour;
use Exception;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class IpLogObserver implements ObserverInterface
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var SaveCurrenIp
     */
    private $saveCurrentIp;

    /**
     * @var LogFlag
     */
    private $ipLogFlag;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ConfigProvider $configProvider,
        SaveCurrenIp $saveCurrentIp,
        LogFlag $ipLogFlag,
        LoggerInterface $logger
    ) {
        $this->configProvider = $configProvider;
        $this->saveCurrentIp = $saveCurrentIp;
        $this->ipLogFlag = $ipLogFlag;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        try {
            /** @var RequestInterface $request */
            $request = $observer->getData('request');

            if (!$this->shouldLogIp($request)) {
                return;
            }

            $this->saveCurrentIp->execute();
            $this->ipLogFlag->setIsLogged();
        } catch (Exception $exception) {
            $this->logger->error($exception);
        }
    }

    private function shouldLogIp(RequestInterface $request): bool
    {
        return $request instanceof HttpRequest
            && !$request->isAjax()
            && $this->configProvider->getRefreshIpBehaviour() === RefreshIpBehaviour::VIA_ARMAH_SERVICE
            && !$this->ipLogFlag->isLogged();
    }
}
