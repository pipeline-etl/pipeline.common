<?php

/**
 * This file contains the test class for the ItemObserver class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import\Tests;

use Lunr\Halo\LunrBaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Pipeline\Import\ImportTargetInterface;
use Pipeline\Import\ItemObserver;

/**
 * Test class for the ItemObserver class.
 *
 * @covers Pipeline\Import\ItemObserver
 */
abstract class ItemObserverTestCase extends LunrBaseTestCase
{

    /**
     * Mock instance of an import target.
     * @var ImportTargetInterface&MockObject
     */
    protected ImportTargetInterface&MockObject $importTarget;

    /**
     * Instance of the tested class.
     * @var ItemObserver
     */
    protected ItemObserver $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->importTarget = $this->getMockBuilder(ImportTargetInterface::class)
                                   ->getMock();

        $this->class = new ItemObserver($this->importTarget);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->class);
        unset($this->importTarget);
    }

}

?>
