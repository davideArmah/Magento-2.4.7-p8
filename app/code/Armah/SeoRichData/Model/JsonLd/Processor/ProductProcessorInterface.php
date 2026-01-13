<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Rich Snippets for Magento 2
 */

namespace Armah\SeoRichData\Model\JsonLd\Processor;

use Magento\Catalog\Model\Product as ProductModel;

interface ProductProcessorInterface
{
    public function process(array $data, ProductModel $product): array;
}
