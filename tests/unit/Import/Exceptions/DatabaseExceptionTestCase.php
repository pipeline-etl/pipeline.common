<?php

/**
 * This file contains the test class for the DatabaseException class.
 *
 * SPDX-FileCopyrightText: Copyright 2026 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Import\Exceptions;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Pipeline\Import\Exceptions\DatabaseException;

/**
 * Test class for the DatabaseException class.
 *
 * @covers Pipeline\Import\Exceptions\DatabaseException
 */
abstract class DatabaseExceptionTestCase extends MockeryTestCase
{

    /**
     * Instance of the tested class.
     * @var DatabaseException
     */
    protected DatabaseException $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new DatabaseException('Original message');
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
