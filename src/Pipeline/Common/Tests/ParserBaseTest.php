<?php

/**
 * This file contains the ParserBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Common\Tests;

/**
 * This class contains tests for the Pipeline class.
 *
 * @covers Pipeline\Common\Parser
 */
class ParserBaseTest extends ParserTestCase
{

    /**
     * Test that the Pipeline class is set correctly.
     */
    public function testProfilerIsSetCorrectly(): void
    {
        $this->assertPropertySame('profiler', $this->profiler);
    }

}

?>
