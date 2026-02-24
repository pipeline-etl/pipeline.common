<?php

/**
 * This file contains the Diff class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import;

use Pipeline\Common\Node;

/**
 * Create Content Diffs.
 *
 * @phpstan-import-type ProcessedItem from Node
 * @phpstan-import-type IndexedItemList from DiffAlgorithmInterface
 * @phpstan-type SplitData array{
 *     new: ProcessedItem[],
 *     updated: ProcessedItem[],
 *     obsolete: ProcessedItem[],
 *     same: ProcessedItem[],
 *     skipped: ProcessedItem[],
 * }
 */
class Diff implements DiffAlgorithmInterface
{

    /**
     * Shared instance of an item observer
     * @var ItemObserverInterface
     */
    protected readonly ItemObserverInterface $observer;

    /**
     * Categorized data array
     * @var SplitData
     */
    protected array $splitData;

    /**
     * Base data array
     * @var IndexedItemList
     */
    protected array $baseData;

    /**
     * Diffed data array
     * @var IndexedItemList
     */
    protected array $diffedData;

    /**
     * Whether time key only changes should be skipped
     * @var bool
     */
    protected bool $skipTimeKeyOnlyChange;

    /**
     * Constructor.
     *
     * @param ItemObserverInterface $observer Shared instance of an item observer
     */
    public function __construct(ItemObserverInterface $observer)
    {
        $this->observer = $observer;

        $this->splitData = [
            DataDiffCategory::New->value      => [],
            DataDiffCategory::Updated->value  => [],
            DataDiffCategory::Obsolete->value => [],
            DataDiffCategory::Same->value     => [],
            DataDiffCategory::Skipped->value  => [],
        ];

        $this->baseData   = [];
        $this->diffedData = [];

        $this->skipTimeKeyOnlyChange = TRUE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->splitData = [
            DataDiffCategory::New->value      => [],
            DataDiffCategory::Updated->value  => [],
            DataDiffCategory::Obsolete->value => [],
            DataDiffCategory::Same->value     => [],
            DataDiffCategory::Skipped->value  => [],
        ];

        $this->baseData   = [];
        $this->diffedData = [];
    }

    /**
     * Diff two lists of items.
     *
     * @param ProcessedItem[] $old Base information
     * @param ProcessedItem[] $new New information
     *
     * @return void
     */
    public function diff(array $old, array $new): void
    {
        $oldIndexed = [];

        // Index the old data on the item identifier so we can compare more efficiently
        while ($oldData = array_shift($old))
        {
            $key = $this->observer->getItemIdentifier($oldData);

            $oldIndexed[$key] = $oldData;
        }

        // Memory efficient foreach
        while ($newData = array_shift($new))
        {
            $key = $this->observer->getItemIdentifier($newData);

            // Add to new if we don't have a matching item in the old data set
            if (!array_key_exists($key, $oldIndexed))
            {
                $this->splitData[DataDiffCategory::New->value][] = $newData;

                unset($oldIndexed[$key]);
                continue;
            }

            // If data has no changes, add to same and move on
            if ($newData == $oldIndexed[$key])
            {
                $this->splitData[DataDiffCategory::Same->value][] = $newData;

                unset($oldIndexed[$key]);
                continue;
            }

            if ($this->shouldSkipItem($oldIndexed[$key], $newData))
            {
                $this->splitData[DataDiffCategory::Skipped->value][] = $newData;

                unset($oldIndexed[$key]);
                continue;
            }

            $this->splitData[DataDiffCategory::Updated->value][] = $newData;

            $this->diffedData[$key] = array_diff($newData, $oldIndexed[$key]);
            $this->baseData[$key]   = $oldIndexed[$key];

            unset($oldIndexed[$key]);
        }

        //everything still left in the old dataset can be deleted
        $this->splitData[DataDiffCategory::Obsolete->value] = array_values($oldIndexed);

        unset($old);
        unset($oldIndexed);
    }

    /**
     * Get the data items that were categorized as new.
     *
     * @return ProcessedItem[] Array of new data items
     */
    public function getNewData(): array
    {
        return $this->splitData[DataDiffCategory::New->value];
    }

    /**
     * Get the data items that were categorized as updated.
     *
     * @return ProcessedItem[] Array of updated data items
     */
    public function getUpdatedData(): array
    {
        return $this->splitData[DataDiffCategory::Updated->value];
    }

    /**
     * Get the data items that were categorized as obsolete.
     *
     * @return ProcessedItem[] Array of obsolete data items
     */
    public function getObsoleteData(): array
    {
        return $this->splitData[DataDiffCategory::Obsolete->value];
    }

    /**
     * Get the data items that were categorized as same.
     *
     * @return ProcessedItem[] Array of same data items
     */
    public function getSameData(): array
    {
        return $this->splitData[DataDiffCategory::Same->value];
    }

    /**
     * Get the data items that were categorized as skipped.
     *
     * @return ProcessedItem[] Array of skipped data items
     */
    public function getSkippedData(): array
    {
        return $this->splitData[DataDiffCategory::Skipped->value];
    }

    /**
     * Get the old data items that were marked as updated, indexed by the item identifier.
     *
     * @return IndexedItemList Array of base data items
     */
    public function getBaseData(): array
    {
        return $this->baseData;
    }

    /**
     * Get the diff between the old data and the new data, indexed by the item identifier.
     *
     * @return IndexedItemList Array of diffs
     */
    public function getDiffedData(): array
    {
        return $this->diffedData;
    }

    /**
     * Set whether time only key changes should be skipped
     *
     * @param bool $value Flag value
     *
     * @return void
     */
    public function skipTimeKeyOnlyChange(bool $value): void
    {
        $this->skipTimeKeyOnlyChange = $value;
    }

    /**
     * Check if the old item already contains newer information than the new item.
     *
     * @param ProcessedItem $old Old information
     * @param ProcessedItem $new New information
     *
     * @return bool TRUE if the new item contains older information, FALSE otherwise
     */
    protected function isOldItemNewer(array $old, array $new): bool
    {
        foreach ($this->observer->getTimeKeys() as $timeKey)
        {
            if (intval($old[$timeKey]) > intval($new[$timeKey]))
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Check if the only change between old and new item is in the time keys.
     *
     * @param ProcessedItem $old Old information
     * @param ProcessedItem $new New information
     *
     * @return bool TRUE if the new item contains only time key changes, FALSE otherwise
     */
    protected function isTimeKeyOnlyChange(array $old, array $new): bool
    {
        $changed = array_udiff_assoc($new, $old, function ($new, $old) { return $new == $old ? 0 : 1; });

        $timeKeys = $this->observer->getTimeKeys();

        foreach (array_keys($changed) as $key)
        {
            if (!in_array($key, $timeKeys))
            {
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * Check if the item should be skipped or not
     *
     * @param ProcessedItem $old Old information
     * @param ProcessedItem $new New information
     *
     * @return bool
     */
    protected function shouldSkipItem(array $old, array $new): bool
    {
        if ($this->isOldItemNewer($old, $new))
        {
            return TRUE;
        }

        if ($this->skipTimeKeyOnlyChange === FALSE)
        {
            return FALSE;
        }

        return $this->isTimeKeyOnlyChange($old, $new);
    }

}

?>
