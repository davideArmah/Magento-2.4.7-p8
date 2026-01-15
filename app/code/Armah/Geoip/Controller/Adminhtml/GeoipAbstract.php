<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */
namespace Armah\Geoip\Controller\Adminhtml;

use Armah\Geoip\Helper\Data as Helper;
use Armah\Geoip\Model\Import;
use Armah\Geoip\Model\Geolocation;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Json\Helper\Data as JsonData;
use Magento\Framework\Filesystem\Driver\File;

/**
 * Class GeoipAbstract
 */
abstract class GeoipAbstract extends Action
{

    /**
     * @var Import
     */
    protected $importModel;

    /**
     * @var Helper
     */
    protected $geoipHelper;

    /**
     * @var JsonData
     */
    protected $jsonHelper;

    /**
     * @var File
     */
    protected $driverFile;

    /**
     * @var Geolocation
     */
    protected $geolocationModel;

    public function __construct(
        Context $context,
        Import $importModel,
        Helper $geoipHelper,
        JsonData $jsonHelper,
        File $driverFile,
        Geolocation $geolocationModel
    ) {
        parent::__construct($context);
        $this->importModel = $importModel;
        $this->geoipHelper = $geoipHelper;
        $this->jsonHelper = $jsonHelper;
        $this->driverFile = $driverFile;
        $this->geolocationModel = $geolocationModel;
    }
}
