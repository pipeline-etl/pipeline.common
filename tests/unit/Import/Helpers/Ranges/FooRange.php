<?php

/**
 * This file contains the FooRange class.
 *
 * SPDX-FileCopyrightText: Copyright 2026 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Import\Helpers\Ranges;

use Pipeline\Common\Node;
use Pipeline\Import\ContentRangeInterface;
use Pipeline\Import\ImportInfo;
use Psr\Log\LoggerInterface;

/**
 * Foo Pipeline Content Range.
 *
 * @phpstan-import-type ProcessedItem from Node
 * @phpstan-import-type ContentRangeConfig from ImportInfo
 */
class FooRange extends Node implements ContentRangeInterface
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
     * Set the range data.
     *
     * @param ProcessedItem[]    $data   Full data set
     * @param ContentRangeConfig $config Range config
     *
     * @return void
     */
    public function setData(array &$data, array $config): void
    {
        // no-op
    }

    /**
     * Apply range.
     *
     * @return void
     */
    public function apply(): void
    {
        // no-op
    }

    /**
     * Check whether the class holds an empty range.
     *
     * @return bool TRUE if empty, FALSE otherwise
     */
    public function isEmpty(): bool
    {
        return FALSE;
    }

}

?>
