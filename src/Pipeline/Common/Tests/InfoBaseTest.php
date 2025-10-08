<?php

/**
 * This file contains the test class for the basic Info class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests;

/**
 * Test class for the basic Info class.
 *
 * @covers Pipeline\Common\Info
 */
class InfoBaseTest extends InfoTestCase
{

    /**
     * Test profiler is set correctly.
     */
    public function testProfilerIsSet(): void
    {
        $this->assertPropertySame('profiler', $this->profiler);
    }

    /**
     * Test setPipelineIdentifier().
     *
     * @covers Pipeline\Common\Info::setPipelineIdentifier
     */
    public function testSetPipelineIdentifier(): void
    {
        $identifier = 'foo-content';

        $this->profiler->expects($this->once())
                       ->method('addTag')
                       ->with('pipeline', $identifier);

        $this->class->setPipelineIdentifier($identifier);

        $this->assertPropertyEquals('identifier', $identifier);
    }

    /**
     * Test getPipelineIdentifier().
     *
     * @covers Pipeline\Common\Info::getPipelineIdentifier
     */
    public function testGetPipelineIdentifier(): void
    {
        $identifier = 'foo-content';

        $this->setReflectionPropertyValue('identifier', $identifier);

        $this->assertEquals($identifier, $this->class->getPipelineIdentifier());
    }

    /**
     * Test getProfiler().
     *
     * @covers Pipeline\Common\Info::getProfiler
     */
    public function testGetProfiler(): void
    {
        $this->assertSame($this->profiler, $this->class->getProfiler());
    }

    /**
     * Test getInfoIdentifier().
     *
     * @covers Pipeline\Common\Info::getInfoIdentifier
     */
    public function testGetInfoIdentifier(): void
    {
        $this->assertEquals('info', $this->class->getInfoIdentifier());
    }

    /**
     * Test populate().
     *
     * @covers Pipeline\Common\Info::populate
     */
    public function testPopulateDoesNothing(): void
    {
        $this->assertNull($this->class->populate([]));
    }

}

?>
