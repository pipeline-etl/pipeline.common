<?php

/**
 * This file contains the test class for the ImportInfo class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import\Tests;

use Pipeline\Common\Exceptions\InvalidConfigurationException;
use Pipeline\Import\Flag;

/**
 * Test class for the ImportInfo class.
 *
 * @covers Pipeline\Import\ImportInfo
 */
class ImportInfoPopulateTest extends ImportInfoTestCase
{

    /**
     * Test populate() with a minimal config.
     *
     * @covers Pipeline\Import\ImportInfo::populate
     */
    public function testPopulateWithMinimalConfig(): void
    {
        $this->class->setPipelineIdentifier('foobar');

        $info = [];

        $this->profiler->expects($this->once())
                       ->method('addTag')
                       ->with('contentType', 'foobar');

        $this->class->populate($info);

        $this->assertPropertyEquals('target', 'foobar');
        $this->assertPropertyEquals('contentType', 'foobar');
        $this->assertPropertySame('hooks', []);
        $this->assertPropertySame('ranges', []);
        $this->assertPropertySame('flags', []);
    }

    /**
     * Test populate() with a full config.
     *
     * @covers Pipeline\Import\ImportInfo::populate
     */
    public function testPopulateWithFullConfig(): void
    {
        $this->class->setPipelineIdentifier('foobar');

        $info = [
            'target'        => 'table',
            'content_type'  => 'baz',
            'hooks'         => [
                [
                    'notification' => [
                        'language' => 'en-US',
                    ],
                ],
            ],
            'content_range' => [
                [
                    'value' => [
                        'key' => 'value',
                    ],
                ],
            ],
            'flags'         => [
                'abort_on_empty_data',
            ]
        ];

        $this->profiler->expects($this->once())
                       ->method('addTag')
                       ->with('contentType', 'baz');

        $this->class->populate($info);

        $this->assertPropertyEquals('target', 'table');
        $this->assertPropertyEquals('contentType', 'baz');
        $this->assertPropertySame('hooks', $info['hooks']);
        $this->assertPropertySame('ranges', $info['content_range']);
        $this->assertPropertySame('flags', [ Flag::AbortOnEmptyData ]);
    }

    /**
     * Test populate() with an invalid flag.
     *
     * @covers Pipeline\Import\ImportInfo::populate
     */
    public function testPopulateThrowsExceptionForInvalidFlags(): void
    {
        $this->class->setPipelineIdentifier('foobar');

        $info = [
            'flags' => [
                'skip_empty',
            ],
        ];

        $this->profiler->expects($this->once())
                       ->method('addTag')
                       ->with('contentType', 'foobar');

        $this->expectException(InvalidConfigurationException::class);
        $this->expectExceptionMessage('Invalid import flag!');

        $this->class->populate($info);
    }

}

?>
