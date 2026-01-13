<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah 
 * @package Improved Sorting for Magento 2
 */

namespace Armah\Sorting\Model;

use Armah\Sorting\Api\MethodInterface;
use Armah\Sorting\Api\IndexMethodWrapperInterface;
use Magento\Framework\Exception\LocalizedException;

class MethodProvider
{
    /**
     * Sorting Methods which can use index table
     *
     * @var IndexMethodWrapperInterface[]
     */
    private $indexedMethods = [];

    /**
     * Sorting methods
     *
     * @var MethodInterface[]
     */
    private $methods = [];

    public function __construct(
        array $indexedMethods = [],
        array $methods = []
    ) {
        $this->initMethods($indexedMethods, $methods);
    }

    /**
     * initialize sorting method collection
     *
     * @param IndexMethodWrapperInterface[] $indexedMethods
     * @param MethodInterface[] $methods
     *
     * @throws LocalizedException
     */
    private function initMethods(array $indexedMethods = [], array $methods = []): void
    {
        foreach ($indexedMethods as $methodWrapper) {
            $this->indexedMethods[$methodWrapper->getSource()->getMethodCode()] = $methodWrapper;
        }
        foreach ($methods as $methodObject) {
            if (!$methodObject instanceof MethodInterface) {
                if (is_object($methodObject)) {
                    throw new LocalizedException(
                        __('Method object ' . get_class($methodObject) .
                            ' must be implemented by Armah\Sorting\Api\MethodInterface')
                    );
                } else {
                    throw new LocalizedException(__('$methodObject is not object'));
                }
            }
            $this->methods[$methodObject->getMethodCode()] = $methodObject;
        }
    }

    /**
     * @param string $code
     * @return MethodInterface|null
     */
    public function getMethodByCode(string $code): ?MethodInterface
    {
        return $this->methods[$code] ?? null;
    }

    /**
     * @return IndexMethodWrapperInterface[]
     */
    public function getIndexedMethods(): array
    {
        return $this->indexedMethods;
    }

    /**
     * @return MethodInterface[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}
