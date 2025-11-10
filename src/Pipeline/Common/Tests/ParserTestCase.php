<?php

/**
 * This file contains the ParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests;

use Lunr\Halo\LunrBaseTestCase;
use Lunr\Ticks\EventLogging\Null\NullEvent;
use Lunr\Ticks\Profiling\Profiler;
use Lunr\Ticks\TracingControllerInterface;
use Lunr\Ticks\TracingInfoInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Pipeline\Common\Parser;
use Psr\Log\LoggerInterface;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Parser class.
 *
 * @covers Pipeline\Common\Parser
 */
abstract class ParserTestCase extends LunrBaseTestCase
{

    use MockeryPHPUnitIntegration;

    /**
     * Mock instance of the Logger.
     * @var LoggerInterface&MockObject
     */
    protected LoggerInterface&MockObject $logger;

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
     * Instance of the tested class.
     * @var Parser&MockInterface
     */
    protected Parser&MockInterface $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder(LoggerInterface::class)
                             ->getMock();

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

        $this->class = Mockery::mock(Parser::class, [ $this->logger, $this->profiler ]);

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

        unset($this->logger);
        unset($this->controller);
        unset($this->profiler);
        unset($this->class);
    }

}

?>
