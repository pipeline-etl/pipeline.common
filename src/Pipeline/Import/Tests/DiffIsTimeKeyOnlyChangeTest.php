<?php

/**
 * This file contains the test class for the Diff class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import\Tests;

/**
 * Test class for the Diff class.
 *
 * @covers Pipeline\Import\Diff
 */
class DiffIsTimeKeyOnlyChangeTest extends DiffTestCase
{

    /**
     * Unit test data provider for time-key only changed data items.
     *
     * @return array $data
     */
    public static function timeKeyOnlyChangeProvider(): array
    {
        $items = [];

        $items['single time key'] = [
            [
                'id'       => 'foo',
                'name'     => 'Item 1',
                'revision' => 1,
            ],
            [
                'id'       => 'foo',
                'name'     => 'Item 1',
                'revision' => 2,
            ],
            [ 'revision' ],
        ];

        $items['multiple time keys'] = [
            [
                'id'        => 'foo',
                'name'      => 'Item 1',
                'revision'  => 1,
                'timestamp' => 1505121646,
            ],
            [
                'id'        => 'foo',
                'name'      => 'Item 1',
                'revision'  => 2,
                'timestamp' => 1505121746,
            ],
            [
                'revision',
                'timestamp',
            ],
        ];

        $items['type difference'] = [
            [
                'id'        => 'foo',
                'name'      => 'Item 1',
                'revision'  => '1',
                'timestamp' => '1505121646',
            ],
            [
                'id'        => 'foo',
                'name'      => 'Item 1',
                'revision'  => 2,
                'timestamp' => 1505121646,
            ],
            [ 'revision' ],
        ];

        return $items;
    }

    /**
     * Unit test data provider for changed data items.
     *
     * @return array $data
     */
    public static function changeProvider(): array
    {
        $items = [];

        $items['single time key'] = [
            [
                'id'       => 'foo',
                'name'     => 'Item 1',
                'revision' => 1,
            ],
            [
                'id'       => 'foo',
                'name'     => 'Item 1 - New',
                'revision' => 2,
            ],
            [ 'revision' ],
        ];

        $items['multiple time keys'] = [
            [
                'id'        => 'foo',
                'name'      => 'Item 1',
                'revision'  => 1,
                'timestamp' => 1505121646,
            ],
            [
                'id'        => 'foo',
                'name'      => 'Item 1 - New',
                'revision'  => 2,
                'timestamp' => 1505121746,
            ],
            [
                'revision',
                'timestamp',
            ],
        ];

        $items['type difference'] = [
            [
                'id'        => 'foo',
                'name'      => 'Item 1',
                'revision'  => '1',
                'timestamp' => '1505121646',
            ],
            [
                'id'        => 'foo',
                'name'      => 'Item 1 - New',
                'revision'  => 2,
                'timestamp' => 1505121646,
            ],
            [ 'revision' ],
        ];

        return $items;
    }

    /**
     * Test that isTimeKeyOnlyChange() returns FALSE if $new has more changes.
     *
     * @param array $old  Old data
     * @param array $new  New data
     * @param array $keys Time keys
     *
     * @dataProvider changeProvider
     * @covers       \Pipeline\Import\Diff::isTimeKeyOnlyChange
     */
    public function testIsTimeKeyOnlyChangeReturnsFalseIfMoreChanges($old, $new, $keys): void
    {
        $this->observer->expects($this->once())
                       ->method('getTimeKeys')
                       ->willReturn($keys);

        $method = $this->getReflectionMethod('isTimeKeyOnlyChange');

        $this->assertFalse($method->invokeArgs($this->class, [ $old, $new ]));
    }

    /**
     * Test that isTimeKeyOnlyChange() returns TRUE if $new has only changes in time keys.
     *
     * @param array $old  Old data
     * @param array $new  New data
     * @param array $keys Time keys
     *
     * @dataProvider timeKeyOnlyChangeProvider
     * @covers       \Pipeline\Import\Diff::isTimeKeyOnlyChange
     */
    public function testIsTimeKeyOnlyChangeReturnsTrueIfTimeKeyOnlyChange($old, $new, $keys): void
    {
        $this->observer->expects($this->once())
                       ->method('getTimeKeys')
                       ->willReturn($keys);

        $method = $this->getReflectionMethod('isTimeKeyOnlyChange');

        $this->assertTrue($method->invokeArgs($this->class, [ $old, $new ]));
    }

}

?>
