<?php

/**
 * This file contains the FooPreprocessor class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests\Helpers\Preprocessors;

use Pipeline\Common\Node;
use Pipeline\Common\PreprocessorInterface;
use Psr\Log\LoggerInterface;

/**
 * Foo Pipeline Processor.
 *
 * @phpstan-import-type Item from Node
 * @phpstan-import-type ProcessorConfig from ProcessorInterface
 */
class FooPreprocessor extends Node implements PreprocessorInterface
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
     * @param Item[]          $data   Source data to process
     * @param ProcessorConfig $config Configuration parameters necessary to process the data
     *
     * @return Item[] Processed data
     */
    public function process(array $data, array $config): array
    {
        return $data;
    }

}

?>
