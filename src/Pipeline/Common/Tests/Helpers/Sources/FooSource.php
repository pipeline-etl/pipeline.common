<?php

/**
 * This file contains the FooSource class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests\Helpers\Sources;

use Pipeline\Common\Node;
use Pipeline\Common\SourceInterface;
use Psr\Log\LoggerInterface;

/**
 * Foo Pipeline Source.
 *
 * @phpstan-import-type Item from Node
 * @phpstan-import-type FetchedData from SourceInterface
 * @phpstan-import-type SourceConfig from SourceInterface
 */
class FooSource extends Node implements SourceInterface
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
     * Retrieve source data to process in the pipeline.
     *
     * @param SourceConfig $config Configuration parameters necessary to retrieve the data
     *
     * @return FetchedData Array of results fetched from the source
     */
    public function fetch(array $config): array
    {
        return [];
    }

}

?>
