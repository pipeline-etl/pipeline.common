<?php

/**
 * This file contains the FlowControlProcessor class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common;

use Psr\Log\LoggerInterface;

/**
 * FlowControl Pipeline Processor.
 */
abstract class FlowControlProcessor extends Node
{

    /**
     * Shared instance of a processor runner.
     * @var ProcessorRunnerInterface
     */
    protected readonly ProcessorRunnerInterface $runner;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger Shared instance of the Logger class
     */
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Link a processor runner.
     *
     * @param ProcessorRunnerInterface $runner Instance of a processor runner.
     *
     * @return void
     */
    public function link(ProcessorRunnerInterface $runner): void
    {
        $this->runner = $runner;
    }

}

?>
