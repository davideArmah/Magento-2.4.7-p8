<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Api\Data;

interface FileContentInterface
{
    public const BASE64_ENCODED_DATA = 'base64_encoded_data';
    public const EXTENSION = 'extension';
    public const FILENAME_WITH_EXTENSION = 'name_with_extension';

    /**
     * @return string
     */
    public function getBase64EncodedData(): string;

    /**
     * @param string $base64EncodedData
     *
     * @return FileContentInterface
     */
    public function setBase64EncodedData(string $base64EncodedData): FileContentInterface;

    /**
     * @return string
     */
    public function getFileNameWithExtension(): string;

    /**
     * @param string $filenameWithExtension
     *
     * @return FileContentInterface
     */
    public function setFileNameWithExtension(string $filenameWithExtension): FileContentInterface;

    /**
     * @param string $extension
     *
     * @return FileContentInterface
     */
    public function setExtension(string $extension): FileContentInterface;

    /**
     * @return string
     */
    public function getExtension(): string;
}
