<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes 2020-present. All rights reserved.
 * This product is licensed per Magento install
 * See https://hyva.io/license
 */

declare(strict_types=1);

namespace Hyva\CmsTailwindJit\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.LongClassName)
 */
class RemoveWrapperClassFromGeneratedStylesTest extends TestCase
{
    private $generatedCss = <<<EOCSS
.jit-cmsp-5 .mx-auto {
margin-left: auto;
margin-right: auto
}.jit-cmsp-5 .mb-2 {
margin-bottom: 0.5rem
}.jit-cmsp-5 .mb-5 {
margin-bottom: 1.25rem
}.jit-cmsp-5 .mt-2 {
margin-top: 0.5rem
}.jit-cmsp-5 .mt-5 {
margin-top: 1.25rem
}.jit-cmsp-5 .mb-3 {
margin-bottom: 0.75rem
}.jit-cmsp-5 .mr-3 {
margin-right: 0.75rem
}.jit-cmsp-5 .flex {
display: flex
}.jit-cmsp-5 .inline-flex {
display: inline-flex
}.jit-cmsp-5 .h-screen {
height: 100vh
}.jit-cmsp-5 .h-6 {
height: 1.5rem
}.jit-cmsp-5 .h-36 {
height: 9rem
}.jit-cmsp-5 .h-10 {
height: 2.5rem
}.jit-cmsp-5 .w-11\/12 {
width: 91.666667%
}.jit-cmsp-5 .w-6 {
width: 1.5rem
}.jit-cmsp-5 .w-full {
width: 100%
}.jit-cmsp-5 .w-10 {
width: 2.5rem
}.jit-cmsp-5 .max-w-2xl {
max-width: 42rem
}.jit-cmsp-5 .appearance-none {
appearance: none
}.jit-cmsp-5 .flex-row {
flex-direction: row
}.jit-cmsp-5 .flex-col {
flex-direction: column
}.jit-cmsp-5 .items-center {
align-items: center
}.jit-cmsp-5 .justify-center {
justify-content: center
}.jit-cmsp-5 .justify-between {
justify-content: space-between
}.jit-cmsp-5 .space-x-4 > :not([hidden]) ~ :not([hidden]) {
--tw-space-x-reverse: 0;
margin-right: calc(1rem * var(--tw-space-x-reverse));
margin-left: calc(1rem * calc(1 - var(--tw-space-x-reverse)))
}.jit-cmsp-5 .rounded-lg {
border-radius: 0.5rem
}.jit-cmsp-5 .rounded {
border-radius: 0.25rem
}.jit-cmsp-5 .rounded-full {
border-radius: 9999px
}.jit-cmsp-5 .rounded-tl-lg {
border-top-left-radius: 0.5rem
}.jit-cmsp-5 .rounded-tr-lg {
border-top-right-radius: 0.5rem
}.jit-cmsp-5 .rounded-bl-lg {
border-bottom-left-radius: 0.5rem
}.jit-cmsp-5 .rounded-br-lg {
border-bottom-right-radius: 0.5rem
}.jit-cmsp-5 .border {
border-width: 1px
}.jit-cmsp-5 .border-b {
border-bottom-width: 1px
}.jit-cmsp-5 .border-t {
border-top-width: 1px
}.jit-cmsp-5 .border-gray-300 {
--tw-border-opacity: 1;
border-color: rgba(209, 213, 219, var(--tw-border-opacity))
}.jit-cmsp-5 .border-gray-200 {
--tw-border-opacity: 1;
border-color: rgba(229, 231, 235, var(--tw-border-opacity))
}.jit-cmsp-5 .bg-gray-200 {
--tw-bg-opacity: 1;
background-color: rgba(229, 231, 235, var(--tw-bg-opacity))
}.jit-cmsp-5 .bg-white {
--tw-bg-opacity: 1;
background-color: rgba(255, 255, 255, var(--tw-bg-opacity))
}.jit-cmsp-5 .bg-gray-50 {
--tw-bg-opacity: 1;
background-color: rgba(249, 250, 251, var(--tw-bg-opacity))
}.jit-cmsp-5 .bg-blue-500 {
--tw-bg-opacity: 1;
background-color: rgba(59, 130, 246, var(--tw-bg-opacity))
}.jit-cmsp-5 .p-6 {
padding: 1.5rem
}.jit-cmsp-5 .p-5 {
padding: 1.25rem
}.jit-cmsp-5 .px-6 {
padding-left: 1.5rem;
padding-right: 1.5rem
}.jit-cmsp-5 .py-5 {
padding-top: 1.25rem;
padding-bottom: 1.25rem
}.jit-cmsp-5 .px-4 {
padding-left: 1rem;
padding-right: 1rem
}.jit-cmsp-5 .py-2 {
padding-top: 0.5rem;
padding-bottom: 0.5rem
}.jit-cmsp-5 .font-semibold {
font-weight: 600
}.jit-cmsp-5 .text-gray-800 {
--tw-text-opacity: 1;
color: rgba(31, 41, 55, var(--tw-text-opacity))
}.jit-cmsp-5 .text-gray-700 {
--tw-text-opacity: 1;
color: rgba(55, 65, 81, var(--tw-text-opacity))
}.jit-cmsp-5 .text-gray-400 {
--tw-text-opacity: 1;
color: rgba(156, 163, 175, var(--tw-text-opacity))
}.jit-cmsp-5 .text-blue-500 {
--tw-text-opacity: 1;
color: rgba(59, 130, 246, var(--tw-text-opacity))
}.jit-cmsp-5 .text-red-400 {
--tw-text-opacity: 1;
color: rgba(248, 113, 113, var(--tw-text-opacity))
}.jit-cmsp-5 .text-gray-600 {
--tw-text-opacity: 1;
color: rgba(75, 85, 99, var(--tw-text-opacity))
}.jit-cmsp-5 .text-white {
--tw-text-opacity: 1;
color: rgba(255, 255, 255, var(--tw-text-opacity))
}.jit-cmsp-5 .antialiased {
-webkit-font-smoothing: antialiased;
-moz-osx-font-smoothing: grayscale
}.jit-cmsp-5 .shadow-xl {
--tw-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
}.jit-cmsp-5 .shadow-sm {
--tw-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
}
@media (min-width: 640px) {.jit-cmsp-5 .sm\:mt-0 {
margin-top: 0px
}.jit-cmsp-5 .sm\:w-5\/6 {
width: 83.333333%
}.jit-cmsp-5 .sm\:w-1\/2 {
width: 50%
}.jit-cmsp-5 .sm\:flex-row {
flex-direction: row
}.jit-cmsp-5 .sm\:space-x-5 > :not([hidden]) ~ :not([hidden]) {
--tw-space-x-reverse: 0;
margin-right: calc(1.25rem * var(--tw-space-x-reverse));
margin-left: calc(1.25rem * calc(1 - var(--tw-space-x-reverse)))
}
}
@media (min-width: 1024px) {.jit-cmsp-5 .lg\:w-1\/2 {
width: 50%
}
}
EOCSS;

    private $cleanedCss = <<<EOCSS
.mx-auto {
margin-left: auto;
margin-right: auto
}.mb-2 {
margin-bottom: 0.5rem
}.mb-5 {
margin-bottom: 1.25rem
}.mt-2 {
margin-top: 0.5rem
}.mt-5 {
margin-top: 1.25rem
}.mb-3 {
margin-bottom: 0.75rem
}.mr-3 {
margin-right: 0.75rem
}.flex {
display: flex
}.inline-flex {
display: inline-flex
}.h-screen {
height: 100vh
}.h-6 {
height: 1.5rem
}.h-36 {
height: 9rem
}.h-10 {
height: 2.5rem
}.w-11\/12 {
width: 91.666667%
}.w-6 {
width: 1.5rem
}.w-full {
width: 100%
}.w-10 {
width: 2.5rem
}.max-w-2xl {
max-width: 42rem
}.appearance-none {
appearance: none
}.flex-row {
flex-direction: row
}.flex-col {
flex-direction: column
}.items-center {
align-items: center
}.justify-center {
justify-content: center
}.justify-between {
justify-content: space-between
}.space-x-4 > :not([hidden]) ~ :not([hidden]) {
--tw-space-x-reverse: 0;
margin-right: calc(1rem * var(--tw-space-x-reverse));
margin-left: calc(1rem * calc(1 - var(--tw-space-x-reverse)))
}.rounded-lg {
border-radius: 0.5rem
}.rounded {
border-radius: 0.25rem
}.rounded-full {
border-radius: 9999px
}.rounded-tl-lg {
border-top-left-radius: 0.5rem
}.rounded-tr-lg {
border-top-right-radius: 0.5rem
}.rounded-bl-lg {
border-bottom-left-radius: 0.5rem
}.rounded-br-lg {
border-bottom-right-radius: 0.5rem
}.border {
border-width: 1px
}.border-b {
border-bottom-width: 1px
}.border-t {
border-top-width: 1px
}.border-gray-300 {
--tw-border-opacity: 1;
border-color: rgba(209, 213, 219, var(--tw-border-opacity))
}.border-gray-200 {
--tw-border-opacity: 1;
border-color: rgba(229, 231, 235, var(--tw-border-opacity))
}.bg-gray-200 {
--tw-bg-opacity: 1;
background-color: rgba(229, 231, 235, var(--tw-bg-opacity))
}.bg-white {
--tw-bg-opacity: 1;
background-color: rgba(255, 255, 255, var(--tw-bg-opacity))
}.bg-gray-50 {
--tw-bg-opacity: 1;
background-color: rgba(249, 250, 251, var(--tw-bg-opacity))
}.bg-blue-500 {
--tw-bg-opacity: 1;
background-color: rgba(59, 130, 246, var(--tw-bg-opacity))
}.p-6 {
padding: 1.5rem
}.p-5 {
padding: 1.25rem
}.px-6 {
padding-left: 1.5rem;
padding-right: 1.5rem
}.py-5 {
padding-top: 1.25rem;
padding-bottom: 1.25rem
}.px-4 {
padding-left: 1rem;
padding-right: 1rem
}.py-2 {
padding-top: 0.5rem;
padding-bottom: 0.5rem
}.font-semibold {
font-weight: 600
}.text-gray-800 {
--tw-text-opacity: 1;
color: rgba(31, 41, 55, var(--tw-text-opacity))
}.text-gray-700 {
--tw-text-opacity: 1;
color: rgba(55, 65, 81, var(--tw-text-opacity))
}.text-gray-400 {
--tw-text-opacity: 1;
color: rgba(156, 163, 175, var(--tw-text-opacity))
}.text-blue-500 {
--tw-text-opacity: 1;
color: rgba(59, 130, 246, var(--tw-text-opacity))
}.text-red-400 {
--tw-text-opacity: 1;
color: rgba(248, 113, 113, var(--tw-text-opacity))
}.text-gray-600 {
--tw-text-opacity: 1;
color: rgba(75, 85, 99, var(--tw-text-opacity))
}.text-white {
--tw-text-opacity: 1;
color: rgba(255, 255, 255, var(--tw-text-opacity))
}.antialiased {
-webkit-font-smoothing: antialiased;
-moz-osx-font-smoothing: grayscale
}.shadow-xl {
--tw-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
}.shadow-sm {
--tw-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
}
@media (min-width: 640px) {.sm\:mt-0 {
margin-top: 0px
}.sm\:w-5\/6 {
width: 83.333333%
}.sm\:w-1\/2 {
width: 50%
}.sm\:flex-row {
flex-direction: row
}.sm\:space-x-5 > :not([hidden]) ~ :not([hidden]) {
--tw-space-x-reverse: 0;
margin-right: calc(1.25rem * var(--tw-space-x-reverse));
margin-left: calc(1.25rem * calc(1 - var(--tw-space-x-reverse)))
}
}
@media (min-width: 1024px) {.lg\:w-1\/2 {
width: 50%
}
}
EOCSS;

    public function testRemovesJitWrapperClass(): void
    {
        $sut = new RemoveWrapperClassFromGeneratedStyles($this->createMock(ModuleDataSetupInterface::class));

        $this->assertSame('', $sut->removeWrapperClassFromStyles(''));
    }

    public function testKeepsNonWrappedStyles(): void
    {
        $sut = new RemoveWrapperClassFromGeneratedStyles($this->createMock(ModuleDataSetupInterface::class));

        $css = '@media (min-width: 1024px) {.lg\:w-1\/2 { width: 50% } }';
        $this->assertSame($css, $sut->removeWrapperClassFromStyles($css));
    }

    public function testKeepsJitStyleIfItDoesNotWrappATailwindStyle(): void
    {
        $sut = new RemoveWrapperClassFromGeneratedStyles($this->createMock(ModuleDataSetupInterface::class));

        $css = '.jit-cmsp-5 { margin-right: 0.75rem }';
        $this->assertSame($css, $sut->removeWrapperClassFromStyles($css));
    }

    public function testRemovesCmsBlockWrapperClass(): void
    {
        $sut = new RemoveWrapperClassFromGeneratedStyles($this->createMock(ModuleDataSetupInterface::class));

        $css = '.jit-cmsp-5 .rounded-tr-lg { border-top-right-radius: 0.5rem }';
        $expected = '.rounded-tr-lg { border-top-right-radius: 0.5rem }';
        $this->assertSame($expected, $sut->removeWrapperClassFromStyles($css));
    }

    public function testRemovesWrapperCmsFromRealExample(): void
    {
        $sut = new RemoveWrapperClassFromGeneratedStyles($this->createMock(ModuleDataSetupInterface::class));
        $this->assertSame($this->cleanedCss, $sut->removeWrapperClassFromStyles($this->generatedCss));
    }
}
