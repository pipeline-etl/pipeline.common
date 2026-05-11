<?php

/**
 * This file contains the ImportLocatorTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2026 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Import;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Pipeline\Import\ImportLocator;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the ImportLocator class.
 *
 * @covers Pipeline\Import\ImportLocator
 */
abstract class ImportLocatorTestCase extends MockeryTestCase
{

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
     * @var ImportLocator
     */
    protected ImportLocator $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->logger = Mockery::mock(LoggerInterface::class);

        $this->locator = Mockery::mock(ContainerInterface::class);

        $this->class = new ImportLocator($this->locator, $this->logger);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->logger);
        unset($this->locator);
        unset($this->class);
    }

}

?>
