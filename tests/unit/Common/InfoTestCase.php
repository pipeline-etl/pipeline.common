<?php

/**
 * This file contains the test class for the basic Info class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Common;

use Lunr\Halo\LunrBaseTestCase;
use Lunr\Ticks\Profiling\Profiler;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Pipeline\Common\Info;

/**
 * Test class for the basic Info class.
 *
 * @covers Pipeline\Common\Info
 */
abstract class InfoTestCase extends LunrBaseTestCase
{

    use MockeryPHPUnitIntegration;

    /**
     * Instance of the Profiler.
     * @var Profiler&MockInterface
     */
    protected Profiler&MockInterface $profiler;

    /**
     * Instance of the tested class.
     * @var Info
     */
    protected Info $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->profiler = Mockery::mock(Profiler::class);

        $this->class = new Info($this->profiler);

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
