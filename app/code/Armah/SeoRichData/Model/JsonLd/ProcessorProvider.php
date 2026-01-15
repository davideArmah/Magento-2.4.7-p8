<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Google Rich Snippets for Magento 2
 */

namespace Armah\SeoRichData\Model\JsonLd;

use Armah\SeoRichData\Model\JsonLd\Processor\ProcessorInterface;

class ProcessorProvider
{
    /**
     * @var ProcessorInterface[]
     */
    private $processors;

    public function __construct(
        array $processors = []
    ) {
        $this->initializeProcessors($processors);
    }

    public function getProcessors(): array
    {
        return $this->processors;
    }

    private function initializeProcessors(array $processors): void
    {
        foreach ($processors as $code => $processor) {
            if (!$processor instanceof ProcessorInterface) {
                throw new \LogicException(
                    sprintf('JsonLd processor must implement %s', ProcessorInterface::class)
                );
            }
            $this->processors[$code] = $processor;
        }
    }
}
