<?php

/**
 * This file contains the NullEventGetTest class.
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
class NullEventGetTest extends NullEventTestCase
{

    /**
     * Test that getName() gets the measurement name.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::getName
     */
    public function testGetName(): void
    {
        $value = $this->class->getName();

        $this->assertSame('', $value);
    }

    /**
     * Test that getTraceId() gets the Trace ID.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::getTraceId
     */
    public function testGetTraceId(): void
    {
        $value = $this->class->getTraceId();

        $this->assertNull($value);
    }

    /**
     * Test that getSpanId() gets the Span ID.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::getSpanId
     */
    public function testGetSpanId(): void
    {
        $value = $this->class->getSpanId();

        $this->assertNull($value);
    }

    /**
     * Test that getParentSpanId() gets the Span ID of the parent.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::getParentSpanId
     */
    public function testGetParentSpanId(): void
    {
        $value = $this->class->getParentSpanId();

        $this->assertNull($value);
    }

    /**
     * Test that getTags() gets the event tags.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::getTags
     */
    public function testGetTags(): void
    {
        $value = $this->class->getTags();

        $this->assertArrayEmpty($value);
    }

    /**
     * Test that getFields() gets the event fields.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::getFields
     */
    public function testGetFields(): void
    {
        $value = $this->class->getFields();

        $this->assertArrayEmpty($value);
    }

    /**
     * Test that getTimestamp() gets the event timestamp.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::getTimestamp
     */
    public function testGetTimestamp(): void
    {
        $value = $this->class->getTimestamp();

        $this->assertSame(-1, $value);
    }

}

?>
