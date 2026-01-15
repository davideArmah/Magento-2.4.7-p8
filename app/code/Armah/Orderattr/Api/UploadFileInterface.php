<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Api;

use Armah\Orderattr\Api\Data\FileContentInterface;

interface UploadFileInterface
{
    /**
     * @param FileContentInterface $fileContent
     * @return mixed
     */
    public function upload(FileContentInterface $fileContent): string;
}
