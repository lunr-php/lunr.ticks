<?php

/**
 * This file contains the ProfilerBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\Profiling\Tests;

use Lunr\Ticks\Profiling\Profiler;

/**
 * This class contains tests for the Profiler class.
 *
 * @covers Lunr\Ticks\Profiling\Profiler
 */
class ProfilerBaseTest extends ProfilerTestCase
{

    /**
     * Test that the Event class is passed correctly.
     */
    public function testEventIsPassedCorrectly(): void
    {
        $this->assertPropertySame('event', $this->event);
    }

    /**
     * Test that the Controller class is passed correctly.
     */
    public function testControllerIsPassedCorrectly(): void
    {
        $this->assertPropertySame('controller', $this->controller);
    }

    /**
     * Test that the fields array is initialized empty.
     */
    public function testFieldsIsInitializedEmpty(): void
    {
        $this->assertArrayEmpty($this->getReflectionPropertyValue('fields'));
    }

    /**
     * Test that the tags array is initialized empty.
     */
    public function testTagsIsInitializedEmpty(): void
    {
        $this->assertArrayEmpty($this->getReflectionPropertyValue('tags'));
    }

    /**
     * Test that the spans array is initialized empty.
     */
    public function testSpansIsInitializedEmpty(): void
    {
        $this->assertArrayEmpty($this->getReflectionPropertyValue('spans'));
    }

    /**
     * Test that the start timestamp is set.
     */
    public function testStartTimestampIsSet(): void
    {
        $this->assertPropertySame('startTimestamp', $this->startTimestamp);
    }

    /**
     * Test that the profiler accepts a custom startTimestamp value.
     */
    public function testProfilerAcceptsCustomStartTimestamp(): void
    {
        $this->controller->shouldReceive('stopChildSpan')
                         ->zeroOrMoreTimes();

        $this->controller->shouldReceive('getTraceId')
                         ->once()
                         ->andReturn('e0af2cd4-6a1c-4bd6-8fca-d3684e699784');

        $this->controller->shouldReceive('getSpanId')
                         ->once()
                         ->andReturn('3f946299-16b5-44ee-8290-3f0fdbbbab1d');

        $this->event->shouldReceive('setTraceId')
                    ->once()
                    ->with('e0af2cd4-6a1c-4bd6-8fca-d3684e699784');

        $this->event->shouldReceive('addFields')
                    ->once();

        $this->event->shouldReceive('addTags')
                    ->once();

        $this->event->shouldReceive('setUuidValue')
                    ->zeroOrMoreTimes();

        $this->event->shouldReceive('recordTimestamp')
                    ->once();

        $this->event->shouldReceive('record')
                    ->once();

        $timestamp = 12345678.9;

        $class = new Profiler($this->event, $this->controller, $timestamp);

        $value = $this->reflection->getProperty('startTimestamp')->getValue($class);

        $this->assertSame($value, $timestamp);
    }

}

?>
