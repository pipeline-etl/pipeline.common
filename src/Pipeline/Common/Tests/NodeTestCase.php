<?php

/**
 * This file contains the NodeTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests;

use Lunr\Halo\LunrBaseTestCase;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Pipeline\Common\Node;
use Psr\Log\LoggerInterface;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Node class.
 *
 * @covers Pipeline\Common\Node
 */
abstract class NodeTestCase extends LunrBaseTestCase
{

    use MockeryPHPUnitIntegration;

    /**
     * Mock instance of the Logger.
     * @var LoggerInterface&MockObject
     */
    protected LoggerInterface&MockObject $logger;

    /**
     * Instance of the tested class.
     * @var Node&MockInterface
     */
    protected Node&MockInterface $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder(LoggerInterface::class)
                             ->getMock();

        $this->class = Mockery::mock(Node::class, [ $this->logger ]);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->logger);
    }

}

?>
