<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) 2023 Armah (https://www.armah.it)
 * @package Cron Schedule List for Magento 2 (System) 
 */

namespace Armah\CronScheduleList\Ui\DataProvider\Listing;

class ScheduleDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Armah\CronScheduleList\Model\ScheduleCollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        \Armah\CronScheduleList\Model\ScheduleCollectionFactory $collectionFactory,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collectionFactory = $collectionFactory;
    }

    public function getCollection()
    {
        if (!$this->collection) {
            $this->collection = $this->collectionFactory->create()->removeActivitySchedule();
        }

        return $this->collection;
    }
}
