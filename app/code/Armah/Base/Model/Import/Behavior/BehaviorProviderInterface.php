<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\Import\Behavior;

interface BehaviorProviderInterface
{
    /**
     * @param string $behaviorCode
     *
     * @throws \Armah\Base\Exceptions\NonExistentImportBehavior
     * @return \Armah\Base\Model\Import\Behavior\BehaviorInterface
     */
    public function getBehavior($behaviorCode);
}
