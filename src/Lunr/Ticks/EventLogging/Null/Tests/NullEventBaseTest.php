<?php

/**
 * This file contains the NullEventBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\EventLogging\Null\Tests;

/**
 * This class contains tests for the EventLogger class.
 *
 * @covers Lunr\Ticks\EventLogging\Null\NullEvent
 */
class NullEventBaseTest extends NullEventTestCase
{

    /**
     * Test that the EventLogger class is passed correctly.
     */
    public function testEventLoggerIsPassedCorrectly(): void
    {
        $this->assertPropertySame('eventLogger', $this->eventLogger);
    }

    /**
     * Test that record() logs an event.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::record
     */
    public function testRecord(): void
    {
        $this->expectNotToPerformAssertions();

        $this->class->record();
    }

}

?>
