<?php

/**
 * This file contains the FooFlattener class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests\Helpers\Flatteners;

use Pipeline\Common\FlattenerInterface;
use Pipeline\Common\Node;
use Psr\Log\LoggerInterface;

/**
 * Foo Pipeline Flattener.
 *
 * @phpstan-import-type Item from Node
 * @phpstan-import-type FetchedData from SourceInterface
 * @phpstan-import-type FlattenerConfig from FlattenerInterface
 */
class FooFlattener extends Node implements FlattenerInterface
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
     * Flatten source data into a single array of items.
     *
     * @param FetchedData     $data   Source data to flatten
     * @param FlattenerConfig $config Configuration parameters necessary to process the data
     *
     * @return Item[] Array of flattened data
     */
    public function process(array $data, array $config): array
    {
        return [];
    }

}

?>
