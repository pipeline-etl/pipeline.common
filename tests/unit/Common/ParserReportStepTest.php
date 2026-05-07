<?php

/**
 * This file contains the ParserReportStepTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Common;

/**
 * This class contains tests for the Pipeline class.
 *
 * @covers Pipeline\Common\Parser
 */
class ParserReportStepTest extends ParserTestCase
{

    /**
     * Test that reportStep() logs information.
     *
     * @covers \Pipeline\Common\Parser::reportStep
     */
    public function testReportStepLogsInformation(): void
    {
        $this->profiler->shouldReceive('startNewSpan')
                       ->once()
                       ->with('Log Message');

        $this->logger->shouldReceive('notice')
                     ->once()
                     ->with('Log Message');

        $method = $this->getReflectionMethod('reportStep');

        $method->invokeArgs($this->class, [ 'Log Message' ]);
    }

}

?>
