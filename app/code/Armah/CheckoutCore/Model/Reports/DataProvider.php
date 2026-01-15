<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Reports;

use Armah\CheckoutCore\Model\StatisticManagement;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData = [];

    /**
     * @var StatisticManagement
     */
    private $statisticManagement;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        StatisticManagement $statisticManagement,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->statisticManagement = $statisticManagement;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->statisticManagement->calculateStatistic();
    }
}
