<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model\LinkType\Processor;

interface LinkTypeProcessorInterface
{
    public function getTypeCode(): int;

    public function getStyleClass(): string;

    public function getBlockClass(): string;

    public function getPickerBlockData(): array;

    public function getResource(string $referenceResource);

    public function getLinkUrl(string $referenceResource): string;

    public function getResourceTextKey(): string;
}
