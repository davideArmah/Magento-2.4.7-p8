<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\Model;

use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
class PrefixJitClassesTest extends TestCase
{
    private $testCss = <<<EOCSS
.absolute {
position: absolute
}.relative {
position: relative
}.z-50 {
z-index: 50
}.mx-5 {
margin-left: 1.25rem;
margin-right: 1.25rem
}.flex {
display: flex
}.h-96 {
height: 24rem
}.w-72 {
width: 18rem
}.cursor-pointer {
cursor: pointer
}.flex-col {
flex-direction: column
}.items-center {
align-items: center
}.justify-end {
justify-content: flex-end
}.justify-center {
justify-content: center
}.overflow-hidden {
overflow: hidden
}.rounded-md {
border-radius: 0.375rem
}.bg-red-500 {
--tw-bg-opacity: 1;
background-color: rgba(239, 68, 68, var(--tw-bg-opacity))
}.object-cover {
object-fit: cover
}.p-4 {
padding: 1rem
}.p-3 {
padding: 0.75rem
}.font-semibold {
font-weight: 600
}.capitalize {
text-transform: capitalize
}.text-white {
--tw-text-opacity: 1;
color: rgba(255, 255, 255, var(--tw-text-opacity))
}.bg-[#000000] {
background-color: #000000
}.hover:focus:scale-[2.40] {
some generated: styles-here;
-even-more-generated: styles
}
EOCSS;

    private $cssClasses = [
        'absolute',
        'relative',
        'z-50',
        'mx-5',
        'flex',
        'h-96',
        'w-72',
        'cursor-pointer',
        'flex-col',
        'items-center',
        'justify-end',
        'justify-center',
        'overflow-hidden',
        'rounded-md',
        'bg-red-500',
        'object-cover',
        'p-4',
        'p-3',
        'font-semibold',
        'capitalize',
        'text-white',
        'bg-[#000000]',
        'hover:focus:scale-[2.40]',
    ];

    public function testReturnsEmptyClassListIfCssIsEmpty(): void
    {
        $sut = new PrefixJitClasses();
        $this->assertSame([], $sut->extractCssClassNamesFromStyles(''));
        $this->assertSame([], $sut->extractCssClassNamesFromStyles('<style></style>'));
    }

    public function testReturnsCssClassesWithoutSurroundingTag(): void
    {
        $sut = new PrefixJitClasses();
        $this->assertSame($this->cssClasses, $sut->extractCssClassNamesFromStyles($this->testCss));
    }

    public function testCmsPageExample(): void
    {
        $css = <<<EOCSS
.container {
width: 100%
}
@media (min-width: 640px) {
.container {
max-width: 640px
}
}
@media (min-width: 768px) {
.container {
max-width: 768px
}
}
@media (min-width: 1024px) {
.container {
max-width: 1024px
}
}
@media (min-width: 1280px) {
.container {
max-width: 1280px
}
}
@media (min-width: 1536px) {
.container {
max-width: 1536px
}
}
.mx-auto {
margin-left: auto;
margin-right: auto
}
.mt-5 {
margin-top: 1.25rem
}
.mt-2 {
margin-top: 0.5rem
}
.flex {
display: flex
}
.grid {
display: grid
}
.min-h-screen {
min-height: 100vh
}
.max-w-sm {
max-width: 24rem
}
.transform-gpu {
--tw-transform: translate3d(var(--tw-translate-x), var(--tw-translate-y), 0) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
}
.items-center {
align-items: center
}
.justify-between {
justify-content: space-between
}
.overflow-hidden {
overflow: hidden
}
.rounded-2xl {
border-radius: 1rem
}
.rounded-xl {
border-radius: 0.75rem
}
.rounded-lg {
border-radius: 0.5rem
}
.bg-gray-100 {
--tw-bg-opacity: 1;
background-color: rgba(243, 244, 246, var(--tw-bg-opacity))
}
.bg-white {
--tw-bg-opacity: 1;
background-color: rgba(255, 255, 255, var(--tw-bg-opacity))
}
.bg-green-400 {
--tw-bg-opacity: 1;
background-color: rgba(52, 211, 153, var(--tw-bg-opacity))
}
.p-9 {
padding: 2.25rem
}
.py-2 {
padding-top: 0.5rem;
padding-bottom: 0.5rem
}
.px-4 {
padding-left: 1rem;
padding-right: 1rem
}
.text-2xl {
font-size: 1.5rem;
line-height: 2rem
}
.font-semibold {
font-weight: 600
}
.text-white {
--tw-text-opacity: 1;
color: rgba(255, 255, 255, var(--tw-text-opacity))
}
.shadow-xl {
--tw-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
}
.shadow-md {
--tw-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
}
.transition {
transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
transition-duration: 150ms
}
.duration-300 {
transition-duration: 300ms
}
.duration-500 {
transition-duration: 500ms
}
.hover\:scale-110:hover {
--tw-scale-x: 1.1;
--tw-scale-y: 1.1;
transform: var(--tw-transform)
}
.hover\:shadow-2xl:hover {
--tw-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
}
.hover\:shadow-lg:hover {
--tw-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
}
EOCSS;

        $html = <<<EOHTML
<style>#html-body [data-pb-style=G9MYVDT]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="html" data-appearance="default" data-element="main">&lt;div class="min-h-screen bg-gray-100 flex items-center"&gt;
  &lt;div class="container mx-auto p-9 bg-white max-w-sm rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition duration-300"&gt;
    &lt;img class="rounded-xl" src="https://images.unsplash.com/photo-1547517023-7ca0c162f816" alt="" /&gt;
    &lt;div class="flex justify-between items-center"&gt;
      &lt;div&gt;
        &lt;h1 class="mt-5 text-2xl font-semibold"&gt;Aloe Cactus&lt;/h1&gt;
        &lt;p class="mt-2"&gt;$11.99&lt;/p&gt;
      &lt;/div&gt;
      &lt;div&gt;
        &lt;button class="text-white text-md font-semibold bg-green-400 py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-500 transform-gpu hover:scale-110 "&gt;Buy Now&lt;/button&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;</div><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="G9MYVDT"><div data-content-type="products" data-appearance="grid" data-element="main">{{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Magento_CatalogWidget::product/widget/content/grid.phtml" anchor_text="" id_path="" show_pager="0" products_count="1" condition_option="category_ids" condition_option_value="22" type_name="Catalog Products List" conditions_encoded="^[`1`:^[`aggregator`:`all`,`new_child`:``,`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`value`:`1`^],`1--1`:^[`operator`:`==`,`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`value`:`22`^]^]" sort_order="position"}}</div></div></div>
EOHTML;

        $expected = <<<EOHTML
<style>#html-body [data-pb-style=G9MYVDT]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="html" data-appearance="default" data-element="main">&lt;div class="x-min-h-screen x-bg-gray-100 x-flex x-items-center"&gt;
  &lt;div class="x-container x-mx-auto x-p-9 x-bg-white x-max-w-sm x-rounded-2xl x-overflow-hidden x-shadow-xl x-hover:shadow-2xl x-transition x-duration-300"&gt;
    &lt;img class="x-rounded-xl" src="https://images.unsplash.com/photo-1547517023-7ca0c162f816" alt="" /&gt;
    &lt;div class="x-flex x-justify-between x-items-center"&gt;
      &lt;div&gt;
        &lt;h1 class="x-mt-5 x-text-2xl x-font-semibold"&gt;Aloe Cactus&lt;/h1&gt;
        &lt;p class="x-mt-2"&gt;$11.99&lt;/p&gt;
      &lt;/div&gt;
      &lt;div&gt;
        &lt;button class="x-text-white text-md x-font-semibold x-bg-green-400 x-py-2 x-px-4 x-rounded-lg x-shadow-md x-hover:shadow-lg x-transition x-duration-500 x-transform-gpu x-hover:scale-110 "&gt;Buy Now&lt;/button&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;</div><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="G9MYVDT"><div data-content-type="products" data-appearance="grid" data-element="main">{{widget type="Magento\CatalogWidget\Block\Product\ProductsList" template="Magento_CatalogWidget::product/widget/content/grid.phtml" anchor_text="" id_path="" show_pager="0" products_count="1" condition_option="category_ids" condition_option_value="22" type_name="Catalog Products List" conditions_encoded="^[`1`:^[`aggregator`:`all`,`new_child`:``,`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,`value`:`1`^],`1--1`:^[`operator`:`==`,`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,`attribute`:`category_ids`,`value`:`22`^]^]" sort_order="position"}}</div></div></div>
EOHTML;

        $sut = new PrefixJitClasses();
        $this->assertSame($expected, $sut->prefixJitClassesInHtml($css, $html, 'x-'));
    }

    public function testCmsBlockExample(): void
    {
        $html = <<<EOHTML
<footer aria-labelledby="some-footer" class="bg-white border-t border-gray-200">
  <h2 id="some-footer" class="sr-only">Footer</h2>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-20 grid grid-cols-2 gap-8 sm:gap-y-0 sm:grid-cols-2 lg:grid-cols-4">
        <div class="grid grid-cols-1 gap-y-10 lg:col-span-2 lg:grid-cols-2 lg:gap-y-0 lg:gap-x-8">
          {{block class="Magento\\Cms\\Block\\Block" block_id="a"}}
          {{block class="Magento\\Cms\\Block\\Block" block_id="b"}}
        </div>
        <div class="grid grid-cols-1 gap-y-10 lg:col-span-2 lg:grid-cols-2 lg:gap-y-0 lg:gap-x-8">
          {{block class="Magento\\Cms\\Block\\Block" block_id="c"}}
          {{block class="Magento\\Cms\\Block\\Block" block_id="d"}}
        </div>
    </div>
  </div>
</footer>
EOHTML;

        $generatedCss = <<<EOCSS
.sr-only {
position: absolute;
width: 1px;
height: 1px;
padding: 0;
margin: -1px;
overflow: hidden;
clip: rect(0, 0, 0, 0);
white-space: nowrap;
border-width: 0
}
.mx-auto {
margin-left: auto;
margin-right: auto
}
.block {
display: block
}
.grid {
display: grid
}
.max-w-7xl {
max-width: 80rem
}
.grid-cols-2 {
grid-template-columns: repeat(2, minmax(0, 1fr))
}
.grid-cols-1 {
grid-template-columns: repeat(1, minmax(0, 1fr))
}
.gap-8 {
gap: 2rem
}
.gap-y-10 {
row-gap: 2.5rem
}
.border-t {
border-top-width: 1px
}
.border-gray-200 {
--tw-border-opacity: 1;
border-color: rgba(229, 231, 235, var(--tw-border-opacity))
}
.bg-white {
--tw-bg-opacity: 1;
background-color: rgba(255, 255, 255, var(--tw-bg-opacity))
}
.px-4 {
padding-left: 1rem;
padding-right: 1rem
}
.py-20 {
padding-top: 5rem;
padding-bottom: 5rem
}
@media (min-width: 640px) {
.sm\:grid-cols-2 {
grid-template-columns: repeat(2, minmax(0, 1fr))
}
.sm\:gap-y-0 {
row-gap: 0px
}
.sm\:px-6 {
padding-left: 1.5rem;
padding-right: 1.5rem
}
}
@media (min-width: 1024px) {
.lg\:col-span-2 {
grid-column: span 2 / span 2
}
.lg\:grid-cols-4 {
grid-template-columns: repeat(4, minmax(0, 1fr))
}
.lg\:grid-cols-2 {
grid-template-columns: repeat(2, minmax(0, 1fr))
}
.lg\:gap-y-0 {
row-gap: 0px
}
.lg\:gap-x-8 {
column-gap: 2rem
}
.lg\:px-8 {
padding-left: 2rem;
padding-right: 2rem
}
}
EOCSS;

        $expected = <<<EOHTML
<footer aria-labelledby="some-footer" class="x-bg-white x-border-t x-border-gray-200">
  <h2 id="some-footer" class="x-sr-only">Footer</h2>
  <div class="x-max-w-7xl x-mx-auto x-px-4 x-sm:px-6 x-lg:px-8">
    <div class="x-py-20 x-grid x-grid-cols-2 x-gap-8 x-sm:gap-y-0 x-sm:grid-cols-2 x-lg:grid-cols-4">
        <div class="x-grid x-grid-cols-1 x-gap-y-10 x-lg:col-span-2 x-lg:grid-cols-2 x-lg:gap-y-0 x-lg:gap-x-8">
          {{block class="Magento\\Cms\\Block\\Block" block_id="a"}}
          {{block class="Magento\\Cms\\Block\\Block" block_id="b"}}
        </div>
        <div class="x-grid x-grid-cols-1 x-gap-y-10 x-lg:col-span-2 x-lg:grid-cols-2 x-lg:gap-y-0 x-lg:gap-x-8">
          {{block class="Magento\\Cms\\Block\\Block" block_id="c"}}
          {{block class="Magento\\Cms\\Block\\Block" block_id="d"}}
        </div>
    </div>
  </div>
</footer>
EOHTML;

        $sut = new PrefixJitClasses();
        $this->assertSame($expected, $sut->prefixJitClassesInHtml($generatedCss, $html, 'x-'));
    }

    /**
     * @dataProvider  dataProvider
     */
    public function testPrefixesGeneratedClasses(
        string $html,
        string $expectedHtml,
        string $css,
        string $expectedCss
    ): void {
        $sut = new PrefixJitClasses();

        $this->assertSame(
            $expectedCss,
            $sut->prefixJitClassesInCss($css, 'xxx-'),
            'The prefixJitClassesInCss result is not as expected'
        );
        $this->assertSame(
            $expectedHtml,
            $sut->prefixJitClassesInHtml($css, $html, 'xxx-'),
            'The prefixJitClassesInHtml result is not as expected'
        );
    }

    public function dataProvider(): array
    {
        return [
            [
                '<div class="foo bar z-50"></div>',
                '<div class="foo bar xxx-z-50"></div>',
                '.z-50 { z-index: 50 } .flex { display: flex } .h-96 { height: 24rem }',
                '.xxx-z-50 { z-index: 50 } .xxx-flex { display: flex } .xxx-h-96 { height: 24rem }'
            ],
            [
                '<div class="z-50"></div>',
                '<div class="xxx-z-50"></div>',
                '.z-50 { z-index: 50 }',
                '.xxx-z-50 { z-index: 50 }'
            ],
            [
                '<div class="
z-50
"></div>',
                '<div class="
xxx-z-50
"></div>',
                '.z-50 { z-index: 50 }',
                '.xxx-z-50 { z-index: 50 }'
            ],
            [
                '<div class="foo bar"></div>',
                '<div class="foo bar"></div>',
                '.z-50 { z-index: 50 }',
                '.xxx-z-50 { z-index: 50 }'
            ],
            [
                '<div class="foo mt-8">
                   a
                   <div class="bg-[#112233] bar">b</div>
                   c
                 </div>
                 <div class="hover:font-bold">d</div>',

                '<div class="foo xxx-mt-8">
                   a
                   <div class="xxx-bg-[#112233] bar">b</div>
                   c
                 </div>
                 <div class="xxx-hover:font-bold">d</div>',
                '.mt-8 {a: b} .bg-[#112233] {a:b} .hover\:font-bold:hover {a:b}',
                '.xxx-mt-8 {a: b} .xxx-bg-[#112233] {a:b} .xxx-hover\:font-bold:hover {a:b}'
            ],
            [
                '<div class="hover:focus:scale-[2.4]"></div>',
                '<div class="xxx-hover:focus:scale-[2.4]"></div>',
                '.hover\:focus\:scale-[2.4]:hover:focus { a: b }',
                '.xxx-hover\:focus\:scale-[2.4]:hover:focus { a: b }'
            ],
            [
                '<div class=""></div>',
                '<div class=""></div>',
                '.foo { a: b }',
                '.xxx-foo { a: b }'
            ],
            [
                '<div class="w-1/2"></div>',
                '<div class="xxx-w-1/2"></div>',
                '@media (min-width: 640px) { .w-1/2 { width: 50% }',
                '@media (min-width: 640px) { .xxx-w-1/2 { width: 50% }'
            ],
            [
                '<div class="sm:w-1/2"></div>',
                '<div class="xxx-sm:w-1/2"></div>',
                '@media (min-width: 640px) { .sm\:w-1/2 { width: 50% }',
                '@media (min-width: 640px) { .xxx-sm\:w-1/2 { width: 50% }'
            ],
            [
                '<div class="2xl:bg-green-400"></div>',
                '<div class="xxx-2xl:bg-green-400"></div>',
                '@media (min-width: 640px) { .\32xl\:bg-green-400 { width: 50% }',
                '@media (min-width: 640px) { .xxx-\32xl\:bg-green-400 { width: 50% }'
            ],
            [
                '<div class="xl:w-1/4"></div>',
                '<div class="xxx-xl:w-1/4"></div>',
                '@media (min-width: 1024px) { .xl\:w-1\/4 { width: 25% } }',
                '@media (min-width: 1024px) { .xxx-xl\:w-1\/4 { width: 25% } }'
            ],
            [
                '<div class="hover:focus:scale-[2.4]"></div>',
                '<div class="hover:focus:scale-[2.4]"></div>',
                '',
                ''
            ],
            [
                '<div class="max-w-1300 gap-10"></div>',
                '<div class="xxx-max-w-1300 xxx-gap-10"></div>',
                '.max-w-1300 {a:b} .gap-10 {a:b}',
                '.xxx-max-w-1300 {a:b} .xxx-gap-10 {a:b}'
            ],
            [
                '<div class="h-[918px]"></div>',
                '<div class="xxx-h-[918px]"></div>',
                '.h-\[918px\] {height: 918px}',
                '.xxx-h-\[918px\] {height: 918px}'
            ],
            [
                '<div class="text-[#800080]"></div>',
                '<div class="xxx-text-[#800080]"></div>',
                '.text-\[\#800080\] {a: b}',
                '.xxx-text-\[\#800080\] {a: b}'
            ],
            [
                '<div class="before:block before:float-left before:pt-[100%]"></div>',
                '<div class="xxx-before:block xxx-before:float-left xxx-before:pt-[100%]"></div>',
                '.before\:float-left::before {a: b} .before\:block::before {a: b} .before\:pt-\[100\%\]::before {a: b}',
                '.xxx-before\:float-left::before {a: b} .xxx-before\:block::before {a: b} .xxx-before\:pt-\[100\%\]::before {a: b}'
            ],
            [
                '<div data-content="hello world" class="before:content-[attr(data-content)] before:block"></div>',
                '<div data-content="hello world" class="xxx-before:content-[attr(data-content)] xxx-before:block"></div>',
                '.before\:block::before { content: ""; display: block }
                 .before\:content-\[attr\(data-content\)\]::before { content: attr(data-content) }',
                '.xxx-before\:block::before { content: ""; display: block }
                 .xxx-before\:content-\[attr\(data-content\)\]::before { content: attr(data-content) }'
            ],
            [
                '<input class="valid:border-blue-500"/>',
                '<input class="xxx-valid:border-blue-500"/>',
                '.valid\:border-blue-500:valid { --tw-border-opacity: 1; border-color: rgba(59, 130, 246, var(--tw-border-opacity)) }',
                '.xxx-valid\:border-blue-500:valid { --tw-border-opacity: 1; border-color: rgba(59, 130, 246, var(--tw-border-opacity)) }'
            ],
            [
                '<div x-data="{open:false}"><h1 @click="open=!open">Header</h1><p :class="{ \'hidden\':!open }">Content</p></div>',
                '<div x-data="{open:false}"><h1 @click="open=!open">Header</h1><p :class="{ \'hidden\':!open }">Content</p></div>',
                '.prose {}',
                '.xxx-prose {}'
            ],
            [
                '<div data-objectclass="arbitrary application data">Content</p></div>',
                '<div data-objectclass="arbitrary application data">Content</p></div>',
                '.arbitrary {}',
                '.xxx-arbitrary {}'
            ],
            [
                '<div
class="foo"></div>',
                '<div class="xxx-foo"></div>',
                '.foo { a: b }',
                '.xxx-foo { a: b }'
            ],
            [
                '<div></div><div class="foo"></div>',
                '<div></div><div class="xxx-foo"></div>',
                '.foo { a: b }',
                '.xxx-foo { a: b }'
            ],
            [
                '<div class=""></div><div class="foo"></div>',
                '<div class=""></div><div class="xxx-foo"></div>',
                '.foo { a: b }',
                '.xxx-foo { a: b }'
            ],
            [
                '<div class="space-x-4"></div>',
                '<div class="xxx-space-x-4"></div>',
                '.space-x-4 > :not([hidden]) ~ :not([hidden]) {}',
                '.xxx-space-x-4 > :not([hidden]) ~ :not([hidden]) {}'
            ],
            [
                '<div class="scale-50"></div>',
                '<div class="xxx-scale-50"></div>',
                '.scale-50 { --tw-scale-x: .5; --tw-scale-y: .5; transform: var(--tw-transform) }',
                '.xxx-scale-50 { --tw-scale-x: .5; --tw-scale-y: .5; transform: var(--tw-transform) }'
            ],
            [
                '<details class="group"><span class="group-open:text-blue-600"></span></details>',
                '<details class="xxx-group"><span class="xxx-group-open:text-blue-600"></span></details>',
                '.group[open] .group-open\:text-blue-600 { color: rgb(37 99 235 / var(--tw-text-opacity)) }',
                '.xxx-group[open] .xxx-group-open\:text-blue-600 { color: rgb(37 99 235 / var(--tw-text-opacity)) }'
            ],
            [
                '<details class="group"><span class="group-aria-expanded:text-blue-600"></span></details>',
                '<details class="xxx-group"><span class="xxx-group-aria-expanded:text-blue-600"></span></details>',
                '.group[aria-expanded="true"] .group-aria-expanded\:text-blue-600 { color: rgb(37 99 235 / var(--tw-text-opacity)) }',
                '.xxx-group[aria-expanded="true"] .xxx-group-aria-expanded\:text-blue-600 { color: rgb(37 99 235 / var(--tw-text-opacity)) }'
            ],
            [
                '<div class="z-50" :class="{\'valid:border-blue-500 bar\': activeTab === 0}"></div>',
                '<div class="xxx-z-50" :class="{\'xxx-valid:border-blue-500 bar\': activeTab === 0}"></div>',
                '.z-50 { z-index: 50 } .valid\:border-blue-500:valid { --tw-border-opacity: 1; border-color: rgba(59, 130, 246, var(--tw-border-opacity)) }',
                '.xxx-z-50 { z-index: 50 } .xxx-valid\:border-blue-500:valid { --tw-border-opacity: 1; border-color: rgba(59, 130, 246, var(--tw-border-opacity)) }',
            ],
            [
                '{{icon "heroicons/solid/shopping-cart" classes="w-6 h-6 text-blue-800" width=12 height=12}}',
                '{{icon "heroicons/solid/shopping-cart" classes="xxx-w-6 xxx-h-6 xxx-text-blue-800" width=12 height=12}}',
                '.w-6 {} .h-6 {} .text-blue-800 {}',
                '.xxx-w-6 {} .xxx-h-6 {} .xxx-text-blue-800 {}',
            ],
            [
                '<div class="before:content-[\'foo\']" :class="{\'after:content-[\\\'bar\\\']\': activeTab === 0}"></div>',
                '<div class="xxx-before:content-[\'foo\']" :class="{\'xxx-after:content-[\\\'bar\\\']\': activeTab === 0}"></div>',
                '.before\:content-\[\\\'foo\\\'\]::before {a: b} .after\:content-\[\\\'bar\\\'\]::before {a: b}',
                '.xxx-before\:content-\[\\\'foo\\\'\]::before {a: b} .xxx-after\:content-\[\\\'bar\\\'\]::before {a: b}',
            ],
            [
                '<div x-bind:class="{\'after:content-[\\\'bar\\\']\': activeTab === 0}"></div>',
                '<div x-bind:class="{\'xxx-after:content-[\\\'bar\\\']\': activeTab === 0}"></div>',
                '.after\:content-\[\\\'bar\\\'\]::before {a: b}',
                '.xxx-after\:content-\[\\\'bar\\\'\]::before {a: b}',
            ],
            [
                '<div :class=\'{"after:content-[\\"bar\\"]": activeTab === 0}\'></div>',
                '<div :class=\'{"xxx-after:content-[\\"bar\\"]": activeTab === 0}\'></div>',
                '.after\:content-\[\\\"bar\\\"\]::after {a: b}',
                '.xxx-after\:content-\[\\\"bar\\\"\]::after {a: b}',
            ],
            [
                '<div class="from-[rgba(67,103,119,0.4)]"></div>',
                '<div class="xxx-from-[rgba(67,103,119,0.4)]"></div>',
                '.from-\[rgba\(67\2c 103\2c 119\2c 0\.4)\] {a: b}',
                '.xxx-from-\[rgba\(67\2c 103\2c 119\2c 0\.4)\] {a: b}',
            ],
            [
                '<div class="bg-[url(https://unsplash.com/photos/XtnNrQYC7ts/download?force=true&fit=crop&auto=format&w=120&h=120&q=80)]"></div>',
                '<div class="xxx-bg-[url(https://unsplash.com/photos/XtnNrQYC7ts/download?force=true&fit=crop&auto=format&w=120&h=120&q=80)]"></div>',
                '.bg-\[url\(https\:\/\/unsplash\.com\/photos\/XtnNrQYC7ts\/download\?force\=true\&fit\=crop\&auto\=format\&w\=120\&h\=120\&q\=80\)\] {a: b}',
                '.xxx-bg-\[url\(https\:\/\/unsplash\.com\/photos\/XtnNrQYC7ts\/download\?force\=true\&fit\=crop\&auto\=format\&w\=120\&h\=120\&q\=80\)\] {a: b}',
            ],
        ];
    }
}
