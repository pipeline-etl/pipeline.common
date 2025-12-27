<?php

/**
 * This file contains the Processor Runner interface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common;

/**
 * Processor Runner Interface.
 *
 * @phpstan-import-type Item from Node
 * @phpstan-import-type ProcessorConfig from ProcessorInterface
 * @phpstan-type ProcessorIdentifier string
 */
interface ProcessorRunnerInterface
{

    /**
     * Run a processor.
     *
     * @param ProcessorIdentifier $processor       Processor identifier
     * @param ProcessorConfig     $processorConfig Processor configuration
     * @param Item                $item            Data to process
     *
     * @return Item Processed item
     */
    public function run(string $processor, array $processorConfig, array $item): array;

}

?>
