<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Utils\Http\Response\Entity;

interface DataProcessorInterface
{
    public function process(array $data): array;
}
