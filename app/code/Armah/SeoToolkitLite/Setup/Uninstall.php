<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package SEO Toolkit Base for Magento 2
 */

namespace Armah\SeoToolkitLite\Setup;

use Armah\SeoToolkitLite\Api\Data\RedirectInterface;
use Armah\SeoToolkitLite\Setup\Uninstall\DeleteEavAttributes;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{
    public const TABLES_TO_DROP = [
        RedirectInterface::TABLE_NAME,
        RedirectInterface::STORE_TABLE_NAME,
    ];

    /**
     * @var DeleteEavAttributes
     */
    private $deleteEavAttributes;

    public function __construct(
        DeleteEavAttributes $deleteEavAttributes
    ) {
        $this->deleteEavAttributes = $deleteEavAttributes;
    }

    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $connection = $installer->getConnection();
        foreach (self::TABLES_TO_DROP as $table) {
            $connection->dropTable($installer->getTable($table));
        }

        $this->deleteEavAttributes->execute();
    }
}
