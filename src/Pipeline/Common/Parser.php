<?php

/**
 * This file contains a base Parser class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common;

use Lunr\Ticks\Profiling\Profiler;
use Psr\Log\LoggerInterface;

/**
 * Parser class.
 *
 * @phpstan-import-type Item from Node
 * @phpstan-import-type ProcessedItem from Node
 * @phpstan-import-type ProcessorConfig from ProcessorInterface
 */
abstract class Parser extends Node
{

    /**
     * Object keeping track of the pipeline run.
     * @var Profiler
     */
    protected readonly Profiler $profiler;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger   Shared instance of the Logger class
     * @param Profiler        $profiler Instance of the Profiler class
     */
    public function __construct(LoggerInterface $logger, Profiler $profiler)
    {
        parent::__construct($logger);

        $this->profiler = $profiler;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Process source data.
     *
     * @param Item[]          $data   Source data to process
     * @param ProcessorConfig $config Configuration parameters necessary to process the data
     *
     * @return ProcessedItem[] Processed data
     */
    abstract public function process(array $data, array $config): array;

    /**
     * Report a pipeline step
     *
     * @param string $message Message to log
     *
     * @return void
     */
    protected function reportStep(string $message)
    {
        $this->profiler->startNewSpan($message);
        $this->logger->notice($message);
    }

}

?>
