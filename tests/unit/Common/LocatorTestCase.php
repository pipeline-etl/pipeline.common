<?php

/**
 * This file contains the LocatorTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Common;

use Lunr\Halo\LunrBaseTestCase;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Pipeline\Common\Locator;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Locator class.
 *
 * @covers Pipeline\Common\Locator
 */
abstract class LocatorTestCase extends LunrBaseTestCase
{

    use MockeryPHPUnitIntegration;

    /**
     * Mock instance of the Logger.
     * @var LoggerInterface&MockInterface
     */
    protected LoggerInterface&MockInterface $logger;

    /**
     * Mock instance of the ContainerInterface.
     * @var ContainerInterface&MockInterface
     */
    protected ContainerInterface&MockInterface $locator;

    /**
     * Instance of the tested class.
     * @var Locator
     */
    protected Locator $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->logger = Mockery::mock(LoggerInterface::class);

        $this->locator = Mockery::mock(ContainerInterface::class);

        $this->class = new Locator($this->locator, $this->logger);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->logger);
        unset($this->locator);
        unset($this->class);
    }

}

?>
