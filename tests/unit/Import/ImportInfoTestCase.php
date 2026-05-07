<?php

/**
 * This file contains the test class for the ImportInfo class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Import;

use Lunr\Halo\LunrBaseTestCase;
use Lunr\Ticks\Profiling\Profiler;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Pipeline\Import\ImportInfo;

/**
 * Test class for the basic ImportInfo class.
 *
 * @covers Pipeline\Import\ImportInfo
 */
abstract class ImportInfoTestCase extends LunrBaseTestCase
{

    use MockeryPHPUnitIntegration;

    /**
     * Mock instance of the Profiler.
     * @var Profiler&MockInterface
     */
    protected Profiler&MockInterface $profiler;

    /**
     * Instance of the tested class.
     * @var ImportInfo
     */
    protected ImportInfo $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->profiler = Mockery::mock(Profiler::class);

        $this->class = new ImportInfo($this->profiler);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->class);
    }

}

?>
