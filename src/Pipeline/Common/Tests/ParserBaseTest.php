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

    /**
     * Test that reportStep() logs information.
     *
     * @covers \Pipeline\Common\Parser::reportStep
     */
    public function testReportStepLogsInformation(): void
    {
        $this->profiler->expects($this->once())
                       ->method('startNewSpan')
                       ->with('Log Message');

        $this->logger->expects($this->once())
                     ->method('notice')
                     ->with('Log Message');

        $method = $this->getReflectionMethod('reportStep');

        $method->invokeArgs($this->class, [ 'Log Message' ]);
    }

}

?>
