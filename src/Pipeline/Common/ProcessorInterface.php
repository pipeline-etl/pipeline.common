<?php

/**
 * This file contains the Pipeline Processor interface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common;

/**
 * Pipeline Processor Interface.
 *
 * @phpstan-import-type Item from Node
 * @phpstan-type ProcessorConfigElement array<string, mixed>
 * @phpstan-type ProcessorConfig ProcessorConfigElement|ProcessorConfigElement[]
 */
interface ProcessorInterface
{

    /**
     * Process source data.
     *
     * @param Item            $item   Source data to process
     * @param ProcessorConfig $config Configuration parameters necessary to process the data
     *
     * @return Item Processed data
     */
    public function process(array $item, array $config): array;

}

?>
