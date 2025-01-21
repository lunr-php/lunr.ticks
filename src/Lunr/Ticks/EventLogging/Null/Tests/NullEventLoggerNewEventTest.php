<?php

/**
 * This file contains the NullEventLoggerNewEventTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\EventLogging\Null\Tests;

use Lunr\Ticks\EventLogging\Null\NullEvent;
use ReflectionClass;

/**
 * This class contains tests for the NullEventLogger class.
 *
 * @covers Lunr\Ticks\EventLogging\Null\NullEventLogger
 */
class NullEventLoggerNewEventTest extends NullEventLoggerTestCase
{

    /**
     * Test that newEvent() returns an Event instance.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEventLogger::newEvent
     */
    public function testNewEvent(): void
    {
        $event = $this->class->newEvent('event');

        $this->assertInstanceOf(NullEvent::class, $event);

        $event_reflection = new ReflectionClass(NullEvent::class);

        $eventLogger = $event_reflection->getProperty('eventLogger')
                                        ->getValue($event);

        $this->assertSame($this->class, $eventLogger);
    }

}

?>
