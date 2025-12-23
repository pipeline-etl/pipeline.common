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
class ItemObserverGetIdentifierKeysTest extends ItemObserverTestCase
{

    /**
     * Test that getIdentifierKeys() returns the cached identifier keys.
     *
     * @covers Pipeline\Import\ItemObserver::getIdentifierKeys
     */
    public function testGetIdentifierKeysFromCache(): void
    {
        $keys = [ 'hello', 'world' ];

        $this->setReflectionPropertyValue('identifierKeys', $keys);

        $this->importTarget->expects($this->never())
                           ->method('getIdentifierKeys');

        $this->assertEquals($keys, $this->class->getIdentifierKeys());
    }

    /**
     * Test that getIdentifierKeys() returns the uncached identifier keys.
     *
     * @covers Pipeline\Import\ItemObserver::getIdentifierKeys
     */
    public function testGetIdentifierKeysFromDatabase(): void
    {
        $keys = [ 'hello', 'world' ];

        $this->importTarget->expects($this->once())
                           ->method('getIdentifierKeys')
                           ->willReturn($keys);

        $this->assertEquals($keys, $this->class->getIdentifierKeys());
    }

    /**
     * Test that getIdentifierKeys() throws an exception in case no object identifier was found.
     *
     * @covers Pipeline\Import\ItemObserver::getIdentifierKeys
     */
    public function testGetIdentifierKeysThrowsExceptionWhenNoneFound(): void
    {
        $this->importTarget->expects($this->once())
                           ->method('getIdentifierKeys')
                           ->willReturn([]);

        $this->expectExceptionMessage('No object identifier found in content model!');
        $this->expectException(DatabaseException::class);

        $this->class->getIdentifierKeys();
    }

}

?>
