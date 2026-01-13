<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Custom Checkout Fields for Magento 2
 */

namespace Armah\Orderattr\Model\Attribute\Validator;

class ValidatorPool
{
    /**
     * @var ValidatorInterface[]
     */
    private $validators = [];

    public function __construct(
        array $validators = []
    ) {
        $this->initValidators($validators);
    }

    /**
     * @return ValidatorInterface[]
     */
    public function getValidators(): array
    {
        return $this->validators;
    }

    public function initValidators($validators): void
    {
        foreach ($validators as $validator) {
            if (!$validator instanceof ValidatorInterface) {
                throw new \LogicException(
                    sprintf('Validator must implement %s', ValidatorInterface::class)
                );
            }
            $this->validators[] = $validator;
        }
    }
}
