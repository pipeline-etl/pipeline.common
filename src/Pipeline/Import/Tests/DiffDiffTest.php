<?php

/**
 * This file contains the test class for the Diff class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import\Tests;

/**
 * Test class for the Diff class.
 *
 * @covers Pipeline\Import\Diff
 */
class DiffDiffTest extends DiffTestCase
{

    /**
     * Test that diff() handles new information correctly.
     *
     * @covers Pipeline\Import\Diff::diff
     */
    public function testDiffHandlesNewInformationCorrectly(): void
    {
        $new = [
            [ 'id' => 1, 'text' => 'Item 1' ],
            [ 'id' => 2, 'text' => 'Item 2' ],
        ];

        $old = [
            [ 'id' => 1, 'text' => 'Item 1' ],
        ];

        $update = [
            'new'      => [
                [ 'id' => 2, 'text' => 'Item 2' ],
            ],
            'updated'  => [],
            'same'     => [
                [ 'id' => 1, 'text' => 'Item 1' ],
            ],
            'skipped'  => [],
            'obsolete' => [],
        ];

        $this->observer->expects($this->exactly(3))
                       ->method('getItemIdentifier')
                       ->willReturnCallback(fn($item): string => (string) $item['id']);

        $this->observer->expects($this->never())
                       ->method('getTimeKeys');

        $this->class->diff($old, $new);

        $this->assertPropertyEquals('splitData', $update);
        $this->assertArrayEmpty($this->getReflectionPropertyValue('baseData'));
        $this->assertArrayEmpty($this->getReflectionPropertyValue('diffedData'));
    }

    /**
     * Test that diff() handles updated information correctly.
     *
     * @covers Pipeline\Import\Diff::diff
     */
    public function testDiffHandlesUpdatedInformationCorrectly(): void
    {
        $new = [
            [ 'id' => 1, 'text' => 'Item 1', 'revision' => 2 ],
        ];

        $old = [
            [ 'id' => 1, 'text' => 'Items 1', 'revision' => 1 ],
        ];

        $update = [
            'new'      => [],
            'updated'  => [
                [ 'id' => 1, 'text' => 'Item 1', 'revision' => 2 ],
            ],
            'same'     => [],
            'skipped'  => [],
            'obsolete' => [],
        ];

        $base = [
            1 => [ 'id' => 1, 'text' => 'Items 1', 'revision' => 1 ],
        ];

        $diffed = [
            '1' => [
                'text'     => 'Item 1',
                'revision' => 2,
            ],
        ];

        $this->observer->expects($this->exactly(2))
                       ->method('getItemIdentifier')
                       ->willReturnCallback(fn($item): string => (string) $item['id']);

        $this->observer->expects($this->exactly(2))
                       ->method('getTimeKeys')
                       ->willReturn([ 'revision' ]);

        $this->class->diff($old, $new);

        $this->assertPropertyEquals('splitData', $update);
        $this->assertPropertyEquals('baseData', $base);
        $this->assertPropertyEquals('diffedData', $diffed);
    }

    /**
     * Test that diff() returns the diffed information correctly.
     *
     * @covers Pipeline\Import\Diff::diff
     */
    public function testDiffReturnsDiffedInformationCorrectly(): void
    {
        $new = [
            [
                'id'       => 1,
                'revision' => 1,
                'columnA'  => 'String1',
                'columnB'  => 'String2',
                'columnC'  => 'String3',
            ],
        ];

        $old = [
            [
                'id'       => 1,
                'revision' => 1,
                'columnA'  => 'String0',
                'columnB'  => 'String0',
                'columnC'  => 'String3',
            ],
        ];

        $update = [
            'new'      => [],
            'updated'  => [
                [
                    'id'       => 1,
                    'revision' => 1,
                    'columnA'  => 'String1',
                    'columnB'  => 'String2',
                    'columnC'  => 'String3',
                ],
            ],
            'same'     => [],
            'skipped'  => [],
            'obsolete' => [],
        ];

        $base = [
            '1' => [
                'id'       => 1,
                'revision' => 1,
                'columnA'  => 'String0',
                'columnB'  => 'String0',
                'columnC'  => 'String3',
            ],
        ];

        $diffed = [
            '1' => [
                'columnA' => 'String1',
                'columnB' => 'String2',
            ],
        ];

        $this->observer->expects($this->exactly(2))
                       ->method('getItemIdentifier')
                       ->willReturnCallback(fn($item): string => (string) $item['id']);

        $this->observer->expects($this->exactly(2))
                       ->method('getTimeKeys')
                       ->willReturn([ 'revision' ]);

        $this->class->diff($old, $new);

        $this->assertPropertyEquals('splitData', $update);
        $this->assertPropertyEquals('baseData', $base);
        $this->assertPropertyEquals('diffedData', $diffed);
    }

    /**
     * Test diff() does not create a diff if only the type does not match.
     *
     * @return void
     */
    public function testDiffDoesNotTriggerOnTypeDifferences(): void
    {
        $new = [
            [
                'id'       => 1,
                'revision' => 1,
                'testbool' => TRUE,
                'testint'  => 2,
            ],
        ];

        $old = [
            [
                'id'       => 1,
                'revision' => 1,
                'testbool' => '1',
                'testint'  => '2',
            ],
        ];

        $update = [
            'new'      => [],
            'updated'  => [],
            'same'     => [
                '0' => [
                    'id'       => 1,
                    'revision' => 1,
                    'testbool' => TRUE,
                    'testint'  => 2,
                ],
            ],
            'skipped'  => [],
            'obsolete' => [],
        ];

        $this->observer->expects($this->exactly(2))
                       ->method('getItemIdentifier')
                       ->willReturnCallback(fn($item): string => (string) $item['id']);

        $this->observer->expects($this->never())
                       ->method('getTimeKeys');

        $this->class->diff($old, $new);

        $this->assertPropertyEquals('splitData', $update);
        $this->assertArrayEmpty($this->getReflectionPropertyValue('baseData'));
        $this->assertArrayEmpty($this->getReflectionPropertyValue('diffedData'));
    }

    /**
     * Test that diff() handles obsolete information correctly.
     *
     * @covers Pipeline\Import\Diff::diff
     */
    public function testDiffHandlesObsoleteInformationCorrectly(): void
    {
        $new = [
            [ 'id' => 1, 'text' => 'Item 1' ],
        ];

        $old = [
            [ 'id' => 1, 'text' => 'Item 1' ],
            [ 'id' => 2, 'text' => 'Item 2' ],
        ];

        $update = [
            'new'      => [],
            'updated'  => [],
            'same'     => [
                [ 'id' => 1, 'text' => 'Item 1' ],
            ],
            'skipped'  => [],
            'obsolete' => [
                [ 'id' => 2, 'text' => 'Item 2' ],
            ],
        ];

        $this->observer->expects($this->exactly(3))
                       ->method('getItemIdentifier')
                       ->willReturnCallback(fn($item): string => (string) $item['id']);

        $this->observer->expects($this->never())
                       ->method('getTimeKeys');

        $this->class->diff($old, $new);

        $this->assertPropertyEquals('splitData', $update);
        $this->assertArrayEmpty($this->getReflectionPropertyValue('baseData'));
        $this->assertArrayEmpty($this->getReflectionPropertyValue('diffedData'));
    }

    /**
     * Test that diff() handles skipped information correctly.
     *
     * @covers Pipeline\Import\Diff::diff
     */
    public function testDiffHandlesSkippedInformationCorrectly(): void
    {
        $new = [
            [ 'id' => 1, 'text' => 'Item 1', 'revision' => 1 ],
        ];

        $old = [
            [ 'id' => 1, 'text' => 'Items 1', 'revision' => 2 ],
        ];

        $update = [
            'new'      => [],
            'updated'  => [],
            'same'     => [],
            'skipped'  => [
                [ 'id' => 1, 'text' => 'Item 1', 'revision' => 1 ],
            ],
            'obsolete' => [],
        ];

        $this->observer->expects($this->exactly(2))
                       ->method('getItemIdentifier')
                       ->willReturnCallback(fn($item): string => (string) $item['id']);

        $this->observer->expects($this->once())
                       ->method('getTimeKeys')
                       ->willReturn([ 'revision' ]);

        $this->class->diff($old, $new);

        $this->assertPropertyEquals('splitData', $update);
        $this->assertArrayEmpty($this->getReflectionPropertyValue('baseData'));
        $this->assertArrayEmpty($this->getReflectionPropertyValue('diffedData'));
    }

    /**
     * Test that diff() handles time-key only changes correctly with skip_time_key_only_change flag set to TRUE
     *
     * @covers Pipeline\Import\Diff::diff
     */
    public function testDiffHandlesTimeKeyOnlyChangesCorrectlyWithSkipFlagTrue(): void
    {
        $new = [
            [ 'id' => 1, 'text' => 'Item 1', 'revision' => 2 ],
        ];

        $old = [
            [ 'id' => 1, 'text' => 'Item 1', 'revision' => 1 ],
        ];

        $update = [
            'new'      => [],
            'updated'  => [],
            'same'     => [],
            'skipped'  => [
                [ 'id' => 1, 'text' => 'Item 1', 'revision' => 2 ],
            ],
            'obsolete' => [],
        ];

        $this->observer->expects($this->exactly(2))
                       ->method('getItemIdentifier')
                       ->willReturnCallback(fn($item): string => (string) $item['id']);

        $this->observer->expects($this->exactly(2))
                       ->method('getTimeKeys')
                       ->willReturn([ 'revision' ]);

        $this->class->diff($old, $new);

        $this->assertPropertyEquals('splitData', $update);
        $this->assertArrayEmpty($this->getReflectionPropertyValue('baseData'));
        $this->assertArrayEmpty($this->getReflectionPropertyValue('diffedData'));
    }

    /**
     * Test that diff() handles time-key only changes correctly with skip_time_key_only_change flag set to FALSE
     *
     * @covers Pipeline\Import\Diff::diff
     */
    public function testDiffHandlesTimeKeyOnlyChangesCorrectlyWithSkipFlagFalse(): void
    {
        $new = [
            [ 'id' => 1, 'text' => 'Item 1', 'revision' => 2 ],
        ];

        $old = [
            [ 'id' => 1, 'text' => 'Item 1', 'revision' => 1 ],
        ];

        $update = [
            'new'      => [],
            'updated'  => [
                [ 'id' => 1, 'text' => 'Item 1', 'revision' => 2 ],
            ],
            'same'     => [],
            'skipped'  => [],
            'obsolete' => [],
        ];

        $base = [
            1 => [ 'id' => 1, 'text' => 'Item 1', 'revision' => 1 ],
        ];

        $diffed = [ '1' => [ 'revision' => 2 ] ];

        $this->observer->expects($this->exactly(2))
                       ->method('getItemIdentifier')
                       ->willReturnCallback(fn($item): string => (string) $item['id']);

        $this->observer->expects($this->once())
                       ->method('getTimeKeys')
                       ->willReturn([ 'revision' ]);

        $this->setReflectionPropertyValue('skipTimeKeyOnlyChange', FALSE);

        $this->class->diff($old, $new);

        $this->assertPropertyEquals('splitData', $update);
        $this->assertPropertyEquals('baseData', $base);
        $this->assertPropertyEquals('diffedData', $diffed);
    }

    /**
     * Test that diff() handles calls with empty old data correctly.
     *
     * @covers Pipeline\Import\Diff::diff
     */
    public function testDiffHandlesEmptyOldDataCorrectly(): void
    {
        $new = [
            [ 'id' => 1, 'text' => 'Item 1', 'revision' => 2 ],
        ];

        $old = [];

        $update = [
            'new'      => [
                [ 'id' => 1, 'text' => 'Item 1', 'revision' => 2 ],
            ],
            'updated'  => [],
            'same'     => [],
            'skipped'  => [],
            'obsolete' => [],
        ];

        $this->observer->expects($this->once())
                       ->method('getItemIdentifier')
                       ->willReturnCallback(fn($item): string => (string) $item['id']);

        $this->observer->expects($this->never())
                       ->method('getTimeKeys');

        $this->class->diff($old, $new);

        $this->assertPropertyEquals('splitData', $update);
        $this->assertArrayEmpty($this->getReflectionPropertyValue('baseData'));
        $this->assertArrayEmpty($this->getReflectionPropertyValue('diffedData'));
    }

}

?>
