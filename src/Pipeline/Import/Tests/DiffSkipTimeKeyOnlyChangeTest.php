<?php

/**
 * This file contains the test class for the Diff class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Pipeline\Import\Tests;

/**
 * Test class for the Diff class.
 *
 * @covers Pipeline\Import\Diff
 */
class DiffSkipTimeKeyOnlyChangeTest extends DiffTestCase
{

    /**
     * Test skipTimeKeyOnlyChange().
     *
     * @covers \Pipeline\Import\Diff::skipTimeKeyOnlyChange
     */
    public function testSkipTimeKeyOnlyChangeSetsPropertyFalse(): void
    {
        $this->assertPropertySame('skipTimeKeyOnlyChange', TRUE);

        $this->class->skipTimeKeyOnlyChange(value: FALSE);

        $this->assertPropertySame('skipTimeKeyOnlyChange', FALSE);
    }

    /**
     * Test skipTimeKeyOnlyChange().
     *
     * @covers \Pipeline\Import\Diff::skipTimeKeyOnlyChange
     */
    public function testSkipTimeKeyOnlyChangeSetsPropertyTrue(): void
    {
        $this->setReflectionPropertyValue('skipTimeKeyOnlyChange', FALSE);

        $this->class->skipTimeKeyOnlyChange(value: TRUE);

        $this->assertPropertySame('skipTimeKeyOnlyChange', TRUE);
    }

}

?>
