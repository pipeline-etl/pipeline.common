<?php

/**
 * This file contains the test class for the ItemObserver class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import\Tests;

use Pipeline\Import\Exceptions\DatabaseException;

/**
 * Test class for the ItemObserver class.
 *
 * @covers Pipeline\Import\ItemObserver
 */
class ItemObserverGetTimeKeysTest extends ItemObserverTestCase
{

    /**
     * Test that getTimeKeys() returns the cached time keys.
     *
     * @covers Pipeline\Import\ItemObserver::getTimeKeys
     */
    public function testGetTimeKeysFromCache(): void
    {
        $keys = [ 'version' ];

        $this->setReflectionPropertyValue('timeKeys', $keys);

        $this->importTarget->expects($this->never())
                           ->method('getTimeKeys');

        $this->assertEquals($keys, $this->class->getTimeKeys());
    }

    /**
     * Test that getTimeKeys() returns the uncached time keys.
     *
     * @covers Pipeline\Import\ItemObserver::getTimeKeys
     */
    public function testGetTimeKeysFromDatabase(): void
    {
        $keys = [ 'version' ];

        $this->importTarget->expects($this->once())
                           ->method('getTimeKeys')
                           ->willReturn($keys);

        $this->assertEquals($keys, $this->class->getTimeKeys());
    }

    /**
     * Test that getTimeKeys() throws an exception in case no object time key was found.
     *
     * @covers Pipeline\Import\ItemObserver::getTimeKeys
     */
    public function testGetTimeKeysThrowsExceptionWhenNoneFound(): void
    {
        $this->importTarget->expects($this->once())
                           ->method('getTimeKeys')
                           ->willReturn([]);

        $this->expectExceptionMessage('No time key found in content model!');
        $this->expectException(DatabaseException::class);

        $this->class->getTimeKeys();
    }

}

?>
