<?php
/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\Import\Validation;

class ValidatorPool implements ValidatorPoolInterface
{
    /**
     * @var \Armah\Base\Model\Import\Validation\ValidatorInterface[]
     */
    private $validators;

    public function __construct(
        $validators
    ) {
        $this->validators = [];
        foreach ($validators as $validator) {
            if (!($validator instanceof ValidatorInterface)) {
                throw new \Armah\Base\Exceptions\WrongValidatorInterface();
            }

            $this->validators[] = $validator;
        }
    }

    /**
     * @inheritdoc
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * @inheritdoc
     */
    public function addValidator($validator)
    {
        if (!($validator instanceof ValidatorInterface)) {
            throw new \Armah\Base\Exceptions\WrongValidatorInterface();
        }

        $this->validators[] = $validator;
    }
}
