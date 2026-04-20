<?php

/**
 * This file contains the LocatorGetInstanceTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests;

use Lunr\Ticks\EventLogging\Null\NullEvent;
use Lunr\Ticks\Profiling\Profiler;
use Lunr\Ticks\TracingControllerInterface;
use Lunr\Ticks\TracingInfoInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Pipeline\Common\FlattenerInterface;
use Pipeline\Common\Node;
use Pipeline\Common\Parser;
use Pipeline\Common\PreprocessorInterface;
use Pipeline\Common\ProcessorInterface;
use Pipeline\Common\SourceInterface;
use Pipeline\Common\Tests\Helpers\Flatteners\FooFlattener;
use Pipeline\Common\Tests\Helpers\Parsers\FooParser;
use Pipeline\Common\Tests\Helpers\Preprocessors\FooPreprocessor;
use Pipeline\Common\Tests\Helpers\Processors\FooProcessor;
use Pipeline\Common\Tests\Helpers\Sources\FooSource;

/**
 * This class contains tests for the Pipeline class.
 *
 * @covers Pipeline\Common\Locator
 */
class LocatorGetInstanceTest extends LocatorTestCase
{

    /**
     * Mock instance of the tracing controller class.
     * @var TracingControllerInterface&TracingInfoInterface&MockObject
     */
    private TracingControllerInterface&TracingInfoInterface&MockObject $controller;

    /**
     * Mock instance of the Profiler class.
     * @var Profiler&MockObject
     */
    protected Profiler&MockObject $profiler;

    /**
     * Mock instance of a Pipeline Flattener
     * @var FlattenerInterface&Node
     */
    protected FlattenerInterface&Node $flattener;

    /**
     * Mock instance of a Pipeline Parser
     * @var Parser
     */
    protected Parser $parser;

    /**
     * Mock instance of a Pipeline Processor
     * @var ProcessorInterface&Node
     */
    protected ProcessorInterface&Node $processor;

    /**
     * Mock instance of a Pipeline Preprocessor
     * @var PreprocessorInterface&Node
     */
    protected PreProcessorInterface&Node $preprocessor;

    /**
     * Mock instance of a Pipeline Source
     * @var SourceInterface&Node
     */
    protected SourceInterface&Node $source;

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

        $this->flattener    = new FooFlattener($this->logger);
        $this->processor    = new FooProcessor($this->logger);
        $this->preprocessor = new FooPreprocessor($this->logger);
        $this->source       = new FooSource($this->logger);
        $this->parser       = new FooParser($this->logger, $this->profiler);
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
        unset($this->flattener);
        unset($this->processor);
        unset($this->preprocessor);
        unset($this->source);
        unset($this->parser);
    }

    /**
     * Test that getProcessor() caches an instantiated processor in the locator.
     *
     * @covers Pipeline\Common\Locator::getProcessor
     */
    public function testGetProcessorCachesLoadedInstance(): void
    {
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Common\Tests\Helpers' ]);

        $this->class->getProcessor('foo');

        $value = $this->getReflectionPropertyValue('objectCache');

        $this->assertArrayHasKey('fooprocessor', $value);
        $this->assertInstanceOf(FooProcessor::class, $value['fooprocessor']);
    }

    /**
     * Test that getPreprocessor() caches an instantiated preprocessor in the locator.
     *
     * @covers Pipeline\Common\Locator::getPreprocessor
     */
    public function testGetPreprocessorCachesLoadedInstance(): void
    {
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Common\Tests\Helpers' ]);

        $this->class->getPreprocessor('foo');

        $value = $this->getReflectionPropertyValue('objectCache');

        $this->assertArrayHasKey('foopreprocessor', $value);
        $this->assertInstanceOf(FooPreprocessor::class, $value['foopreprocessor']);
    }

    /**
     * Test that getSource() returns NULL when the requested Source couldn't be found.
     *
     * @covers Pipeline\Common\Locator::getSource
     */
    public function testGetSourceReturnsNullIfClassNotFound(): void
    {
        $this->assertNull($this->class->getSource('foo'));
    }

    /**
     * Test that getSource() returns an instance from the locator.
     *
     * @covers Pipeline\Common\Locator::getSource
     */
    public function testGetSourceFetchesInstanceFromLocator(): void
    {
        $this->locator->expects($this->once())
                      ->method('has')
                      ->with('mocksource')
                      ->willReturn(TRUE);

        $this->locator->expects($this->once())
                      ->method('get')
                      ->with('mocksource')
                      ->willReturn($this->source);

        $instance = $this->class->getSource('mock');

        $this->assertInstanceOf(SourceInterface::class, $instance);
    }

    /**
     * Test that getSource() returns an instance from the local object cache.
     *
     * @covers Pipeline\Common\Locator::getSource
     */
    public function testGetSourceFetchesInstanceFromLocalObjectCache(): void
    {
        $this->setReflectionPropertyValue('objectCache', [ 'mocksource' => $this->source ]);

        $this->locator->expects($this->once())
                      ->method('has')
                      ->with('mocksource')
                      ->willReturn(FALSE);

        $instance = $this->class->getSource('mock');

        $this->assertInstanceOf(SourceInterface::class, $instance);
    }

    /**
     * Test that getSource() returns an autoloaded instance from a custom namespace.
     *
     * @covers Pipeline\Common\Locator::getSource
     */
    public function testGetSourceAutoloadsInstanceFromCustomNamespace(): void
    {
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Common\Tests\Helpers' ]);

        $instance = $this->class->getSource('foo');

        $this->assertInstanceOf(FooSource::class, $instance);
    }

    /**
     * Test that getFlattener() returns NULL when the requested Flattener couldn't be found.
     *
     * @covers Pipeline\Common\Locator::getFlattener
     */
    public function testGetFlattenerReturnsNullIfClassNotFound(): void
    {
        $this->assertNull($this->class->getFlattener('foo'));
    }

    /**
     * Test that getFlattener() returns an instance from the locator.
     *
     * @covers Pipeline\Common\Locator::getFlattener
     */
    public function testGetFlattenerFetchesInstanceFromLocator(): void
    {
        $this->locator->expects($this->once())
                      ->method('has')
                      ->with('mockflattener')
                      ->willReturn(TRUE);

        $this->locator->expects($this->once())
                      ->method('get')
                      ->with('mockflattener')
                      ->willReturn($this->flattener);

        $instance = $this->class->getFlattener('mock');

        $this->assertInstanceOf(FlattenerInterface::class, $instance);
    }

    /**
     * Test that getFlattener() returns an instance from the local object cache.
     *
     * @covers Pipeline\Common\Locator::getFlattener
     */
    public function testGetFlattenerFetchesInstanceFromLocalObjectCache(): void
    {
        $this->setReflectionPropertyValue('objectCache', [ 'mockflattener' => $this->flattener ]);

        $this->locator->expects($this->once())
                      ->method('has')
                      ->with('mockflattener')
                      ->willReturn(FALSE);

        $instance = $this->class->getFlattener('mock');

        $this->assertInstanceOf(FlattenerInterface::class, $instance);
    }

    /**
     * Test that getFlattener() returns an autoloaded instance from a custom namespace.
     *
     * @covers Pipeline\Common\Locator::getFlattener
     */
    public function testGetFlattenerAutoloadsInstanceFromCustomNamespace(): void
    {
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Common\Tests\Helpers' ]);

        $instance = $this->class->getFlattener('foo');

        $this->assertInstanceOf(FooFlattener::class, $instance);
    }

    /**
     * Test that getPreprocessor() returns NULL when the requested Preprocessor couldn't be found.
     *
     * @covers Pipeline\Common\Locator::getPreprocessor
     */
    public function testGetPreprocessorReturnsNullIfClassNotFound(): void
    {
        $this->assertNull($this->class->getPreprocessor('foo'));
    }

    /**
     * Test that getPreprocessor() returns an instance from the locator.
     *
     * @covers Pipeline\Common\Locator::getPreprocessor
     */
    public function testGetPreprocessorFetchesInstanceFromLocator(): void
    {
        $this->locator->expects($this->once())
                      ->method('has')
                      ->with('mockpreprocessor')
                      ->willReturn(TRUE);

        $this->locator->expects($this->once())
                      ->method('get')
                      ->with('mockpreprocessor')
                      ->willReturn($this->preprocessor);

        $instance = $this->class->getPreprocessor('mock');

        $this->assertInstanceOf(PreprocessorInterface::class, $instance);
    }

    /**
     * Test that getPreprocessor() returns an instance from the local object cache.
     *
     * @covers Pipeline\Common\Locator::getPreprocessor
     */
    public function testGetPreprocessorFetchesInstanceFromLocalObjectCache(): void
    {
        $this->setReflectionPropertyValue('objectCache', [ 'mockpreprocessor' => $this->preprocessor ]);

        $this->locator->expects($this->once())
                      ->method('has')
                      ->with('mockpreprocessor')
                      ->willReturn(FALSE);

        $instance = $this->class->getPreprocessor('mock');

        $this->assertInstanceOf(PreprocessorInterface::class, $instance);
    }

    /**
     * Test that getPreprocessor() returns an autoloaded instance from a custom namespace.
     *
     * @covers Pipeline\Common\Locator::getPreprocessor
     */
    public function testGetPreprocessorAutoloadsInstanceFromCustomNamespace(): void
    {
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Common\Tests\Helpers' ]);

        $instance = $this->class->getPreprocessor('foo');

        $this->assertInstanceOf(FooPreprocessor::class, $instance);
    }

    /**
     * Test that getProcessor() returns NULL when the requested Processor couldn't be found.
     *
     * @covers Pipeline\Common\Locator::getProcessor
     */
    public function testGetProcessorReturnsNullIfClassNotFound(): void
    {
        $this->locator->expects($this->once())
                      ->method('has')
                      ->with('fooprocessor')
                      ->willReturn(FALSE);

        $this->assertNull($this->class->getProcessor('foo'));
    }

    /**
     * Test that getProcessor() returns an instance from the locator.
     *
     * @covers Pipeline\Common\Locator::getProcessor
     */
    public function testGetProcessorFetchesInstanceFromLocator(): void
    {
        $this->locator->expects($this->once())
                      ->method('has')
                      ->with('mockprocessor')
                      ->willReturn(TRUE);

        $this->locator->expects($this->once())
                      ->method('get')
                      ->with('mockprocessor')
                      ->willReturn($this->processor);

        $instance = $this->class->getProcessor('mock');

        $this->assertInstanceOf(ProcessorInterface::class, $instance);
    }

    /**
     * Test that getProcessor() returns an instance from the local object cache.
     *
     * @covers Pipeline\Common\Locator::getProcessor
     */
    public function testGetProcessorFetchesInstanceFromLocalObjectCache(): void
    {
        $this->setReflectionPropertyValue('objectCache', [ 'mockprocessor' => $this->processor ]);

        $this->locator->expects($this->once())
                      ->method('has')
                      ->with('mockprocessor')
                      ->willReturn(FALSE);

        $instance = $this->class->getProcessor('mock');

        $this->assertInstanceOf(ProcessorInterface::class, $instance);
    }

    /**
     * Test that getProcessor() returns an autoloaded instance from a custom namespace.
     *
     * @covers Pipeline\Common\Locator::getProcessor
     */
    public function testGetProcessorAutoloadsInstanceFromCustomNamespace(): void
    {
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Common\Tests\Helpers' ]);

        $instance = $this->class->getProcessor('foo');

        $this->assertInstanceOf(FooProcessor::class, $instance);
    }

    /**
     * Test that getParser() returns NULL when the requested Flattener couldn't be found.
     *
     * @covers Pipeline\Common\Locator::getParser
     */
    public function testGetParserReturnsNullIfClassNotFound(): void
    {
        $this->assertNull($this->class->getParser('foo'));
    }

    /**
     * Test that getParser() returns an instance from the locator.
     *
     * @covers Pipeline\Common\Locator::getParser
     */
    public function testGetParserFetchesInstanceFromLocator(): void
    {

        $this->locator->expects($this->once())
                      ->method('has')
                      ->with('mockparser')
                      ->willReturn(TRUE);

        $this->locator->expects($this->once())
                      ->method('get')
                      ->with('mockparser')
                      ->willReturn($this->parser);

        $instance = $this->class->getParser('mock');

        $this->assertInstanceOf(Parser::class, $instance);
    }

    /**
     * Test that getParser() returns an instance from the local object cache.
     *
     * @covers Pipeline\Common\Locator::getParser
     */
    public function testGetParserFetchesInstanceFromLocalObjectCache(): void
    {
        $this->setReflectionPropertyValue('objectCache', [ 'mockparser' => $this->parser ]);

        $this->locator->expects($this->once())
                      ->method('has')
                      ->with('mockparser')
                      ->willReturn(FALSE);

        $instance = $this->class->getParser('mock');

        $this->assertInstanceOf(Parser::class, $instance);
    }

    /**
     * Test that getParser() returns an autoloaded instance from a custom namespace.
     *
     * @covers Pipeline\Common\Locator::getParser
     */
    public function testGetParserAutoloadsInstanceFromCustomNamespace(): void
    {
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Common\Tests\Helpers' ]);
        $this->setReflectionPropertyValue('profiler', $this->profiler);

        $instance = $this->class->getParser('foo');

        $this->assertInstanceOf(FooParser::class, $instance);
    }

}

?>
