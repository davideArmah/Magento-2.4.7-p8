<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\Ui\Component\Form\Field;

use Hyva\CmsTailwindJit\ViewModel\TailwindThemes;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Form\Field;

class PreviewJitConfigTheme extends Field
{
    /**
     * @var TailwindThemes
     */
    private $tailwindThemes;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        TailwindThemes $tailwindThemes,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->tailwindThemes = $tailwindThemes;
    }

    public function prepare()
    {
        if (count($this->tailwindThemes->getTailwindThemes()) <= 1) {
            $config = $this->getConfig();
            $config['visible'] = false;
            $this->setConfig($config);
        }
        parent::prepare();
    }
}
