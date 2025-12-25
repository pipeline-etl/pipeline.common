<?php

/**
 * This file contains the Pipeline Content Range interface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import;

use Pipeline\Common\Node;

/**
 * Pipeline Content Range.
 *
 * @phpstan-import-type ProcessedItem from Node
 * @phpstan-import-type ContentRangeConfig from ImportInfo
 */
interface ContentRangeInterface
{

    /**
     * Set the range data.
     *
     * @param ProcessedItem[]    $data   Full data set
     * @param ContentRangeConfig $config Range config
     *
     * @return void
     */
    public function setData(array &$data, array $config): void;

    /**
     * Apply range.
     *
     * @return void
     */
    public function apply(): void;

    /**
     * Check whether the class holds an empty range.
     *
     * @return bool TRUE if empty, FALSE otherwise
     */
    public function isEmpty(): bool;

}

?>
