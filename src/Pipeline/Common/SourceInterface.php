<?php

/**
 * This file contains the Pipeline Source interface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common;

/**
 * Pipeline Source Interface.
 *
 * @phpstan-import-type Item from Node
 * @phpstan-type SourceConfig array<string, scalar|array<string, mixed>>
 * @phpstan-type FetchedData string[]|list<Item[]>
 */
interface SourceInterface
{

    /**
     * Retrieve source data to process in the pipeline.
     *
     * @param SourceConfig $config Configuration parameters necessary to retrieve the data
     *
     * @return FetchedData Array of results fetched from the source
     */
    public function fetch(array $config): array;

}

?>
