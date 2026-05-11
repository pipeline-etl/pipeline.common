<?php

/**
 * This file contains the ImportLocatorGetContentRangeTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2026 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Import;

use Pipeline\Common\Node;
use Pipeline\Import\ContentRangeInterface;
use Pipeline\Tests\Import\Helpers\Ranges\FooRange;

/**
 * This class contains tests for the ImportLocator class.
 *
 * @covers Pipeline\Import\ImportLocator
 */
class ImportLocatorGetContentRangeTest extends ImportLocatorTestCase
{

    /**
     * Instance of a Pipeline ContentRange
     * @var ContentRangeInterface&Node
     */
    protected ContentRangeInterface&Node $range;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->range = new FooRange($this->logger);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->range);
    }

    /**
     * Test that getContentRange() returns NULL when the requested ContentRange couldn't be found.
     *
     * @covers Pipeline\Import\ImportLocator::getContentRange
     */
    public function testGetContentRangeReturnsNullIfClassNotFound(): void
    {
        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('foorange')
                      ->andReturn(FALSE);

        $this->logger->shouldReceive('warning')
                     ->once()
                     ->with('Unable to find pipeline component: ({name})', [ 'name' => 'FooRange' ]);

        $this->assertNull($this->class->getContentRange('foo'));
    }

    /**
     * Test that getContentRange() returns an instance from the locator.
     *
     * @covers Pipeline\Import\ImportLocator::getContentRange
     */
    public function testGetContentRangeFetchesInstanceFromLocator(): void
    {
        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('mockrange')
                      ->andReturn(TRUE);

        $this->locator->shouldReceive('get')
                      ->once()
                      ->with('mockrange')
                      ->andReturn($this->range);

        $instance = $this->class->getContentRange('mock');

        $this->assertInstanceOf(ContentRangeInterface::class, $instance);
    }

    /**
     * Test that getContentRange() returns an autoloaded instance from a custom namespace.
     *
     * @covers Pipeline\Import\ImportLocator::getContentRange
     */
    public function testGetContentRangeAutoloadsInstanceFromCustomNamespace(): void
    {
        $this->class->registerNamespace('Pipeline\Tests\Import\Helpers');

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('foorange')
                      ->andReturn(FALSE);

        $instance = $this->class->getContentRange('foo');

        $this->assertInstanceOf(FooRange::class, $instance);
    }

    /**
     * Test that getContentRange() caches an autoloaded instance for subsequent calls.
     *
     * @covers Pipeline\Import\ImportLocator::getContentRange
     */
    public function testGetContentRangeCachesLoadedInstance(): void
    {
        $this->class->registerNamespace('Pipeline\Tests\Import\Helpers');

        $this->locator->shouldReceive('has')
                      ->twice()
                      ->with('foorange')
                      ->andReturn(FALSE);

        $first  = $this->class->getContentRange('foo');
        $second = $this->class->getContentRange('foo');

        $this->assertSame($first, $second);
    }

}

?>
