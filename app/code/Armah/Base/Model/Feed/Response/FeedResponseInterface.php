<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Model\Feed\Response;

interface FeedResponseInterface
{
    public function getContent(): ?string;

    public function setContent(?string $content): FeedResponseInterface;

    public function getStatus(): ?string;

    public function setStatus(?string $status): FeedResponseInterface;

    public function isNeedToUpdateCache(): bool;

    public function isFailed(): bool;
}
