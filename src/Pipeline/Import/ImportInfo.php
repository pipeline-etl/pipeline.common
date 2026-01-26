<?php

/**
 * This file contains the ImportInfo class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import;

use Lunr\Ticks\Profiling\Profiler;
use Pipeline\Common\Exceptions\InvalidConfigurationException;
use Pipeline\Common\Info;

/**
 * Pipeline metadata and runtime information specific to Imports.
 *
 * @phpstan-type HookIdentifier string
 * @phpstan-type RangeIdentifier string
 * @phpstan-type ContentRangeConfig array<string, scalar>
 * @phpstan-type HookConfig array<string, mixed>
 * @phpstan-type ContentRange array<RangeIdentifier, ContentRangeConfig>
 * @phpstan-type Hook array<HookIdentifier, HookConfig>
 * @phpstan-type ImportInfoData array{
 *     content_type?: string,
 *     target?: string,
 *     content_range?: ContentRange[],
 *     hooks?: Hook[],
 *     flags?: list<value-of<Flag>>,
 * }
 * @phpstan-type ImportResults array<value-of<DataDiffCategory>, int>
 */
class ImportInfo extends Info
{

    /**
     * Name of the target that should receive the imported information.
     * @var string
     */
    protected readonly string $target;

    /**
     * Content type identifier of the data the pipeline imports.
     * @var string
     */
    protected readonly string $contentType;

    /**
     * The range of content the import should compare against in the target.
     * @var ContentRange[]
     */
    protected readonly array $ranges;

    /**
     * Behavior flags for the import.
     * @var Flag[]
     */
    protected readonly array $flags;

    /**
     * Set of hooks to execute when the pipeline contains changes.
     * @var Hook[]
     */
    protected readonly array $hooks;

    /**
     * The import results.
     * @var ImportResults
     */
    protected readonly array $results;

    /**
     * String identifier for the config section this info object expects to be populated with
     * @var string
     */
    protected const INFO_IDENTIFIER = 'import_info';

    /**
     * Constructor.
     *
     * @param Profiler $profiler Profiler keeping track of the pipeline run
     */
    public function __construct(Profiler $profiler)
    {
        parent::__construct($profiler);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Get the name/identifier for the target.
     *
     * @return string Target name/identifier
     */
    public function getTargetIdentifier(): string
    {
        return $this->target;
    }

    /**
     * Get the name/identifier for the content type.
     *
     * @return string Content type name/identifier
     */
    public function getContentTypeIdentifier(): string
    {
        return $this->contentType;
    }

    /**
     * Get the configured hooks.
     *
     * @return Hook[] List of configured hooks.
     */
    public function getHooks(): array
    {
        return $this->hooks;
    }

    /**
     * Get the configured content ranges.
     *
     * @return ContentRange[] List of configured content ranges.
     */
    public function getContentRanges(): array
    {
        return $this->ranges;
    }

    /**
     * Set final results of the import
     *
     * @param int $new      Amount of new items
     * @param int $obsolete Amount of obsolete items
     * @param int $updated  Amount of updated items
     * @param int $skipped  Amount of skipped items
     * @param int $same     Amount of same items
     *
     * @return void
     */
    public function setResults(int $new, int $obsolete, int $updated, int $skipped, int $same): void
    {
        $results = [];

        $results[DataDiffCategory::New->value]      = $new;
        $results[DataDiffCategory::Obsolete->value] = $obsolete;
        $results[DataDiffCategory::Updated->value]  = $updated;
        $results[DataDiffCategory::Skipped->value]  = $skipped;
        $results[DataDiffCategory::Same->value]     = $same;
        $results[DataDiffCategory::Total->value]    = $new + $updated + $skipped + $same;

        $this->profiler->addFields($results);

        $this->results = $results;
    }

    /**
     * Get the import result for a data category.
     *
     * @param DataDiffCategory $category Data category
     *
     * @return int Count of items in a given category
     */
    public function getResult(DataDiffCategory $category): int
    {
        return $this->results[$category->value] ?? 0;
    }

    /**
     * Check whether the import has a flag set or not.
     *
     * @param Flag $flag The flag to check
     *
     * @return bool Whether the import has a flag set or not.
     */
    public function hasFlag(Flag $flag): bool
    {
        return in_array($flag, $this->flags);
    }

    /**
     * Populate the Info object with the parsed data from the pipeline configuration.
     *
     * @param ImportInfoData $info Parsed info data
     *
     * @return void
     */
    public function populate(array $info): void
    {
        $this->contentType = $info['content_type'] ?? $this->identifier;

        $this->profiler->addTag('contentType', $this->contentType);

        $this->target = $info['target'] ?? $this->identifier;

        $this->ranges = $info['content_range'] ?? [];

        $this->hooks = $info['hooks'] ?? [];

        $flags = [];

        if (isset($info['flags']) && !empty($info['flags']))
        {
            foreach ($info['flags'] as $flag)
            {
                $flag = Flag::tryFrom($flag);

                // phpdoc says only valid flags are allowed in the list, but we have no way to enforce that
                // so we do still need to account for invalid values here
                // @phpstan-ignore identical.alwaysFalse
                if ($flag === NULL)
                {
                    throw new InvalidConfigurationException('Invalid import flag!');
                }

                $flags[] = $flag;
            }
        }

        $this->flags = $flags;
    }

}

?>
