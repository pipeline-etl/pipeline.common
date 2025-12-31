<?php

/**
 * This file contains the FooProcessor class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests\Helpers\Processors;

use Pipeline\Common\Node;
use Pipeline\Common\ProcessorInterface;
use Psr\Log\LoggerInterface;

/**
 * Foo Pipeline Processor.
 *
 * @phpstan-import-type Item from Node
 * @phpstan-import-type ProcessorConfig from ProcessorInterface
 */
class FooProcessor extends Node implements ProcessorInterface
{

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
     * Process source data.
     *
     * @param Item            $item   Source data to process
     * @param ProcessorConfig $config Configuration parameters necessary to process the data
     *
     * @return Item Processed data
     */
    public function process(array $item, array $config): array
    {
        return $item;
    }

}

?>
