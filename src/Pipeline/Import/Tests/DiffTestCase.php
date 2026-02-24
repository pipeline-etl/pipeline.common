<?php

/**
 * This file contains the test class for the Diff class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import\Tests;

use Lunr\Halo\LunrBaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Pipeline\Import\Diff;
use Pipeline\Import\ItemObserverInterface;

/**
 * Test class for the Diff class.
 *
 * @covers Pipeline\Import\Diff
 */
abstract class DiffTestCase extends LunrBaseTestCase
{

    /**
     * Mock instance of an item observer.
     * @var ItemObserverInterface&MockObject
     */
    protected ItemObserverInterface&MockObject $observer;

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
        $this->observer = $this->getMockBuilder(ItemObserverInterface::class)
                               ->getMock();

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
