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
class ItemObserverGetUniqueIdentifierTest extends ItemObserverTestCase
{

    /**
     * Test that getUniqueIdentifier() returns concatenated primary fields containing a boolean 'false'.
     *
     *  @covers \Pipeline\Import\ItemObserver::getUniqueIdentifier
     */
    public function testGetUniqueIdentifierConcatenatesBooleanFalse(): void
    {
        $item = [
            'id'        => 'AB12',
            'timestamp' => 1415116107,
            'key'       => 'ABC',
            'bool'      => FALSE,
        ];

        $id = $this->class->getUniqueIdentifier($item, array_keys($item));

        $this->assertEquals('AB12_1415116107_ABC_0', $id);
    }

    /**
     * Test that getUniqueIdentifier() returns concatenated primary fields containing a boolean 'true'.
     *
     *  @covers \Pipeline\Import\ItemObserver::getUniqueIdentifier
     */
    public function testGetUniqueIdentifierConcatenatesBooleanTrue(): void
    {
        $item = [
            'id'        => 'AB12',
            'timestamp' => 1415116107,
            'key'       => 'ABC',
            'bool'      => TRUE,
        ];

        $id = $this->class->getUniqueIdentifier($item, array_keys($item));

        $this->assertEquals('AB12_1415116107_ABC_1', $id);
    }

    /**
     * Test that getUniqueIdentifier() returns concatenated primary fields containing a NULL value.
     *
     *  @covers \Pipeline\Import\ItemObserver::getUniqueIdentifier
     */
    public function testGetUniqueIdentifierConcatenatesNull(): void
    {
        $item = [
            'id'        => 'AB12',
            'timestamp' => 1415116107,
            'key'       => NULL,
            'bool'      => TRUE,
        ];

        $id = $this->class->getUniqueIdentifier($item, array_keys($item));

        $this->assertEquals('AB12_1415116107_NULL_1', $id);
    }

}

?>
