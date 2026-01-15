<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Model\IpLog;

use Armah\Base\Model\GetCustomerIp;
use Armah\Geoip\Api\Data\IpLogInterfaceFactory as IpLogFactory;
use Armah\Geoip\Model\Ip\GdprMaskIp;
use Armah\Geoip\Model\IpLog\Repository\Save;
use Magento\Framework\Stdlib\DateTime\DateTime;

class SaveCurrenIp
{
    /**
     * @var Save
     */
    private $saver;

    /**
     * @var IpLogFactory
     */
    private $ipLogFactory;

    /**
     * @var GetCustomerIp
     */
    private $getCustomerIp;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var GdprMaskIp
     */
    private $gdprMaskIp;

    public function __construct(
        Save $saver,
        IpLogFactory $ipLogFactory,
        GetCustomerIp $getCustomerIp,
        DateTime $dateTime,
        GdprMaskIp $gdprMaskIp
    ) {
        $this->saver = $saver;
        $this->ipLogFactory = $ipLogFactory;
        $this->getCustomerIp = $getCustomerIp;
        $this->dateTime = $dateTime;
        $this->gdprMaskIp = $gdprMaskIp;
    }

    public function execute(): void
    {
        $ipLog = $this->ipLogFactory->create();
        $ipLog->setIp($this->getCurrentIp());
        $ipLog->setLastVisit($this->dateTime->gmtDate('Y-m-d'));

        $this->saver->execute($ipLog);
    }

    private function getCurrentIp(): string
    {
        return $this->gdprMaskIp->execute($this->getCustomerIp->getCurrentIp());
    }
}
