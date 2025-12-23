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
class DiffIsOldItemNewerTest extends DiffTestCase
{

    /**
     * Test that isOldItemNewer() returns FALSE if $new is newer.
     *
     * @covers \Pipeline\Import\Diff::isOldItemNewer
     */
    public function testIsOldItemNewerReturnsFalseIfOlder(): void
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

        $method = $this->getReflectionMethod('isOldItemNewer');

        $this->assertFalse($method->invokeArgs($this->class, [ $old, $new ]));
    }

    /**
     * Test that isOldItemNewer() returns FALSE if $new is of the same age.
     *
     * @covers \Pipeline\Import\Diff::isOldItemNewer
     */
    public function testIsOldItemNewerReturnsFalseIfSame(): void
    {
        $old = [
            'id'        => 'AB12',
            'timestamp' => 1415116107,
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

        $method = $this->getReflectionMethod('isOldItemNewer');

        $this->assertFalse($method->invokeArgs($this->class, [ $old, $new ]));
    }

    /**
     * Test that isOldItemNewer() returns TRUE if $new is older.
     *
     * @covers \Pipeline\Import\Diff::isOldItemNewer
     */
    public function testIsOldItemNewerReturnsTrueIfNewer(): void
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

        $method = $this->getReflectionMethod('isOldItemNewer');

        $this->assertTrue($method->invokeArgs($this->class, [ $old, $new ]));
    }

}

?>
