<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model\LinkType\Processor;

use Armah\CrossLinks\Model\Link;
use Armah\CrossLinks\Model\Source\ReferenceType;

class CustomLinkProcessor implements LinkTypeProcessorInterface
{
    /**
     * @var Link
     */
    private $link;

    public function __construct(
        Link $link
    ) {
        $this->link = $link;
    }

    public function getTypeCode(): int
    {
        return ReferenceType::REFERENCE_TYPE_CUSTOM;
    }

    public function getStyleClass(): string
    {
        return '';
    }

    public function getBlockClass(): string
    {
        return '';
    }

    public function getPickerBlockData(): array
    {
        return [];
    }

    public function getResource(string $referenceResource)
    {
        return $this->link->getProduct($referenceResource);
    }

    public function getLinkUrl(string $referenceResource): string
    {
        return $this->link->getCustomUrl($referenceResource);
    }

    public function getResourceTextKey(): string
    {
        return '';
    }
}
