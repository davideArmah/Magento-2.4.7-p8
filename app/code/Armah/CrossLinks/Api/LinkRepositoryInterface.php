<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Api;

use Magento\Framework\Exception\NoSuchEntityException;

interface LinkRepositoryInterface
{

    /**
     * Loads a specified abstract giftcard entity.
     *
     * @param int $id The abstract giftcard entity ID.
     * @return \Armah\CrossLinks\Api\LinkInterface abstract giftcard entity interface.
     * @throws NoSuchEntityException
     */
    public function get($id);

    /**
     * Performs persist operations for a specified abstract giftcard entity.
     *
     * @param \Armah\CrossLinks\Api\LinkInterface $entity The abstract giftcard entity ID.
     * @return \Armah\CrossLinks\Api\LinkInterface abstract giftcard entity interface.
     */
    public function save(LinkInterface $entity);

    /**
     * Performs persist operations for a specified abstract giftcard entity.
     *
     * @param \Armah\CrossLinks\Api\LinkInterface $entity The abstract giftcard entity ID.
     * @return \Armah\CrossLinks\Api\LinkInterface abstract giftcard entity interface.
     */
    public function delete(LinkInterface $entity);
}
