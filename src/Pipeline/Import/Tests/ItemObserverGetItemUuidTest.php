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
class ItemObserverGetItemUuidTest extends ItemObserverTestCase
{

    /**
     * Test that getItemUuid() returns a new UUID for uncached item.
     *
     *  @covers \Pipeline\Import\ItemObserver::getItemUuid
     */
    public function testGetItemUuidReturnsNewUuidForUncachedItem(): void
    {
        $this->setReflectionPropertyValue('itemUuids', []);
        $this->mockFunction('uuid_create', fn() => '25953886-576b-452b-bb96-ab1cd7ee397d');

        $uuid = $this->class->getItemUuid('item1');

        $this->assertEquals('25953886-576b-452b-bb96-ab1cd7ee397d', $uuid);

        $this->unmockFunction('uuid_create');
    }

    /**
     * Test that getItemUuid() returns existing UUID for cached item.
     *
     *  @covers \Pipeline\Import\ItemObserver::getItemUuid
     */
    public function testGetItemUuidReturnsExistingUuidForCachedItem(): void
    {
        $this->setReflectionPropertyValue('itemUuids', [ 'item1' => '25953886-576b-452b-bb96-ab1cd7ee397e' ]);

        $uuid = $this->class->getItemUuid('item1');

        $this->assertEquals('25953886-576b-452b-bb96-ab1cd7ee397e', $uuid);
    }

}

?>
