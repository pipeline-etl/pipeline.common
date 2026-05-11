<?php

/**
 * This file contains the Database Exception.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import\Exceptions;

use Exception;

/**
 * Class DatabaseException.
 */
class DatabaseException extends Exception
{

    /**
     * Set a more specific error message for the exception.
     *
     * @param string $message Error message
     *
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

}

?>
