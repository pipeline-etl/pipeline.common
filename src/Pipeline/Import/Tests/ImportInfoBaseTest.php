<?php

/**
 * This file contains the test class for the ImportInfo class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import\Tests;

use Pipeline\Import\DataDiffCategory;
use Pipeline\Import\Flag;

/**
 * Test class for the ImportInfo class.
 *
 * @covers Pipeline\Import\ImportInfo
 */
class ImportInfoBaseTest extends ImportInfoTestCase
{

    /**
     * Unit test data provider for data categories.
     *
     * @return array<string, DataDiffCategory[]>
     */
    public static function dataDiffCategoryProvider(): array
    {
        $data             = [];
        $data['new']      = [ DataDiffCategory::New ];
        $data['obsolete'] = [ DataDiffCategory::Obsolete ];
        $data['same']     = [ DataDiffCategory::Same ];
        $data['skipped']  = [ DataDiffCategory::Skipped ];
        $data['total']    = [ DataDiffCategory::Total ];
        $data['updated']  = [ DataDiffCategory::Updated ];

        return $data;
    }

    /**
     * Test getInfoIdentifier().
     *
     * @covers Pipeline\Import\ImportInfo::getInfoIdentifier
     */
    public function testGetInfoIdentifier(): void
    {
        $this->assertEquals('import_info', $this->class->getInfoIdentifier());
    }

    /**
     * Test getTargetIdentifier().
     *
     * @covers Pipeline\Import\ImportInfo::getTargetIdentifier
     */
    public function testGetTargetIdentifier(): void
    {
        $target = 'table';

        $this->setReflectionPropertyValue('target', $target);

        $this->assertEquals($target, $this->class->getTargetIdentifier());
    }

    /**
     * Test getContentTypeIdentifier().
     *
     * @covers Pipeline\Import\ImportInfo::getContentTypeIdentifier
     */
    public function testGetContentTypeIdentifier(): void
    {
        $contentType = 'content';

        $this->setReflectionPropertyValue('contentType', $contentType);

        $this->assertEquals($contentType, $this->class->getContentTypeIdentifier());
    }

    /**
     * Test getHooks().
     *
     * @covers Pipeline\Import\ImportInfo::getHooks
     */
    public function testGetHooks(): void
    {
        $hooks = [
            [
                'foo' => [
                    'settings' => 'none'
                ]
            ],
        ];

        $this->setReflectionPropertyValue('hooks', $hooks);

        $this->assertEquals($hooks, $this->class->getHooks());
    }

    /**
     * Test getContentRanges().
     *
     * @covers Pipeline\Import\ImportInfo::getContentRanges
     */
    public function testGetContentRanges(): void
    {
        $ranges = [
            [
                'foo' => [
                    'key' => 'value'
                ]
            ],
        ];

        $this->setReflectionPropertyValue('ranges', $ranges);

        $this->assertEquals($ranges, $this->class->getContentRanges());
    }

    /**
     * Test setResults().
     *
     * @covers Pipeline\Import\ImportInfo::setResults
     */
    public function testSetResults(): void
    {
        $results = [
            DataDiffCategory::New->value      => 1,
            DataDiffCategory::Obsolete->value => 2,
            DataDiffCategory::Updated->value  => 3,
            DataDiffCategory::Skipped->value  => 4,
            DataDiffCategory::Same->value     => 5,
            DataDiffCategory::Total->value    => 13,
        ];

        $this->profiler->expects($this->once())
                       ->method('addFields')
                       ->with($results);

        $this->class->setResults(1, 2, 3, 4, 5);

        $this->assertPropertyEquals('results', $results);
    }

    /**
     * Test getResult().
     *
     * @param DataDiffCategory $category Data category to fetch results for
     *
     * @dataProvider dataDiffCategoryProvider
     * @covers       Pipeline\Import\ImportInfo::getResult
     */
    public function testGetResult(DataDiffCategory $category): void
    {
        $results = [
            DataDiffCategory::New->value      => 1,
            DataDiffCategory::Obsolete->value => 2,
            DataDiffCategory::Updated->value  => 3,
            DataDiffCategory::Skipped->value  => 4,
            DataDiffCategory::Same->value     => 5,
            DataDiffCategory::Total->value    => 15,
        ];

        $this->setReflectionPropertyValue('results', $results);

        $this->assertSame($results[$category->value], $this->class->getResult($category));
    }

    /**
     * Test getResult().
     *
     * @param DataDiffCategory $category Data category to fetch results for
     *
     * @dataProvider dataDiffCategoryProvider
     * @covers       Pipeline\Import\ImportInfo::getResult
     */
    public function testGetResultWhenUnset(DataDiffCategory $category): void
    {
        $this->assertSame(0, $this->class->getResult($category));
    }

    /**
     * Test that hasFlag() returns TRUE for set flags.
     *
     * @covers Pipeline\Import\ImportInfo::hasFlag
     */
    public function testHasFlagReturnsTrueForSetFlag(): void
    {
        $this->setReflectionPropertyValue('flags', [ Flag::AbortOnEmptyData ]);

        $this->assertTrue($this->class->hasFlag(Flag::AbortOnEmptyData));
    }

    /**
     * Test that hasFlag() returns FALSE for not set flags.
     *
     * @covers Pipeline\Import\ImportInfo::hasFlag
     */
    public function testHasFlagReturnsFalseForNotSetFlag(): void
    {
        $this->setReflectionPropertyValue('flags', [ Flag::AbortOnEmptyData ]);

        $this->assertFalse($this->class->hasFlag(Flag::IgnoreTimeKeyOnlyChange));
    }

}

?>
