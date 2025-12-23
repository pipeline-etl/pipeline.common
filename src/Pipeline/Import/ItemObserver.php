<?php

/**
 * This file contains the ItemObserver.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import;

use Pipeline\Common\Node;
use Pipeline\Import\Exceptions\DatabaseException;

/**
 * Compare two sets of data and classify differences.
 *
 * @phpstan-import-type ProcessedItem from Node
 */
class ItemObserver implements ItemObserverInterface
{

    /**
     * Shared instance of an import target.
     * @var ImportTargetInterface
     */
    protected readonly ImportTargetInterface $importTarget;

    /**
     * Keys to identify data by.
     * @var string[]
     */
    protected array $identifierKeys;

    /**
     * Keys to identify data age by.
     * @var string[]
     */
    protected array $timeKeys;

    /**
     * Registry of UUIDs for specific content identifiers
     * @var array<string, string>
     */
    protected array $itemUuids;

    /**
     * Constructor.
     *
     * @param ImportTargetInterface $importTarget Shared instance of an import target
     */
    public function __construct(ImportTargetInterface $importTarget)
    {
        $this->importTarget = $importTarget;

        $this->itemUuids = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->itemUuids = [];
    }

    /**
     * Get the list of keys that represent the identifier of an item.
     *
     * @return string[] Set of identifier keys
     */
    public function getIdentifierKeys(): array
    {
        if (isset($this->identifierKeys))
        {
            return $this->identifierKeys;
        }

        $this->identifierKeys = $this->importTarget->getIdentifierKeys();

        if (empty($this->identifierKeys))
        {
            throw new DatabaseException('No object identifier found in content model!');
        }

        return $this->identifierKeys;
    }

    /**
     * Get the list of keys that determine the age/version of an item.
     *
     * @return string[]
     */
    public function getTimeKeys(): array
    {
        if (isset($this->timeKeys))
        {
            return $this->timeKeys;
        }

        $this->timeKeys = $this->importTarget->getTimeKeys();

        if (empty($this->timeKeys))
        {
            throw new DatabaseException('No time key found in content model!');
        }

        return $this->timeKeys;
    }

    /**
     * Get a unique string identifier for the passed data item.
     *
     * @param ProcessedItem $item Item data
     *
     * @return string Unique item identifier as string
     */
    public function getItemIdentifier(array $item): string
    {
        return $this->getUniqueIdentifier($item, $this->getIdentifierKeys());
    }

    /**
     * Get a string identifier for the passed data item based on a set of keys.
     *
     * @param ProcessedItem $item      Item data
     * @param string[]      $indexKeys Set of keys comprising an index
     *
     * @return string Identifier as string
     */
    public function getUniqueIdentifier(array $item, array $indexKeys): string
    {
        $fields = [];

        foreach ($indexKeys as $key)
        {
            switch (gettype($item[$key]))
            {
                case 'boolean':
                    $fields[] = (string) intval($item[$key]);
                    break;
                case 'NULL':
                    $fields[] = 'NULL';
                    break;
                default:
                    $fields[] = (string) $item[$key];
                    break;
            }
        }

        return implode('_', $fields);
    }

    /**
     * Get a UUID for a given item identifier.
     *
     * One identifier yields the same UUID for the duration of the pipeline run.
     *
     * @param string $identifier Item Identifier
     *
     * @return string Item UUID
     */
    public function getItemUuid(string $identifier): string
    {
        if (!array_key_exists($identifier, $this->itemUuids))
        {
            $this->itemUuids[$identifier] = uuid_create();
        }

        return $this->itemUuids[$identifier];
    }

}

?>
