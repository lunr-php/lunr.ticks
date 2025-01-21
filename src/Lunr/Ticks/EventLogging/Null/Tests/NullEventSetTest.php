<?php

/**
 * This file contains the NullEventSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\EventLogging\Null\Tests;

use Lunr\Ticks\Precision;

/**
 * This class contains tests for the EventLogger class.
 *
 * @covers Lunr\Ticks\EventLogging\Null\NullEvent
 */
class NullEventSetTest extends NullEventTestCase
{

    /**
     * Unit test data provider for timestamps.
     *
     * @return array<string, array{0: Precision, 1: int|float}>
     */
    public function timestampProvider(): array
    {
        $data = [];

        $data['hours']        = [ Precision::Hours ];
        $data['minutes']      = [ Precision::Minutes ];
        $data['seconds']      = [ Precision::Seconds ];
        $data['milliseconds'] = [ Precision::MilliSeconds ];
        $data['microseconds'] = [ Precision::MicroSeconds ];
        $data['nanoseconds']  = [ Precision::NanoSeconds ];

        return $data;
    }

    /**
     * Test that setName() sets the measurement name.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::setName
     */
    public function testSetName(): void
    {
        $this->expectNotToPerformAssertions();

        $this->class->setName('event');
    }

    /**
     * Test that setTraceId() sets the Trace ID.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::setTraceId
     */
    public function testSetTraceId(): void
    {
        $this->expectNotToPerformAssertions();

        $this->class->setTraceId('4e122973-b870-471a-a00e-6a2778244738');
    }

    /**
     * Test that setSpanId() sets the Span ID.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::setSpanId
     */
    public function testSetSpanId(): void
    {
        $this->expectNotToPerformAssertions();

        $this->class->setSpanId('4e122973-b870-471a-a00e-6a2778244738');
    }

    /**
     * Test that setParentSpanId() sets the Span ID of the parent.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::setParentSpanId
     */
    public function testSetParentSpanId(): void
    {
        $this->expectNotToPerformAssertions();

        $this->class->setParentSpanId('4e122973-b870-471a-a00e-6a2778244738');
    }

    /**
     * Test that setUuidValue() sets a UUID value.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::setUuidValue
     */
    public function testSetUuidValue(): void
    {
        $this->expectNotToPerformAssertions();

        $this->class->setUuidValue('contentID', '4e122973-b870-471a-a00e-6a2778244738');
    }

    /**
     * Test that setTags() sets the event tags.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::setTags
     */
    public function testSetTags(): void
    {
        $this->expectNotToPerformAssertions();

        $tags = [ 'foo' => 'bar' ];

        $this->class->setTags($tags);
    }

    /**
     * Test that addTags() adds event tags.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::addTags
     */
    public function testAddTags(): void
    {
        $this->expectNotToPerformAssertions();

        $tags = [ 'foo' => 'bar' ];

        $this->class->addTags($tags);
    }

    /**
     * Test that setFields() sets the event fields.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::setFields
     */
    public function testSetFields(): void
    {
        $this->expectNotToPerformAssertions();

        $fields = [ 'foo' => 'bar' ];

        $this->class->setFields($fields);
    }

    /**
     * Test that addFields() adds event fields.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::addFields
     */
    public function testAddFields(): void
    {
        $this->expectNotToPerformAssertions();

        $fields = [ 'foo' => 'bar' ];

        $this->class->addFields($fields);
    }

    /**
     * Test that setTimestamp() sets the event time.
     *
     * @covers Lunr\Ticks\EventLogging\Null\NullEvent::setTimestamp
     */
    public function testSetTimestamp(): void
    {
        $this->expectNotToPerformAssertions();

        $this->class->setTimestamp(1730723729);
    }

    /**
     * Test that recordTimestamp() records the current time for the event.
     *
     * @param Precision $precision Event precision
     *
     * @dataProvider timestampProvider
     * @covers       Lunr\Ticks\EventLogging\Null\NullEvent::recordTimestamp
     */
    public function testRecordTimestamp(Precision $precision): void
    {
        $this->expectNotToPerformAssertions();

        $this->class->recordTimestamp($precision);
    }

}

?>
