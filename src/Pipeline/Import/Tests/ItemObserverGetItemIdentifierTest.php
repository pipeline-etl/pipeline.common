<?php

/**
 * This file contains the test class for the ItemObserver class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import\Tests;

/**
 * Test class for the ItemObserver class.
 *
 * @covers Pipeline\Import\ItemObserver
 */
class ItemObserverGetItemIdentifierTest extends ItemObserverTestCase
{

    /**
     * Test that getItemIdentifier() returns concatenated primary fields containing a boolean 'false'.
     *
     *  @covers \Pipeline\Import\ItemObserver::getItemIdentifier
     */
    public function testGetItemIdentifierConcatenatesBooleanFalse(): void
    {
        $item = [
            'id'        => 'AB12',
            'timestamp' => 1415116107,
            'key'       => 'ABC',
            'bool'      => FALSE,
        ];

        $this->setReflectionPropertyValue('identifierKeys', array_keys($item));

        $id = $this->class->getItemIdentifier($item);

        $this->assertEquals('AB12_1415116107_ABC_0', $id);
    }

    /**
     * Test that getItemIdentifier() returns concatenated primary fields containing a boolean 'true'.
     *
     *  @covers \Pipeline\Import\ItemObserver::getItemIdentifier
     */
    public function testGetItemIdentifierConcatenatesBooleanTrue(): void
    {
        $item = [
            'id'        => 'AB12',
            'timestamp' => 1415116107,
            'key'       => 'ABC',
            'bool'      => TRUE,
        ];

        $this->setReflectionPropertyValue('identifierKeys', array_keys($item));

        $id = $this->class->getItemIdentifier($item);

        $this->assertEquals('AB12_1415116107_ABC_1', $id);
    }

    /**
     * Test that getItemIdentifier() returns concatenated primary fields containing a NULL value.
     *
     *  @covers \Pipeline\Import\ItemObserver::getItemIdentifier
     */
    public function testGetItemIdentifierConcatenatesNull(): void
    {
        $item = [
            'id'        => 'AB12',
            'timestamp' => 1415116107,
            'key'       => NULL,
            'bool'      => TRUE,
        ];

        $this->setReflectionPropertyValue('identifierKeys', array_keys($item));

        $id = $this->class->getItemIdentifier($item);

        $this->assertEquals('AB12_1415116107_NULL_1', $id);
    }

}

?>
