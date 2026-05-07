<?php

/**
 * This file contains the test class for the ItemObserver class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Import;

use Lunr\Halo\LunrBaseTestCase;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Pipeline\Import\ImportTargetInterface;
use Pipeline\Import\ItemObserver;

/**
 * Test class for the ItemObserver class.
 *
 * @covers Pipeline\Import\ItemObserver
 */
abstract class ItemObserverTestCase extends LunrBaseTestCase
{

    use MockeryPHPUnitIntegration;

    /**
     * Mock instance of an import target.
     * @var ImportTargetInterface&MockInterface
     */
    protected ImportTargetInterface&MockInterface $importTarget;

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
        $this->importTarget = Mockery::mock(ImportTargetInterface::class);

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
