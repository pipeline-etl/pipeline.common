<?php

/**
 * This file contains the ItemObserverInterface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import;

use Pipeline\Common\Node;

/**
 * Compare two sets of data and classify differences.
 *
 * @phpstan-import-type ProcessedItem from Node
 */
interface ItemObserverInterface
{

    /**
     * Get the list of keys that represent the identifier of an item.
     *
     * @return string[] Set of identifier keys
     */
    public function getIdentifierKeys(): array;

    /**
     * Get the list of keys that determine the age/version of an item.
     *
     * @return string[]
     */
    public function getTimeKeys(): array;

    /**
     * Get a unique string identifier for the passed data item.
     *
     * @param ProcessedItem $item Item data
     *
     * @return string Unique item identifier as string
     */
    public function getItemIdentifier(array $item): string;

    /**
     * Get a string identifier for the passed data item based on a set of keys.
     *
     * @param ProcessedItem $item      Item data
     * @param string[]      $indexKeys Set of keys comprising an index
     *
     * @return string Identifier as string
     */
    public function getUniqueIdentifier(array $item, array $indexKeys): string;

    /**
     * Get a UUID for a given item identifier.
     *
     * One identifier yields the same UUID for the duration of the pipeline run.
     *
     * @param string $identifier Item Identifier
     *
     * @return string Content UUID
     */
    public function getItemUuid(string $identifier): string;

}

?>
