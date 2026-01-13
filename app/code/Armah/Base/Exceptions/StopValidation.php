<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Exceptions;

class StopValidation extends \Exception
{
    /**
     * @var array|bool
     */
    private $validateResult;

    /**
     * @param array|bool $validateResult
     */
    public function __construct($validateResult)
    {
        $this->validateResult = $validateResult;
    }

    /**
     * @return array|bool
     */
    public function getValidateResult()
    {
        return $this->validateResult;
    }
}
