<?php

declare(strict_types=1);

/** * @package Magento 2 Base Package
 */

namespace Armah\Base\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface InstanceHashRepositoryInterface
{
    /**
     * @param string $code
     * @return \Armah\Base\Api\Data\InstanceHashInterface
     * @throws NoSuchEntityException
     */
    public function get(string $code): Data\InstanceHashInterface;

    /**
     * @param \Armah\Base\Api\Data\InstanceHashInterface $instanceHash
     * @return void
     * @throws CouldNotSaveException
     */
    public function save(Data\InstanceHashInterface $instanceHash): void;

    /**
     * @param string $code
     * @return void
     * @throws CouldNotDeleteException
     */
    public function delete(string $code): void;
}
