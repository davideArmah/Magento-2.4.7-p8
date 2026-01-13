<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\Model;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\View\DesignInterface;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class CmsEntityTailwindCssRepository
{
    /**
     * @var DesignInterface
     */
    private $design;

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    public function __construct(DesignInterface $design, ResourceConnection $resourceConnection)
    {
        $this->design             = $design;
        $this->resourceConnection = $resourceConnection;
    }

    public function saveStyles(string $table, int $id, array $themeToStylesMap): void
    {
        $this->getConnection()->beginTransaction();

        $table = $this->getConnection()->getTableName($this->prefixTable($table));

        $where = $this->whereCmsEntityId('entity_id', $id);
        $this->getConnection()->delete($table, $where);

        foreach ($themeToStylesMap as $theme => $css) {
            $cleanedCss = $this->cleanGeneratedCss($css);
            if ($cleanedCss !== '') {
                $this->getConnection()->insert($table, ['entity_id' => $id, 'theme' => $theme, 'css' => $cleanedCss]);
            }
        }
        $this->getConnection()->commit();
    }

    public function loadStyles(string $table, int $id, ?string $theme = null): string
    {
        $db     = $this->getConnection();
        $table  = $this->getConnection()->getTableName($this->prefixTable($table));
        $select = $db->select()->from($table, 'css')->where('entity_id=:id AND theme=:theme');

        return $db->fetchOne($select, ['id' => $id, 'theme' => $theme ?? $this->getCurrentTheme()]) ?: '';
    }

    private function prefixTable(string $table): string
    {
        return $this->resourceConnection->getTablePrefix() . $table;
    }

    private function whereCmsEntityId(string $idField, $id): string
    {
        return sprintf('%s = %d', $this->getConnection()->quoteIdentifier($idField), $id);
    }

    private function getConnection(): AdapterInterface
    {
        return $this->resourceConnection->getConnection();
    }

    private function getCurrentTheme(): string
    {
        return $this->design->getDesignTheme()->getFullPath();
    }

    /**
     * Remove common preamble and clean up whitespace.
     *
     * Tailwind has \r\n and empty lines in the output and adds a preamble that isn't removed by turning preflight off.
     *
     * @param string $css
     * @return string
     */
    private function cleanGeneratedCss(string $css): string
    {
        $css = preg_replace("#\n\s+#", "\n", str_replace("\r\n", "\n", $css));
        $css = preg_replace("#\*, ::before, ::after {[^}]+}#s", '', $css);
        $css = preg_replace("#::backdrop {[^}]+}#s", '', $css);

        return trim($css);
    }
}
