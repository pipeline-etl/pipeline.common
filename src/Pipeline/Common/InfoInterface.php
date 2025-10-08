<?php

/**
 * This file contains the Info Interface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common;

use Lunr\Ticks\Profiling\Profiler;

/**
 * Pipeline metadata and runtime information.
 */
interface InfoInterface
{

    /**
     * Set the name/identifier for the pipeline.
     *
     * @param string $id Pipeline name/identifier
     *
     * @return void
     */
    public function setPipelineIdentifier(string $id): void;

    /**
     * Get the name/identifier of the current pipeline.
     *
     * @return string Pipeline name/identifier
     */
    public function getPipelineIdentifier(): string;

    /**
     * Get the profiler for the current pipeline run.
     *
     * @return Profiler The pipeline profiler
     */
    public function getProfiler(): Profiler;

    /**
     * Get the string identifier for the config section this info object expects to be populated with.
     *
     * @return string The expected config identifier
     */
    public function getInfoIdentifier(): string;

    /**
     * Populate the Info object with the parsed data from the pipeline configuration.
     *
     * @param array<string, mixed> $info Parsed info data
     *
     * @return void
     */
    public function populate(array $info): void;

}

?>
