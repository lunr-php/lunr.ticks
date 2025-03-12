<?php

/**
 * This file contains the ProfilerSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\Profiling\Tests;

/**
 * This class contains tests for the Profiler class.
 *
 * @covers Lunr\Ticks\Profiling\Profiler
 */
class ProfilerSetTest extends ProfilerTestCase
{

    /**
     * Test that setTraceId() sets a trace ID on the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::setTraceId
     */
    public function testSetTraceId(): void
    {
        $traceID = 'e0af2cd4-6a1c-4bd6-8fca-d3684e699784';

        $this->event->shouldReceive('setTraceId')
                    ->once()
                    ->with($traceID);

        $this->class->setTraceId($traceID);
    }

    /**
     * Test that setSpanId() sets a span ID on the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::setSpanId
     */
    public function testSetSpanId(): void
    {
        $spanID = '3f946299-16b5-44ee-8290-3f0fdbbbab1d';

        $this->event->shouldReceive('addFields')
                    ->once()
                    ->with([ 'spanID' => $spanID ]);

        $this->class->setSpanId($spanID);
    }

    /**
     * Test that addField() adds a field to the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::addField
     */
    public function testAddField(): void
    {
        $this->event->shouldReceive('addFields')
                    ->once()
                    ->with([ 'foo' => 'bar' ]);

        $this->class->addField('foo', 'bar');
    }

    /**
     * Test that addFields() adds fields to the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::addFields
     */
    public function testAddFields(): void
    {
        $this->event->shouldReceive('addFields')
                    ->once()
                    ->with([ 'foo' => 'bar' ]);

        $this->class->addFields([ 'foo' => 'bar' ]);
    }

    /**
     * Test that addTag() adds a tag to the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::addTag
     */
    public function testAddTag(): void
    {
        $this->event->shouldReceive('addTags')
                    ->once()
                    ->with([ 'foo' => 'bar' ]);

        $this->class->addTag('foo', 'bar');
    }

    /**
     * Test that addTags() adds tags to the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::addTags
     */
    public function testAddTags(): void
    {
        $this->event->shouldReceive('addTags')
                    ->once()
                    ->with([ 'foo' => 'bar' ]);

        $this->class->addTags([ 'foo' => 'bar' ]);
    }

}

?>
