<?php

/**
 * This file contains the NullEventTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\EventLogging\Null\Tests;

use Lunr\Halo\LunrBaseTestCase;
use Lunr\Ticks\EventLogging\Null\NullEvent;
use Lunr\Ticks\EventLogging\Null\NullEventLogger;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the NullEvent class.
 *
 * @covers Lunr\Ticks\Null\NullEventLogging\NullEvent
 */
abstract class NullEventTestCase extends LunrBaseTestCase
{

    /**
     * Mock instance of the NullEventLogger class.
     * @var NullEventLogger
     */
    protected NullEventLogger $eventLogger;

    /**
     * Instance of the tested class.
     * @var NullEvent
     */
    protected NullEvent $class;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->eventLogger = $this->getMockBuilder(NullEventLogger::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();

        $this->class = new NullEvent($this->eventLogger);

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->eventLogger);
        unset($this->class);
    }

}

?>
