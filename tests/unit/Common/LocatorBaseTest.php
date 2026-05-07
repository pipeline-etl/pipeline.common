<?php

/**
 * This file contains the LocatorBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Common;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;
use Lunr\Ticks\Profiling\Profiler;
use Mockery;
use Mockery\MockInterface;

/**
 * This class contains tests for the Locator class.
 *
 * @covers Pipeline\Common\Locator
 */
class LocatorBaseTest extends LocatorTestCase
{

    use PsrLoggerTestTrait;

    /**
     * Mock instance of the Profiler class.
     * @var Profiler&MockInterface
     */
    protected Profiler&MockInterface $profiler;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->profiler = Mockery::mock(Profiler::class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->profiler);
    }

    /**
     * Test that the locator is set correctly.
     */
    public function testLocatorIsSetCorrectly(): void
    {
        $this->assertPropertySame('locator', $this->locator);
    }

    /**
     * Test that the list of namespaces is initialized properly.
     */
    public function testListOfNamespacesIsInitializedProperly(): void
    {
        $this->assertArrayEmpty($this->getReflectionPropertyValue('namespaces'));
    }

    /**
     * Test that the local object cache is initialized properly.
     */
    public function testLocalObjectCacheIsInitializedProperly(): void
    {
        $this->assertPropertyEquals('objectCache', []);
    }

    /**
     * Test that register_namespace() adds to the list of searched namespaces.
     *
     * @covers Pipeline\Common\Locator::registerNamespace
     */
    public function testRegisterNamespacesAddsNamespaceToSearchList(): void
    {
        $property = $this->getReflectionProperty('namespaces');

        $before = $property->getValue($this->class);

        $this->assertArrayEmpty($before);

        $this->class->registerNamespace('Pipeline\Common\Tests');

        $after = $property->getValue($this->class);

        $this->assertArrayNotEmpty($after);
        $this->assertCount(1, $after);

        $this->assertEquals('Pipeline\Common\Tests', $after[0]);

        $this->class->registerNamespace('Pipeline\Import\Tests');

        $after = $property->getValue($this->class);

        $this->assertArrayNotEmpty($after);
        $this->assertCount(2, $after);

        $this->assertEquals('Pipeline\Import\Tests', $after[0]);
        $this->assertEquals('Pipeline\Common\Tests', $after[1]);
    }

    /**
     * Test that getLogger() returns the logger.
     *
     * @covers \Pipeline\Common\Locator::getLogger
     */
    public function testGetLoggerReturnsLogger(): void
    {
        $this->assertSame($this->logger, $this->class->getLogger());
    }

    /**
     * Test that setProfiler() sets the profiler.
     *
     * @covers \Pipeline\Common\Locator::setProfiler
     */
    public function testSetProfiler()
    {
        $this->assertPropertyUnset('profiler');

        $this->class->setProfiler($this->profiler);

        $this->assertPropertySame('profiler', $this->profiler);
    }

    /**
     * Test that setProfiler() does not set the profiler if it is already set.
     *
     * @covers \Pipeline\Common\Locator::setProfiler
     */
    public function testSetProfilerIfAlreadySet()
    {
        $this->setReflectionPropertyValue('profiler', $this->profiler);

        $this->class->setProfiler($this->profiler);

        $this->assertPropertySame('profiler', $this->profiler);
    }

}

?>
