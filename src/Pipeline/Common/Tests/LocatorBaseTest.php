<?php

/**
 * This file contains the LocatorBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;
use Lunr\Ticks\EventLogging\Null\NullEvent;
use Lunr\Ticks\Profiling\Profiler;
use Lunr\Ticks\TracingControllerInterface;
use Lunr\Ticks\TracingInfoInterface;
use PHPUnit\Framework\MockObject\MockObject;

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
     * @var Profiler&MockObject
     */
    protected Profiler&MockObject $profiler;

    /**
     * Mock instance of the tracing controller class.
     * @var TracingControllerInterface&TracingInfoInterface&MockObject
     */
    private TracingControllerInterface&TracingInfoInterface&MockObject $controller;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->controller = $this->createMockForIntersectionOfInterfaces([
            TracingControllerInterface::class,
            TracingInfoInterface::class,
        ]);

        $event = $this->getMockBuilder(NullEvent::class)
                      ->disableOriginalConstructor()
                      ->getMock();

        $this->profiler = $this->getMockBuilder(Profiler::class)
                               ->setConstructorArgs([ $event, $this->controller ])
                               ->getMock();
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        $traceID = '7b333e15-aa78-4957-a402-731aecbb358e';
        $spanID  = '24ec5f90-7458-4dd5-bb51-7a1e8f4baafe';

        $this->controller->expects($this->once())
                         ->method('getTraceId')
                         ->willReturn($traceID);

        $this->controller->expects($this->once())
                         ->method('getSpanId')
                         ->willReturn($spanID);

        unset($this->controller);
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
