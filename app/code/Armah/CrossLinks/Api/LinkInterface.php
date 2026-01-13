<?php
/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Api;

/**
 * Abstract GiftCard Entrity Interface.
 */
interface LinkInterface
{
    /**
     * Set Link Title
     *
     * @param string $title
     * @return \Armah\CrossLinks\Api\LinkInterface
     */
    public function setTitle($title);

    /**
     * Get Link Title
     *
     * @return string
     */
    public function getTitle();

    /**
     * @return array
     */
    public function getKeywords();
}
