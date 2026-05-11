<?php

/**
 * This file contains the test class for the DatabaseException class.
 *
 * SPDX-FileCopyrightText: Copyright 2026 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Tests\Import\Exceptions;

/**
 * Test class for the DatabaseException class.
 *
 * @covers Pipeline\Import\Exceptions\DatabaseException
 */
class DatabaseExceptionSetMessageTest extends DatabaseExceptionTestCase
{

    /**
     * Test that setMessage() updates the exception message.
     *
     * @covers Pipeline\Import\Exceptions\DatabaseException::setMessage
     */
    public function testSetMessageUpdatesMessage(): void
    {
        $this->class->setMessage('New message');

        $this->assertEquals('New message', $this->class->getMessage());
    }

    /**
     * Test that setMessage() overwrites a previously set message.
     *
     * @covers Pipeline\Import\Exceptions\DatabaseException::setMessage
     */
    public function testSetMessageOverwritesPreviousMessage(): void
    {
        $this->class->setMessage('First update');
        $this->class->setMessage('Second update');

        $this->assertEquals('Second update', $this->class->getMessage());
    }

    /**
     * Test that setMessage() can set an empty message.
     *
     * @covers Pipeline\Import\Exceptions\DatabaseException::setMessage
     */
    public function testSetMessageWithEmptyString(): void
    {
        $this->class->setMessage('');

        $this->assertEquals('', $this->class->getMessage());
    }

}

?>
