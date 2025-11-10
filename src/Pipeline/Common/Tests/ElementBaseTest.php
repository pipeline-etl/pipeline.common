<?php

/**
 * This file contains the ElementBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests;

use Lunr\Halo\LunrBaseTestCase;
use Pipeline\Common\Element;

/**
 * This class contains tests for the Element class.
 *
 * @covers Pipeline\Common\Element
 */
class ElementBaseTest extends LunrBaseTestCase
{

    /**
     * Unit Test Data Provider for pipeline element class names.
     *
     * @return array Array of pipeline element class names.
     */
    public static function classNameProvider(): array
    {
        $values = [];

        $values['flattener']    = [ Element::Flattener, 'FooFlattener' ];
        $values['parser']       = [ Element::Parser, 'FooParser' ];
        $values['preprocessor'] = [ Element::Preprocessor, 'FooPreprocessor' ];
        $values['processor']    = [ Element::Processor, 'FooProcessor' ];
        $values['range']        = [ Element::Range, 'FooRange' ];
        $values['source']       = [ Element::Source, 'FooSource' ];

        return $values;
    }

    /**
     * Test getClassName().
     *
     * @param Element $element  Pipeline element
     * @param string  $expected Expected class name
     *
     * @dataProvider classNameProvider
     * @covers       Pipeline\Common\Element::getClassName
     */
    public function testGetClassName(Element $element, string $expected): void
    {
        $this->assertEquals($expected, $element->getClassName('foo'));
    }

    /**
     * Unit Test Data Provider for pipeline element namespaces.
     *
     * @return array Array of pipeline element namespaces.
     */
    public static function namespaceProvider(): array
    {
        $values = [];

        $values['flattener']    = [ Element::Flattener, 'Flatteners' ];
        $values['parser']       = [ Element::Parser, 'Parsers' ];
        $values['preprocessor'] = [ Element::Preprocessor, 'Preprocessors' ];
        $values['processor']    = [ Element::Processor, 'Processors' ];
        $values['range']        = [ Element::Range, 'Ranges' ];
        $values['source']       = [ Element::Source, 'Sources' ];

        return $values;
    }

    /**
     * Test getNamespaceIdentifier().
     *
     * @param Element $element  Pipeline element
     * @param string  $expected Expected namespace identifier
     *
     * @dataProvider namespaceProvider
     * @covers       Pipeline\Common\Element::getNamespaceIdentifier
     */
    public function testGetNamespaceIdentifier(Element $element, string $expected): void
    {
        $this->assertEquals($expected, $element->getNamespaceIdentifier());
    }

}

?>
