<?php

/**
 * This file contains the FooParser class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests\Helpers\Parsers;

use Lunr\Ticks\Profiling\Profiler;
use Pipeline\Common\Node;
use Pipeline\Common\Parser;
use Psr\Log\LoggerInterface;

/**
 * Foo Pipeline Parser.
 *
 * @phpstan-import-type Item from Node
 * @phpstan-import-type ProcessedItem from Node
 * @phpstan-import-type ProcessorConfig from ProcessorInterface
 */
class FooParser extends Parser
{

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger   Shared instance of the Logger class
     * @param Profiler        $profiler Instance of the Profiler class
     */
    public function __construct(LoggerInterface $logger, Profiler $profiler)
    {
        parent::__construct($logger, $profiler);
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
    public function process(array $data, array $config): array
    {
        return $data;
    }

}

?>
