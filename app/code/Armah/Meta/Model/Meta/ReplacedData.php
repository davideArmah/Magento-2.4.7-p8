<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Meta Tags Templates for Magento 2
 */

namespace Armah\Meta\Model\Meta;

class ReplacedData
{
    public const DESCRIPTION = 'description';
    public const AFTER_PRODUCT_TEXT = 'after_product_text';
    public const SHORT_DESCRIPTION = 'short_description';

    /**
     * @var array|null
     */
    public $replacedData;

    /**
     * @return array|null
     */
    public function getReplacedData(): ?array
    {
        return $this->replacedData;
    }

    /**
     * @param array $data
     * @return void
     */
    public function setReplacedData(array $data): void
    {
        $this->replacedData = $data;
    }
}
