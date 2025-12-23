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
class DiffShouldSkipItemTest extends DiffTestCase
{

    /**
     * Test that shouldSkipItem() returns TRUE if old item newer.
     *
     * @covers \Pipeline\Import\Diff::shouldSkipItem
     */
    public function testShouldSkipItemWhenOldItemNewer(): void
    {
        $old = [
            'id'        => 'AB12',
            'timestamp' => 1415116207,
            'key'       => 'ABC',
            'bool'      => 0,
        ];

        $new = [
            'id'        => 'AB12',
            'timestamp' => 1415116107,
            'key'       => 'ABC',
            'bool'      => FALSE,
        ];

        $this->observer->expects($this->once())
                       ->method('getTimeKeys')
                       ->willReturn([ 'timestamp' ]);

        $method = $this->getReflectionMethod('shouldSkipItem');

        $this->assertTrue($method->invokeArgs($this->class, [ $old, $new ]));
    }

    /**
     * Test that shouldSkipItem() returns TRUE if there's a time key only change.
     *
     * @covers \Pipeline\Import\Diff::shouldSkipItem
     */
    public function testShouldSkipItemWhenTimeKeyOnlyChange(): void
    {
        $old = [
            'id'        => 'AB12',
            'timestamp' => 1415116107,
            'key'       => 'ABC',
            'bool'      => 0,
        ];

        $new = [
            'id'        => 'AB12',
            'timestamp' => 1415116207,
            'key'       => 'ABC',
            'bool'      => FALSE,
        ];

        $this->observer->expects($this->exactly(2))
                       ->method('getTimeKeys')
                       ->willReturn([ 'timestamp' ]);

        $method = $this->getReflectionMethod('shouldSkipItem');

        $this->assertTrue($method->invokeArgs($this->class, [ $old, $new ]));
    }

    /**
     * Test that shouldSkipItem() returns FALSE if the item contains changes.
     *
     * @covers \Pipeline\Import\Diff::shouldSkipItem
     */
    public function testShouldSkipItemWhenItemChanged(): void
    {
        $old = [
            'id'        => 'AB12',
            'timestamp' => 1415116107,
            'key'       => 'ABC',
            'bool'      => 0,
        ];

        $new = [
            'id'        => 'AB12',
            'timestamp' => 1415116207,
            'key'       => 'ABC',
            'bool'      => TRUE,
        ];

        $this->observer->expects($this->exactly(2))
                       ->method('getTimeKeys')
                       ->willReturn([ 'timestamp' ]);

        $method = $this->getReflectionMethod('shouldSkipItem');

        $this->assertFalse($method->invokeArgs($this->class, [ $old, $new ]));
    }

    /**
     * Test that shouldSkipItem() returns FALSE if there's a time key only change and it should not be skipped.
     *
     * @covers \Pipeline\Import\Diff::shouldSkipItem
     */
    public function testShouldSkipItemWhenTimeKeyOnlyChangeShouldNotBeSkipped(): void
    {
        $old = [
            'id'        => 'AB12',
            'timestamp' => 1415116107,
            'key'       => 'ABC',
            'bool'      => 0,
        ];

        $new = [
            'id'        => 'AB12',
            'timestamp' => 1415116207,
            'key'       => 'ABC',
            'bool'      => FALSE,
        ];

        $this->observer->expects($this->once())
                       ->method('getTimeKeys')
                       ->willReturn([ 'timestamp' ]);

        $this->setReflectionPropertyValue('skipTimeKeyOnlyChange', FALSE);

        $method = $this->getReflectionMethod('shouldSkipItem');

        $this->assertFalse($method->invokeArgs($this->class, [ $old, $new ]));
    }

}

?>
