<?php

/**
 * This file contains the NodeLogTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;
use Psr\Log\LogLevel;

/**
 * This class contains tests for the Node class.
 *
 * @covers Pipeline\Common\Node
 */
class NodeLogTest extends NodeTestCase
{

    use PsrLoggerTestTrait;

    /**
     * Test that log() logs message.
     *
     * @covers Pipeline\Common\Node::log
     */
    public function testLogLogsMessageWithoutIndex(): void
    {
        $context = [
            'class'   => get_class($this->class),
            'index'   => '',
            'message' => 'Message',
        ];

        $this->logger->expects($this->once())
                     ->method('log')
                     ->with('warning', '[{class}]{index} {message}', $context);

        $method = $this->getReflectionMethod('log');

        $method->invokeArgs($this->class, [ LogLevel::WARNING, 'Message' ]);
    }

    /**
     * Test that logIncompleteConfiguration() logs message.
     *
     * @covers Pipeline\Common\Node::logIncompleteConfiguration
     */
    public function testLogIncompleteConfigurationLogsMessageWithoutIndex(): void
    {
        $context = [
            'class'   => get_class($this->class),
            'index'   => '',
            'message' => 'Incomplete configuration: Message',
        ];

        $this->logger->expects($this->once())
                     ->method('log')
                     ->with('warning', '[{class}]{index} {message}', $context);

        $method = $this->getReflectionMethod('logIncompleteConfiguration');

        $method->invokeArgs($this->class, [ 'Message' ]);
    }

    /**
     * Test that logInvalidConfiguration() logs message.
     *
     * @covers Pipeline\Common\Node::logInvalidConfiguration
     */
    public function testLogInvalidConfigurationLogsMessageWithoutIndex(): void
    {
        $context = [
            'class'   => get_class($this->class),
            'index'   => '',
            'message' => 'Invalid configuration: Message',
        ];

        $this->logger->expects($this->once())
                     ->method('log')
                     ->with('warning', '[{class}]{index} {message}', $context);

        $method = $this->getReflectionMethod('logInvalidConfiguration');

        $method->invokeArgs($this->class, [ 'Message' ]);
    }

}

?>
