<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Api\Data;

interface InstanceDataInterface
{
    public const ID = 'id';
    public const CODE = 'code';
    public const VALUE = 'value';

    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @param string $code
     * @return void
     */
    public function setCode(string $code): void;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @param string $value
     * @return void
     */
    public function setValue(string $value): void;

    /**
     * @return string|null
     */
    public function getValue(): ?string;
}
