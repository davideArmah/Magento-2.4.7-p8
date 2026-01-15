<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Ui\DataProvider\Config\Form;

use Armah\Meta\Api\ConfigRepositoryInterface;
use Armah\Meta\Api\Data\ConfigInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Armah\Meta\Model\ResourceModel\Config\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    const ARMETA_CONFIG = 'armeta_config';

    /**
     * @var ConfigRepositoryInterface
     */
    private $configRepository;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    public function __construct(
        CollectionFactory $collectionFactory,
        ConfigRepositoryInterface $configRepository,
        DataPersistorInterface $dataPersistor,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->configRepository = $configRepository;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getData()
    {
        $data = parent::getData();
        if ($data['totalRecords'] > 0) {
            if (isset($data['items'][0][ConfigInterface::CONFIG_ID])) {
                $configId = (int)$data['items'][0][ConfigInterface::CONFIG_ID];
                $config = $this->configRepository->getById($configId);
                $data = [$configId => $config->getData()];
            }
        }

        if ($savedData = $this->dataPersistor->get(self::ARMETA_CONFIG)) {
            $savedRedirectId = $savedData[ConfigInterface::CONFIG_ID] ?? null;
            $data[$savedRedirectId] = isset($data[$savedRedirectId])
                ? array_merge($data[$savedRedirectId], $savedData)
                : $savedData;
            $this->dataPersistor->clear(self::ARMETA_CONFIG);
        }

        return $data;
    }
}
