<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Utils\Http\Response;

use Armah\Base\Model\SimpleDataObject;
use Armah\Base\Model\SimpleDataObjectFactory;
use Armah\Base\Utils\DataConverter;
use Armah\Base\Utils\Http\Response\Entity\ConfigPool;
use Armah\Base\Utils\Http\Response\Entity\Converter;
use Magento\Framework\Exception\NotFoundException;

class ResponseFactory
{
    /**
     * @var Converter
     */
    private $converter;

    /**
     * @var ConfigPool
     */
    private $configPool;

    /**
     * @var SimpleDataObjectFactory
     */
    private $simpleDataObjectFactory;

    /**
     * @var DataConverter
     */
    private $dataConverter;

    public function __construct(
        Converter $converter,
        ConfigPool $configPool,
        SimpleDataObjectFactory $simpleDataObjectFactory,
        DataConverter $dataConverter
    ) {
        $this->converter = $converter;
        $this->configPool = $configPool;
        $this->simpleDataObjectFactory = $simpleDataObjectFactory;
        $this->dataConverter = $dataConverter;
    }

    public function create(string $url, array $response): SimpleDataObject
    {
        $response = $this->dataConverter->convertArrayToSnakeCase($response);
        try {
            // phpcs:disable Magento2.Functions.DiscouragedFunction.Discouraged
            $path = parse_url($url, PHP_URL_PATH);
            $entityConfig = $this->configPool->get($path);
            if ($entityConfig->getType() === 'array') {
                $object = [];
                foreach ($response as $row) {
                    $object[] = $this->converter->convertToObject($row, $entityConfig);
                }
            } else {
                $object = $this->converter->convertToObject($response, $entityConfig);
            }
        } catch (NotFoundException $e) {
            $object = $this->simpleDataObjectFactory->create(['data' => $response]);
        }

        return $object;
    }
}
