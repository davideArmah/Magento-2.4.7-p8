<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\Import\Validation;

interface ValidatorPoolInterface
{
    /**
     * @return \Armah\Base\Model\Import\Validation\ValidatorInterface[]
     */
    public function getValidators();

    /**
     * @param \Armah\Base\Model\Import\Validation\ValidatorInterface
     *
     * @return void
     */
    public function addValidator($validator);
}
