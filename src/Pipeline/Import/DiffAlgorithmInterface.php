<?php

/**
 * This file contains the DiffAlgorithmInterface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import;

use Pipeline\Common\Node;

/**
 * Compare two sets of data and categorize differences.
 *
 * @phpstan-import-type ProcessedItem from Node
 * @phpstan-type IndexedItemList array<string,ProcessedItem>
 */
interface DiffAlgorithmInterface
{

    /**
     * Get the data items that were categorized as new.
     *
     * @return ProcessedItem[] Array of new data items
     */
    public function getNewData(): array;

    /**
     * Get the data items that were categorized as updated.
     *
     * @return ProcessedItem[] Array of updated data items
     */
    public function getUpdatedData(): array;

    /**
     * Get the data items that were categorized as obsolete.
     *
     * @return ProcessedItem[] Array of obsolete data items
     */
    public function getObsoleteData(): array;

    /**
     * Get the data items that were categorized as same.
     *
     * @return ProcessedItem[] Array of same data items
     */
    public function getSameData(): array;

    /**
     * Get the data items that were categorized as skipped.
     *
     * @return ProcessedItem[] Array of skipped data items
     */
    public function getSkippedData(): array;

    /**
     * Get the old data items that were marked as updated, indexed by the item identifier.
     *
     * @return IndexedItemList Array of base data items
     */
    public function getBaseData(): array;

    /**
     * Get the diff between the old data and the new data, indexed by the item identifier.
     *
     * @return IndexedItemList Array of diffs
     */
    public function getDiffedData(): array;

    /**
     * Set whether time only key changes should be skipped.
     *
     * @param bool $value Flag value
     *
     * @return void
     */
    public function skipTimeKeyOnlyChange(bool $value): void;

    /**
     * Diff two lists of items.
     *
     * @param ProcessedItem[] $old Base information
     * @param ProcessedItem[] $new New information
     *
     * @return void
     */
    public function diff(array $old, array $new): void;

}

?>
