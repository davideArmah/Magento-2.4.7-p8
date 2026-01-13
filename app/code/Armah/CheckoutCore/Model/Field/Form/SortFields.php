<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package One Step Checkout Core for Magento 2
 */

namespace Armah\CheckoutCore\Model\Field\Form;

use Armah\CheckoutCore\Model\Field;

class SortFields
{
    /**
     * @param Field[] $fields
     * @return void
     * @see \Armah\CheckoutCore\Model\LayoutProcessor\SortFields
     */
    public function execute(array &$fields): void
    {
        uksort($fields, static function (string $firstKey, string $secondKey) use ($fields) {
            $firstField = $fields[$firstKey];
            $secondField = $fields[$secondKey];

            $diff = $firstField->getSortOrder() <=> $secondField->getSortOrder();
            return $diff !== 0 ? $diff : strcmp($firstKey, $secondKey);
        });
    }
}
