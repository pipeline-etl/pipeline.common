<?php

/**
 * This file contains the basic Info class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common;

use Lunr\Ticks\Profiling\Profiler;

/**
 * Pipeline metadata and runtime information.
 */
class Info implements InfoInterface
{

    /**
     * Name/Identifier of the pipeline.
     * @var string
     */
    protected readonly string $identifier;

    /**
     * Profiler keeping track of the pipeline run.
     * @var Profiler
     */
    public readonly Profiler $profiler;

    /**
     * String identifier for the config section this info object expects to be populated with
     * @var string
     */
    protected const INFO_IDENTIFIER = 'info';

    /**
     * Constructor.
     *
     * @param Profiler $profiler Profiler keeping track of the pipeline run
     */
    public function __construct(Profiler $profiler)
    {
        $this->profiler = $profiler;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // no-op
    }

    /**
     * Set the name/identifier for the pipeline.
     *
     * @param string $id Pipeline name/identifier
     *
     * @return void
     */
    public function setPipelineIdentifier(string $id): void
    {
        $this->identifier = $id;

        $this->profiler->addTag('pipeline', $id);
    }

    /**
     * Get the name/identifier of the current pipeline.
     *
     * @return string Pipeline name/identifier
     */
    public function getPipelineIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Get the profiler for the current pipeline run.
     *
     * @return Profiler The pipeline profiler
     */
    public function getProfiler(): Profiler
    {
        return $this->profiler;
    }

    /**
     * Get the string identifier for the config section this info object expects to be populated with.
     *
     * @return string The expected config identifier
     */
    public function getInfoIdentifier(): string
    {
        return static::INFO_IDENTIFIER;
    }

    /**
     * Populate the Info object with the parsed data from the pipeline configuration.
     *
     * @param array<string, mixed> $info Parsed info data
     *
     * @return void
     */
    public function populate(array $info): void
    {
        // no-op
    }

}

?>
