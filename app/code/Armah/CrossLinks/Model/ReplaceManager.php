<?php

declare(strict_types=1);

/**
 * @author Armah Team
 * @copyright Copyright (c) Armah (https://www.armah.it)
 * @package Cross Linking for Magento 2
 */

namespace Armah\CrossLinks\Model;

use Armah\CrossLinks\Api\LinkInterface;
use Armah\CrossLinks\Helper\Data;
use Armah\CrossLinks\Model\LinkType\LinkProcessorProvider;
use Armah\CrossLinks\Model\ResourceModel\Link\Collection;
use Armah\CrossLinks\Model\ResourceModel\Link\CollectionFactory;
use Magento\Catalog\Helper\Output;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\StoreManagerInterface;

class ReplaceManager
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $linksCollectionFactory;

    /**
     * @var \Armah\CrossLinks\Model\Link|null
     */
    protected ?LinkInterface $currentLink = null;

    /**
     * @var int
     */
    protected int $replacementLimit = 0;

    /**
     * @var int
     */
    private int $currentLinkReplacementLimit = 0;

    /**
     * @var array
     */
    private array $replacedJs = [];

    /**
     * @var array
     */
    private array $replacedImg = [];

    /**
     * @var array
     */
    private array $replacedHyperLink = [];

    /**
     * @var array
     */
    private array $replacedAttribute = [];

    /**
     * @var Collection
     */
    private ?Collection $collection = null;

    public function __construct(
        private readonly StoreManagerInterface $storeManager,
        private readonly Data $helper,
        CollectionFactory $collectionFactory,
        private ?LinkProcessorProvider $pickerProcessorProvider = null // TODO move to not optional
    ) {
        $this->linksCollectionFactory = $collectionFactory;
        // OM for backward compatibility
        $this->pickerProcessorProvider = $pickerProcessorProvider
            ?? ObjectManager::getInstance()->get(LinkProcessorProvider::class);
    }

    public function getCollection(): Collection
    {
        if ($this->collection === null) {
            $this->collection =  $this->prepareCollection();
        }

        return $this->collection;
    }

    /**
     * Prepare links collection singleton on a frontend
     */
    private function prepareCollection(): Collection
    {
        return $this->linksCollectionFactory->create()
            ->addStoreIdFilter([$this->storeManager->getStore()->getId(), \Magento\Store\Model\Store::DEFAULT_STORE_ID])
            ->addPriorityOrder()
            ->addStatusFilter();
    }

    /**
     * @see \Armah\CrossLinks\Observer\AddHandler::execute
     * @param Output $helper
     * @param string $content
     * @param array $params
     * @return string
     */
    public function productAttribute(Output $helper, $content, $params)
    {
        if (!$content || !$this->isReplacementAllowed('product', $params['attribute'])) {
            return $content;
        }
        return $this->replaceLinks($content);
    }

    /**
     * @see \Armah\CrossLinks\Observer\AddHandler::execute
     * @param Output $helper
     * @param string $content
     * @param array $params
     * @return string
     */
    public function categoryAttribute(Output $helper, $content, $params)
    {
        if (!$content || !$this->isReplacementAllowed('category', $params['attribute'])) {
            return $content;
        }

        return $this->replaceLinks($content);
    }

    /**
     * @param string $content
     * @return string
     */
    public function processCmsPageContent($content)
    {
        if (!$content) {
            return $content;
        }

        return $this->replaceLinks($content);
    }

    /**
     * @param string $content
     * @return string
     */
    public function processFaqPageContent($content)
    {
        if (!$content) {
            return $content;
        }

        $this->setReplacementLimit($this->helper->getFaqReplacementLimit());

        return $this->replaceLinks($content);
    }

    /**
     * @param $content
     * @return string
     */
    public function processBlogPageContent($content)
    {
        if (!$content) {
            return $content;
        }

        $this->setReplacementLimit($this->helper->getBlogReplacementLimit());

        return $this->replaceLinks($content);
    }

    /**
     * @param string $entity
     * @param $attribute
     * @return bool
     */
    protected function isReplacementAllowed($entity, $attribute)
    {
        $attributes = $this->helper->getEntityReplacementAttributeCodes($entity);

        return in_array($attribute, $attributes);
    }

    /**
     * @param int $replacementLimit
     */
    public function setReplacementLimit($replacementLimit)
    {
        $this->replacementLimit = $replacementLimit;
    }

    /**
     * @param string[] $matches
     * @return string
     */
    protected function replace($matches)
    {
        $this->currentLinkReplacementLimit--;
        $this->replacementLimit--;
        $processor = $this->pickerProcessorProvider
            ->getLinkProcessorByType((int)$this->currentLink->getReferenceType());
        $linkUrl = $processor->getLinkUrl($this->currentLink->getReferenceResource());

        return $this->currentLink->getLinkHtml($matches[0], $linkUrl);
    }

    /**
     * @param string $content
     * @return string
     */
    public function replaceLinks($content)
    {
        if ($this->helper->isActive()) {
            $content = $this->removeScriptContent($content);
            $content = $this->removeImageContent($content);
            $content = $this->removeHyperLinkContent($content);
            $content = $this->removeAttributeContent($content);
            $linkCollection = $this->getCollection();
            /** @var \Armah\CrossLinks\Model\Link $link */
            foreach ($linkCollection->getItems() as $link) {
                $this->currentLink = $link;
                $this->currentLinkReplacementLimit = (int)$link->getReplacementLimit();
                foreach ($link->getKeywords() as $keyword) {
                    $limit = min($this->replacementLimit, $this->currentLinkReplacementLimit);
                    if ($limit <= 0) {
                        break;
                    }
                    $keyword = $this->prepareKeyword($keyword);
                    $content = preg_replace_callback(
                        "/{$keyword}(?![^<]*<\/a>)/im",
                        [$this, 'replace'],
                        $content,
                        $limit
                    );
                }
                if ($this->replacementLimit <= 0) {
                    break; // break processing the rest of link collection if replacement limit is succeed.
                }
            }

            $content = $this->returnAttributeContent($content);
            $content = $this->returnHyperLinkContent($content);
            $content = $this->returnImageContent($content);
            $content = $this->returnScriptContent($content);
        }

        return $content;
    }

    /**
     * @param int $type
     * @return $this
     */
    public function setEntityType($type)
    {
        $this->replacementLimit = $this->helper->getEntityReplacementLimit($type);
        return $this;
    }

    /**
     * Preparing keyword for search by regular expression
     *
     * @param string $keyword
     * @return string mixed
     */
    protected function prepareKeyword($keyword)
    {
        $rawKeyword = trim($keyword, '+');

        $enclosedRawKeyword = str_replace(
            ['\\', '+', '.', '/', '<', '>', '{', '}', '[', ']', '$', '^', '(', ')', '|', '*', '?'],
            ['\\\\' , '\+', '\.', '\/', '\<', '\>', '\{', '\}', '\[', '\]', '\$', '\^', '\(', '\)', '\|', '\*', '\?'],
            $rawKeyword
        );

        $keyword = str_replace($rawKeyword, $enclosedRawKeyword, $keyword);
        $regexpr = $this->helper->getAdvancedRegexpr();

        $keyword = ($keyword[0] === '+') ?
            substr_replace($keyword, $regexpr, 0, 1)
            : '\b' . $keyword;

        return (substr($keyword, -1, 1) === '+') ?
            substr_replace($keyword, $regexpr, -1, 1)
            : $keyword . '\b';
    }

    /**
     * @param string $content
     *
     * @return string
     */
    private function removeScriptContent($content)
    {
        $content = preg_replace_callback(
            '#(\<script[^\>]*\>)(.*?)(\<\/script\>)#ims',
            [$this, 'replaceJS'],
            (string) $content
        );

        return $content;
    }

    /**
     * @param string $content
     *
     * @return string
     */
    private function removeImageContent($content)
    {
        $content = preg_replace_callback(
            '#(\<img)(.*?)((\/\>)|(\>))#ims',
            [$this, 'replaceImage'],
            $content
        );

        return $content;
    }

    private function removeHyperLinkContent(string $content): string
    {
        $content = preg_replace_callback(
            '#(\<a[^\>]*\>)(.*?)(\<\/a\>)#ims',
            [$this, 'replaceHyperLink'],
            $content
        );

        return $content;
    }

    private function removeAttributeContent(string $content): string
    {
        $content = preg_replace_callback(
            '#(=")(.*?)((\/\>)|("))#ims',
            [$this, 'replaceAttribute'],
            $content
        );

        $content = preg_replace_callback(
            '#(=\')(.*?)((\/\>)|(\'))#ims',
            [$this, 'replaceAttribute'],
            $content
        );

        return $content;
    }

    /**
     * @param array $matches
     * @return string
     */
    private function replaceJS($matches)
    {
        $text = '';
        if (count($matches) >= 4) {
            $this->replacedJs[] = $matches[2];
            $text = $matches[1] . '{{CROSS_LINK_' . (count($this->replacedJs) - 1) . '}}' . $matches[3];
        } elseif (isset($matches[0])) {
            $text = $matches[0];
        }

        return $text;
    }

    /**
     * @param array $matches
     * @return string
     */
    private function replaceImage($matches)
    {
        $text = '';
        if (count($matches) >= 4) {
            $this->replacedImg[] = $matches[2];
            $text = $matches[1] . '{{CROSS_LINK_IMG_' . (count($this->replacedImg) - 1) . '}}' . $matches[3];
        } elseif (isset($matches[0])) {
            $text = $matches[0];
        }

        return $text;
    }

    private function replaceHyperLink(array $matches): string
    {
        $text = '';
        if (count($matches) >= 4) {
            $this->replacedHyperLink[] = $matches[2];
            $text = $matches[1] . '{{CROSS_LINK_HYPERLINK_' . (count($this->replacedHyperLink) - 1) . '}}'
                . $matches[3];
        } elseif (isset($matches[0])) {
            $text = $matches[0];
        }

        return $text;
    }

    private function replaceAttribute(array $matches): string
    {
        $text = '';
        if (count($matches) >= 4) {
            $this->replacedAttribute[] = $matches[2];
            $text = $matches[1] . '{{CROSS_LINK_ATTRIBUTE_' . (count($this->replacedAttribute) - 1) . '}}'
                . $matches[3];
        } elseif (isset($matches[0])) {
            $text = $matches[0];
        }

        return $text;
    }

    /**
     * @param string $content
     *
     * @return string
     */
    private function returnScriptContent($content)
    {
        foreach ($this->replacedJs as $key => $js) {
            $content = str_replace('{{CROSS_LINK_' . $key . '}}', $js, $content);
        }

        return $content;
    }

    /**
     * @param string $content
     *
     * @return string
     */
    private function returnImageContent($content)
    {
        foreach ($this->replacedImg as $key => $image) {
            $content = str_replace('{{CROSS_LINK_IMG_' . $key . '}}', $image, $content);
        }

        return $content;
    }

    private function returnHyperLinkContent(string $content): string
    {
        foreach ($this->replacedHyperLink as $key => $hyperLink) {
            $content = str_replace('{{CROSS_LINK_HYPERLINK_' . $key . '}}', $hyperLink, $content);
        }

        return $content;
    }

    private function returnAttributeContent(string $content): string
    {
        foreach ($this->replacedAttribute as $key => $attribute) {
            $content = str_replace('{{CROSS_LINK_ATTRIBUTE_' . $key . '}}', $attribute, $content);
        }

        return $content;
    }
}
