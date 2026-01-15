<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Api;

interface MergeJsInterface
{
    /**
     * @param string[] $fileNames
     * @return boolean
     */
    public function createBundle(array $fileNames);
}
