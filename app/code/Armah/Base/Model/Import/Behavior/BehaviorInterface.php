<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\Import\Behavior;

/**
 * @since 1.4.6
 */
interface BehaviorInterface
{
    /**
     * @param array $importData
     *
     * @return \Magento\Framework\DataObject|void
     */
    public function execute(array $importData);
}
