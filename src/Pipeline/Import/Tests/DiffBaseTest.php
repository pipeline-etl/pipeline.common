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
class DiffBaseTest extends DiffTestCase
{

    /**
     * Test that the item observer is passed correctly.
     */
    public function testItemObserverIsPassedCorrectly(): void
    {
        $this->assertPropertySame('observer', $this->observer);
    }

    /**
     * Test that the categorized data array is initialized correctly.
     */
    public function testSplitDataIsInitializedCorrectly(): void
    {
        $value = $this->getReflectionPropertyValue('splitData');

        $this->assertArrayHasKey(DataDiffCategory::New->value, $value);
        $this->assertArrayEmpty($value[DataDiffCategory::New->value]);
        $this->assertArrayHasKey(DataDiffCategory::Updated->value, $value);
        $this->assertArrayEmpty($value[DataDiffCategory::Updated->value]);
        $this->assertArrayHasKey(DataDiffCategory::Obsolete->value, $value);
        $this->assertArrayEmpty($value[DataDiffCategory::Obsolete->value]);
        $this->assertArrayHasKey(DataDiffCategory::Same->value, $value);
        $this->assertArrayEmpty($value[DataDiffCategory::Same->value]);
        $this->assertArrayHasKey(DataDiffCategory::Skipped->value, $value);
        $this->assertArrayEmpty($value[DataDiffCategory::Skipped->value]);
    }

    /**
     * Test that the base data array is initialized as an empty array.
     */
    public function testBaseDataIsInitializedAsEmptyArray(): void
    {
        $this->assertArrayEmpty($this->getReflectionPropertyValue('baseData'));
    }

    /**
     * Test that the diffed data array is initialized as an empty array.
     */
    public function testDiffedDataIsInitializedAsEmptyArray(): void
    {
        $this->assertArrayEmpty($this->getReflectionPropertyValue('diffedData'));
    }

    /**
     * Test that skipTimeKeyOnlyChange is initialized as 'true'.
     */
    public function testSkipTimeKeyOnlyChangeIsInitializedAsTrue(): void
    {
        $this->assertTrue($this->getReflectionPropertyValue('skipTimeKeyOnlyChange'));
    }

}

?>
