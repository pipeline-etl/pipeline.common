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
class ItemObserverBaseTest extends ItemObserverTestCase
{

    /**
     * Test that the import target is passed correctly.
     */
    public function testImportTargetIsPassedCorrectly(): void
    {
        $this->assertPropertySame('importTarget', $this->importTarget);
    }

    /**
     * Test that the registry for item UUIDs is initialized correctly.
     */
    public function testItemUuidsIsInitializedCorrectly(): void
    {
        $this->assertArrayEmpty($this->getReflectionPropertyValue('itemUuids'));
    }

}

?>
