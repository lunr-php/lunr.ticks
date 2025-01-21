<?php

/**
 * This file contains the NullEventLoggerTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\EventLogging\Null\Tests;

use Lunr\Halo\LunrBaseTestCase;
use Lunr\Ticks\EventLogging\Null\NullEventLogger;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the EventLogger class.
 *
 * @covers Lunr\Ticks\EventLogging\Null\NullEventLogger
 */
abstract class NullEventLoggerTestCase extends LunrBaseTestCase
{

    /**
     * Instance of the tested class.
     * @var NullEventLogger
     */
    protected NullEventLogger $class;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->class = new NullEventLogger();

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->class);
    }

}

?>
