<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Ui\DataProvider\Redirect\Form;

use Armah\SeoToolkitLite\Api\Data\RedirectInterface;
use Armah\SeoToolkitLite\Api\RedirectRepositoryInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Armah\SeoToolkitLite\Model\ResourceModel\Redirect\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    public const ARSEOTOOLKITLITE_REDIRECT = 'arseoToolkitLite_redirect';

    /**
     * @var RedirectRepositoryInterface
     */
    private $redirectRepository;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    public function __construct(
        CollectionFactory $collectionFactory,
        RedirectRepositoryInterface $redirectRepository,
        DataPersistorInterface $dataPersistor,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->redirectRepository = $redirectRepository;
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
            if (isset($data['items'][0][RedirectInterface::REDIRECT_ID])) {
                $redirectId = (int)$data['items'][0][RedirectInterface::REDIRECT_ID];
                $redirect = $this->redirectRepository->getById($redirectId);
                $data = [$redirectId => $redirect->getData()];
            }
        }

        if ($savedData = $this->dataPersistor->get(self::ARSEOTOOLKITLITE_REDIRECT)) {
            $savedRedirectId = $savedData[RedirectInterface::REDIRECT_ID] ?? null;
            $data[$savedRedirectId] = isset($data[$savedRedirectId])
                ? array_merge($data[$savedRedirectId], $savedData)
                : $savedData;
            $this->dataPersistor->clear(self::ARSEOTOOLKITLITE_REDIRECT);
        }

        return $data;
    }
}
