<?php

/**
 * This file contains the Pipeline Flattener interface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common;

/**
 * Pipeline Flattener Interface.
 *
 * @phpstan-import-type FetchedData from SourceInterface
 * @phpstan-import-type Item from Node
 * @phpstan-type FlattenerFieldConfig array<string, string>
 * @phpstan-type FlattenerConfig array{
 *     config?: array<string, string>,
 *     fields?: array<string, int|string|FlattenerFieldConfig>,
 * }
 */
interface FlattenerInterface
{

    /**
     * Flatten source data into a single array of items.
     *
     * @param FetchedData     $data   Source data to flatten
     * @param FlattenerConfig $config Configuration parameters necessary to process the data
     *
     * @return Item[] Array of flattened data
     */
    public function process(array $data, array $config): array;

}

?>
