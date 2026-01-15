<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model\LinkType;

use Armah\CrossLinks\Model\LinkType\Processor\LinkTypeProcessorInterface;

class LinkProcessorProvider
{
    /**
     * @var LinkTypeProcessorInterface[]
     */
    private $processors;

    public function __construct(
        array $linkTypes = []
    ) {
        $this->initializeLinkTypes($linkTypes);
    }

    /**
     * @return array
     */
    public function getLinkProcessors(): array
    {
        return $this->processors;
    }

    public function getLinkProcessorByType(int $type): LinkTypeProcessorInterface
    {
        return $this->processors[$type];
    }

    private function initializeLinkTypes(array $linkTypes): void
    {
        foreach ($linkTypes as $linkType) {
            if (!$linkType['processor'] instanceof LinkTypeProcessorInterface) {
                throw new \LogicException(
                    sprintf('Link type must implement %s', LinkTypeProcessorInterface::class)
                );
            }
            $this->processors[$linkType['typeCode']] = $linkType['processor'];
        }
    }
}
