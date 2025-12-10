<?php

/**
 * This file contains the ImportTargetInterface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import;

use Pipeline\Common\Node;

/**
 * Interface for interacting with the target of the import.
 *
 * @phpstan-import-type Item from Node
 * @phpstan-type UniqueKey array{
 *     name: string,
 *     keys: string[]
 * }
 */
interface ImportTargetInterface
{

    /**
     * Set target to import data to.
     *
     * @param string $target Target name
     *
     * @return void
     */
    public function setTarget(string $target): void;

    /**
     * Get the keys that form the identifier.
     *
     * @return string[] List of keys
     */
    public function getIdentifierKeys(): array;

    /**
     * Get the keys that form the age/version information.
     *
     * @return string[] List of keys
     */
    public function getTimeKeys(): array;

    /**
     * Get the keys for any present unique constraints.
     *
     * @return UniqueKey[] List of indexes and their keys
     */
    public function getUniqueKeys(): array;

    /**
     * Update information.
     *
     * @param Item[]                  $data   New information
     * @param ContentRangeInterface[] $ranges Data subset specifiers
     *
     * @return int Number of affected items
     */
    public function updateData(array $data, array $ranges = []): int;

    /**
     * Get current data.
     *
     * @param string[]|null           $fields Array of field names to select
     * @param ContentRangeInterface[] $ranges Data subset specifiers
     *
     * @return Item[] Array of items
     */
    public function getData(?array $fields = NULL, array $ranges = []): array;

}

?>
