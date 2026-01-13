<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Armah Improved Sorting GraphQl for Magento 2 (System)
 */

namespace Armah\SortingGraphQl\Plugin\Block\Widget\Featured;

use Armah\Sorting\Block\Widget\Featured;
use Magento\Framework\Serialize\Serializer\Json;

class AddWidgetParams
{
    /**
     * @var Json
     */
    private $json;

    public function __construct(Json $json)
    {
        $this->json = $json;
    }

    /**
     * Save widget parameters for variable,
     * for future rerender widget with this parameters.
     *
     * @param Featured $subject
     * @param string $html
     * @return string
     */
    public function afterToHtml(Featured $subject, string $html): string
    {
        $data = $subject->getData() + ['template' => $this->parseTemplateName($subject->getTemplate())];
        $html = sprintf(
            '<div class="amsorting-widget-wrapper"><script>var amSortingConfig%s = "%s"</script>%s</div>',
            uniqid(),
            $this->json->serialize($data),
            $html
        );

        return $html;
    }

    private function parseTemplateName(string $template): string
    {
        return preg_replace('@Armah_Sorting::widget/featured/(.*?).phtml@s', '$1', $template);
    }
}
