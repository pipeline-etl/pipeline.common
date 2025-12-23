<?php

/**
 * This file contains the test class for the Diff class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import\Tests;

use Pipeline\Import\DataDiffCategory;

/**
 * Test class for the Diff class.
 *
 * @covers Pipeline\Import\Diff
 */
class DiffGetDataTest extends DiffTestCase
{

    /**
     * Test that getNewData() returns an empty array if it is not set.
     *
     * @covers Pipeline\Import\Diff::getNewData
     */
    public function testGetNewDataReturnsEmptyArrayIfNotSet(): void
    {
        $this->assertArrayEmpty($this->class->getNewData());
    }

    /**
     * Test that getNewData() returns the new data.
     *
     * @covers Pipeline\Import\Diff::getNewData
     */
    public function testGetNewDataReturnsNewData(): void
    {
        $this->setReflectionPropertyValue('splitData', [ DataDiffCategory::New->value => [[ 'value' => 'test' ]] ]);

        $this->assertEquals([[ 'value' => 'test' ]], $this->class->getNewData());
    }

    /**
     * Test that getUpdatedData() returns an empty array if it is not set.
     *
     * @covers Pipeline\Import\Diff::getUpdatedData
     */
    public function testGetUpdatedDataReturnsEmptyArrayIfNotSet(): void
    {
        $this->assertArrayEmpty($this->class->getUpdatedData());
    }

    /**
     * Test that getUpdatedData() returns the changed data.
     *
     * @covers Pipeline\Import\Diff::getUpdatedData
     */
    public function testGetUpdatedDataReturnsUpdatedData(): void
    {
        $this->setReflectionPropertyValue('splitData', [ DataDiffCategory::Updated->value => [[ 'value' => 'test' ]] ]);

        $this->assertEquals([[ 'value' => 'test' ]], $this->class->getUpdatedData());
    }

    /**
     * Test that getObsoleteData() returns an empty array if it is not set.
     *
     * @covers Pipeline\Import\Diff::getObsoleteData
     */
    public function testGetObsoleteDataReturnsEmptyArrayIfNotSet(): void
    {
        $this->assertArrayEmpty($this->class->getObsoleteData());
    }

    /**
     * Test that getObsoleteData() returns the obsolete data.
     *
     * @covers Pipeline\Import\Diff::getObsoleteData
     */
    public function testGetObsoleteDataReturnsObsoleteData(): void
    {
        $this->setReflectionPropertyValue('splitData', [ DataDiffCategory::Obsolete->value => [[ 'value' => 'test' ]] ]);

        $this->assertEquals([[ 'value' => 'test' ]], $this->class->getObsoleteData());
    }

    /**
     * Test that getSameData() returns an empty array if it is not set.
     *
     * @covers Pipeline\Import\Diff::getSameData
     */
    public function testGetSameDataReturnsEmptyArrayIfNotSet(): void
    {
        $this->assertArrayEmpty($this->class->getSameData());
    }

    /**
     * Test that getSameData() returns the same data.
     *
     * @covers Pipeline\Import\Diff::getSameData
     */
    public function testGetSameDataReturnsSameData(): void
    {
        $this->setReflectionPropertyValue('splitData', [ DataDiffCategory::Same->value => [[ 'value' => 'test' ]] ]);

        $this->assertEquals([[ 'value' => 'test' ]], $this->class->getSameData());
    }

    /**
     * Test that getSkippedData() returns an empty array if it is not set.
     *
     * @covers Pipeline\Import\Diff::getSkippedData
     */
    public function testGetSkippedDataReturnsEmptyArrayIfNotSet(): void
    {
        $this->assertArrayEmpty($this->class->getSkippedData());
    }

    /**
     * Test that getSkippedData() returns the skipped data.
     *
     * @covers Pipeline\Import\Diff::getSkippedData
     */
    public function testGetSkippedDataReturnsSkippedData(): void
    {
        $this->setReflectionPropertyValue('splitData', [ DataDiffCategory::Skipped->value => [[ 'value' => 'test' ]] ]);

        $this->assertEquals([[ 'value' => 'test' ]], $this->class->getSkippedData());
    }

    /**
     * Test that getBaseData() returns an empty array if it is not set.
     *
     * @covers Pipeline\Import\Diff::getBaseData
     */
    public function testGetBaseDataReturnsEmptyArrayIfNotSet(): void
    {
        $this->assertArrayEmpty($this->class->getBaseData());
    }

    /**
     * Test that getBaseData() returns the base data.
     *
     * @covers Pipeline\Import\Diff::getBaseData
     */
    public function testGetBaseDataReturnsBaseData(): void
    {
        $this->setReflectionPropertyValue('baseData', [[ 'value' => 'test' ]]);

        $this->assertEquals([[ 'value' => 'test' ]], $this->class->getBaseData());
    }

        /**
     * Test that getDiffedData() returns an empty array if it is not set.
     *
     * @covers Pipeline\Import\Diff::getDiffedData
     */
    public function testGetDiffedDataReturnsEmptyArrayIfNotSet(): void
    {
        $this->assertArrayEmpty($this->class->getDiffedData());
    }

    /**
     * Test that getDiffedData() returns the base data.
     *
     * @covers Pipeline\Import\Diff::getDiffedData
     */
    public function testGetDiffedDataReturnsBaseData(): void
    {
        $this->setReflectionPropertyValue('diffedData', [[ 'value' => 'test' ]]);

        $this->assertEquals([[ 'value' => 'test' ]], $this->class->getDiffedData());
    }

}

?>
