<?php

/**
 * This file contains the test class for the Diff class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Import;

use Lunr\Halo\LunrBaseTestCase;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Pipeline\Import\Diff;
use Pipeline\Import\ItemObserverInterface;

/**
 * Test class for the Diff class.
 *
 * @covers Pipeline\Import\Diff
 */
abstract class DiffTestCase extends LunrBaseTestCase
{

    use MockeryPHPUnitIntegration;

    /**
     * Mock instance of an item observer.
     * @var ItemObserverInterface&MockInterface
     */
    protected ItemObserverInterface&MockInterface $observer;

    /**
     * Instance of the tested class.
     * @var Diff
     */
    protected Diff $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->observer = Mockery::mock(ItemObserverInterface::class);

        $this->class = new Diff($this->observer);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->class);
        unset($this->observer);
    }

}

?>
