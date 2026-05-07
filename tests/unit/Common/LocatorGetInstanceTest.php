<?php

/**
 * This file contains the LocatorGetInstanceTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Common;

use Lunr\Ticks\Profiling\Profiler;
use Mockery;
use Mockery\MockInterface;
use Pipeline\Common\FlattenerInterface;
use Pipeline\Common\Node;
use Pipeline\Common\Parser;
use Pipeline\Common\PreprocessorInterface;
use Pipeline\Common\ProcessorInterface;
use Pipeline\Common\SourceInterface;
use Pipeline\Tests\Common\Helpers\Flatteners\FooFlattener;
use Pipeline\Tests\Common\Helpers\Parsers\FooParser;
use Pipeline\Tests\Common\Helpers\Preprocessors\FooPreprocessor;
use Pipeline\Tests\Common\Helpers\Processors\FooProcessor;
use Pipeline\Tests\Common\Helpers\Sources\FooSource;

/**
 * This class contains tests for the Pipeline class.
 *
 * @covers Pipeline\Common\Locator
 */
class LocatorGetInstanceTest extends LocatorTestCase
{

    /**
     * Mock instance of the Profiler class.
     * @var Profiler&MockInterface
     */
    protected Profiler&MockInterface $profiler;

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

        $this->profiler = Mockery::mock(Profiler::class);

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
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Tests\Common\Helpers' ]);

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('fooprocessor')
                      ->andReturn(FALSE);

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
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Tests\Common\Helpers' ]);

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('foopreprocessor')
                      ->andReturn(FALSE);

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
        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('foosource')
                      ->andReturn(FALSE);

        $this->logger->shouldReceive('warning')
                     ->once()
                     ->with('Unable to find pipeline component: ({name})', [ 'name' => 'FooSource' ]);

        $this->assertNull($this->class->getSource('foo'));
    }

    /**
     * Test that getSource() returns an instance from the locator.
     *
     * @covers Pipeline\Common\Locator::getSource
     */
    public function testGetSourceFetchesInstanceFromLocator(): void
    {
        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('mocksource')
                      ->andReturn(TRUE);

        $this->locator->shouldReceive('get')
                      ->once()
                      ->with('mocksource')
                      ->andReturn($this->source);

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

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('mocksource')
                      ->andReturn(FALSE);

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
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Tests\Common\Helpers' ]);

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('foosource')
                      ->andReturn(FALSE);

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
        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('fooflattener')
                      ->andReturn(FALSE);

        $this->logger->shouldReceive('warning')
                     ->once()
                     ->with('Unable to find pipeline component: ({name})', [ 'name' => 'FooFlattener' ]);

        $this->assertNull($this->class->getFlattener('foo'));
    }

    /**
     * Test that getFlattener() returns an instance from the locator.
     *
     * @covers Pipeline\Common\Locator::getFlattener
     */
    public function testGetFlattenerFetchesInstanceFromLocator(): void
    {
        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('mockflattener')
                      ->andReturn(TRUE);

        $this->locator->shouldReceive('get')
                      ->once()
                      ->with('mockflattener')
                      ->andReturn($this->flattener);

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

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('mockflattener')
                      ->andReturn(FALSE);

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
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Tests\Common\Helpers' ]);

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('fooflattener')
                      ->andReturn(FALSE);

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
        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('foopreprocessor')
                      ->andReturn(FALSE);

        $this->logger->shouldReceive('warning')
                     ->once()
                     ->with('Unable to find pipeline component: ({name})', [ 'name' => 'FooPreprocessor' ]);

        $this->assertNull($this->class->getPreprocessor('foo'));
    }

    /**
     * Test that getPreprocessor() returns an instance from the locator.
     *
     * @covers Pipeline\Common\Locator::getPreprocessor
     */
    public function testGetPreprocessorFetchesInstanceFromLocator(): void
    {
        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('mockpreprocessor')
                      ->andReturn(TRUE);

        $this->locator->shouldReceive('get')
                      ->once()
                      ->with('mockpreprocessor')
                      ->andReturn($this->preprocessor);

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

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('mockpreprocessor')
                      ->andReturn(FALSE);

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
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Tests\Common\Helpers' ]);

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('foopreprocessor')
                      ->andReturn(FALSE);

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
        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('fooprocessor')
                      ->andReturn(FALSE);

        $this->logger->shouldReceive('warning')
                     ->once()
                     ->with('Unable to find pipeline component: ({name})', [ 'name' => 'FooProcessor' ]);

        $this->assertNull($this->class->getProcessor('foo'));
    }

    /**
     * Test that getProcessor() returns an instance from the locator.
     *
     * @covers Pipeline\Common\Locator::getProcessor
     */
    public function testGetProcessorFetchesInstanceFromLocator(): void
    {
        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('mockprocessor')
                      ->andReturn(TRUE);

        $this->locator->shouldReceive('get')
                      ->once()
                      ->with('mockprocessor')
                      ->andReturn($this->processor);

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

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('mockprocessor')
                      ->andReturn(FALSE);

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
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Tests\Common\Helpers' ]);

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('fooprocessor')
                      ->andReturn(FALSE);

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
        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('fooparser')
                      ->andReturn(FALSE);

        $this->logger->shouldReceive('warning')
                     ->once()
                     ->with('Unable to find pipeline component: ({name})', [ 'name' => 'FooParser' ]);

        $this->assertNull($this->class->getParser('foo'));
    }

    /**
     * Test that getParser() returns an instance from the locator.
     *
     * @covers Pipeline\Common\Locator::getParser
     */
    public function testGetParserFetchesInstanceFromLocator(): void
    {

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('mockparser')
                      ->andReturn(TRUE);

        $this->locator->shouldReceive('get')
                      ->once()
                      ->with('mockparser')
                      ->andReturn($this->parser);

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

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('mockparser')
                      ->andReturn(FALSE);

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
        $this->setReflectionPropertyValue('namespaces', [ 'Pipeline', 'Pipeline\Tests\Common\Helpers' ]);
        $this->setReflectionPropertyValue('profiler', $this->profiler);

        $this->locator->shouldReceive('has')
                      ->once()
                      ->with('fooparser')
                      ->andReturn(FALSE);

        $instance = $this->class->getParser('foo');

        $this->assertInstanceOf(FooParser::class, $instance);
    }

}

?>
