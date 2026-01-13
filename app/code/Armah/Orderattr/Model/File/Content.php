<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\File;

use Armah\Orderattr\Api\Data\FileContentInterface;
use Magento\Framework\DataObject;

class Content extends DataObject implements FileContentInterface
{
    public function getBase64EncodedData(): string
    {
        return (string)$this->_getData(FileContentInterface::BASE64_ENCODED_DATA);
    }

    public function setBase64EncodedData(string $base64EncodedData): FileContentInterface
    {
        $this->setData(FileContentInterface::BASE64_ENCODED_DATA, $base64EncodedData);

        return $this;
    }

    public function setExtension(string $extension): FileContentInterface
    {
        $this->setData(FileContentInterface::EXTENSION, $extension);

        return $this;
    }

    public function getExtension(): string
    {
        return (string)$this->_getData(FileContentInterface::EXTENSION);
    }

    public function getFileNameWithExtension(): string
    {
        return (string)$this->_getData(FileContentInterface::FILENAME_WITH_EXTENSION);
    }

    public function setFileNameWithExtension(string $filenameWithExtension): FileContentInterface
    {
        $this->setData(FileContentInterface::FILENAME_WITH_EXTENSION, $filenameWithExtension);

        return $this;
    }
}
