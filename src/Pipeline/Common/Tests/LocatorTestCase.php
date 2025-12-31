<?php

/**
 * This file contains the LocatorTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests;

use Lunr\Halo\LunrBaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;
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

    /**
     * Mock instance of the Logger.
     * @var LoggerInterface&MockObject
     */
    protected LoggerInterface&MockObject $logger;

    /**
     * Mock instance of the ContainerInterface.
     * @var ContainerInterface&MockObject
     */
    protected ContainerInterface&MockObject $locator;

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
        $this->logger = $this->getMockBuilder(LoggerInterface::class)
                             ->getMock();

        $this->locator = $this->getMockBuilder(ContainerInterface::class)
                              ->getMock();

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
