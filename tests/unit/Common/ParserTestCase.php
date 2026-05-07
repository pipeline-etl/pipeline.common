<?php

/**
 * This file contains the ParserTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Common;

use Lunr\Halo\LunrBaseTestCase;
use Lunr\Ticks\Profiling\Profiler;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
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
     * @var LoggerInterface&MockInterface
     */
    protected LoggerInterface&MockInterface $logger;

    /**
     * Mock instance of the Profiler class.
     * @var Profiler&MockInterface
     */
    protected Profiler&MockInterface $profiler;

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
        $this->logger = Mockery::mock(LoggerInterface::class);

        $this->profiler = Mockery::mock(Profiler::class);

        $this->class = Mockery::mock(Parser::class, [ $this->logger, $this->profiler ]);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->logger);
        unset($this->profiler);
        unset($this->class);
    }

}

?>
