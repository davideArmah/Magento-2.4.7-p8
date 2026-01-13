<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package GeoIP Data for Magento 2 (System)
 */

namespace Armah\Geoip\Controller\Adminhtml\Geoip;

use Armah\Geoip\Controller\Adminhtml\GeoipAbstract;

class Start extends GeoipAbstract
{
    public function execute()
    {
        $result = [];
        try {
            $type   = $this->getRequest()->getParam('type');
            $action = $this->getRequest()->getParam('action');

            $this->geoipHelper->resetDone();
            $filePath = $this->geoipHelper->getCsvFilePath($type);
            $ret = $this->importModel->startProcess(
                $type,
                $filePath,
                $action,
                $this->geoipHelper->_geoipIgnoredLines[$type]
            );
            $result['position'] = ceil($ret['current_row'] / $ret['rows_count'] * 100);
            $result['status']   = 'started';
            $result['file']     = $this->geoipHelper->_geoipCsvFiles[$type];
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }

        $this->getResponse()->setBody($this->jsonHelper->jsonEncode($result));

        return $this->getResponse();
    }
}
