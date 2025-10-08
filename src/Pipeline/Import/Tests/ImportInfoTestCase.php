<?php

/**
 * This file contains the test class for the ImportInfo class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import\Tests;

use Lunr\Halo\LunrBaseTestCase;
use Lunr\Ticks\EventLogging\Null\NullEvent;
use Lunr\Ticks\Profiling\Profiler;
use Lunr\Ticks\TracingControllerInterface;
use Lunr\Ticks\TracingInfoInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Pipeline\Import\ImportInfo;

/**
 * Test class for the basic ImportInfo class.
 *
 * @covers Pipeline\Import\ImportInfo
 */
abstract class ImportInfoTestCase extends LunrBaseTestCase
{

    /**
     * Mock instance of the Profiler.
     * @var Profiler&MockObject
     */
    protected Profiler&MockObject $profiler;

    /**
     * Mock instance of the tracing controller class.
     * @var TracingControllerInterface&TracingInfoInterface&MockObject
     */
    protected TracingControllerInterface&TracingInfoInterface&MockObject $controller;

    /**
     * Instance of the tested class.
     * @var ImportInfo
     */
    protected ImportInfo $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
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

        $this->class = new ImportInfo($this->profiler);

        parent::baseSetUp($this->class);
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

        unset($this->class);
    }

}

?>
