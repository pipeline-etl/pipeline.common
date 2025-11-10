<?php

/**
 * This file contains the Pipeline Preprocessor interface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common;

/**
 * Pipeline Preprocessor Interface.
 *
 * @phpstan-import-type Item from Node
 * @phpstan-import-type ProcessorConfig from ProcessorInterface
 */
interface PreprocessorInterface
{

    /**
     * Process source data.
     *
     * @param Item[]          $data   Source data to process
     * @param ProcessorConfig $config Configuration parameters necessary to process the data
     *
     * @return Item[] Processed data
     */
    public function process(array $data, array $config): array;

}

?>
