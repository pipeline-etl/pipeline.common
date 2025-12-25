<?php

/**
 * This file contains the Node class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Pipeline Node class.
 *
 * @phpstan-type Item array<string,scalar|array<array-key, mixed>|object|null>
 * @phpstan-type ProcessedItem array<string,scalar|null>
 */
abstract class Node
{

    /**
     * Shared instance of the Logger class.
     * @var LoggerInterface
     */
    protected readonly LoggerInterface $logger;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger Shared instance of the Logger class
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // no-op
    }

    /**
     * Log pipeline related messages.
     *
     * @param LogLevel::* $level   PSR-3 Log Level
     * @param string      $message Log message
     * @param int|null    $index   Node configuration index
     *
     * @return void
     */
    protected function log(string $level, string $message, ?int $index = NULL): void
    {
        $class = get_class($this);

        $context = [
            'class'   => substr($class, (strrpos($class, '\\') ?: -1) + 1),
            'index'   => is_null($index) ? '' : "[@$index]",
            'message' => $message,
        ];

        $this->logger->log($level, '[{class}]{index} {message}', $context);
    }

    /**
     * Log incomplete configuration.
     *
     * @param string   $message Log message
     * @param int|null $index   Node configuration index
     *
     * @return void
     */
    protected function logIncompleteConfiguration(string $message, ?int $index = NULL): void
    {
        $this->log(LogLevel::WARNING, 'Incomplete configuration: ' . $message, $index);
    }

    /**
     * Log invalid configuration.
     *
     * @param string   $message Log message
     * @param int|null $index   Node configuration index
     *
     * @return void
     */
    protected function logInvalidConfiguration(string $message, ?int $index = NULL): void
    {
        $this->log(LogLevel::WARNING, 'Invalid configuration: ' . $message, $index);
    }

}

?>
