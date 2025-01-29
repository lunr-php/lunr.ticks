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
     * Test that set_trace_id() sets a trace ID on the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::set_trace_id
     */
    public function testSetTraceId(): void
    {
        $traceID = 'e0af2cd4-6a1c-4bd6-8fca-d3684e699784';

        $this->event->expects($this->once())
                    ->method('set_trace_id')
                    ->with($traceID);

        $this->class->set_trace_id($traceID);
    }

    /**
     * Test that set_span_id() sets a span ID on the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::set_span_id
     */
    public function testSetSpanId(): void
    {
        $spanID = '3f946299-16b5-44ee-8290-3f0fdbbbab1d';

        $this->event->expects($this->once())
                    ->method('add_fields')
                    ->with([ 'spanID' => $spanID ]);

        $this->class->set_span_id($spanID);
    }

    /**
     * Test that add_field() adds a field to the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::add_field
     */
    public function testAddField(): void
    {
        $this->event->expects($this->once())
                    ->method('add_fields')
                    ->with([ 'foo' => 'bar' ]);

        $this->class->add_field('foo', 'bar');
    }

    /**
     * Test that add_fields() adds fields to the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::add_fields
     */
    public function testAddFields(): void
    {
        $this->event->expects($this->once())
                    ->method('add_fields')
                    ->with([ 'foo' => 'bar' ]);

        $this->class->add_fields([ 'foo' => 'bar' ]);
    }

    /**
     * Test that add_tag() adds a tag to the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::add_tag
     */
    public function testAddTag(): void
    {
        $this->event->expects($this->once())
                    ->method('add_tags')
                    ->with([ 'foo' => 'bar' ]);

        $this->class->add_tag('foo', 'bar');
    }

    /**
     * Test that add_tags() adds tags to the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::add_tags
     */
    public function testAddTags(): void
    {
        $this->event->expects($this->once())
                    ->method('add_tags')
                    ->with([ 'foo' => 'bar' ]);

        $this->class->add_tags([ 'foo' => 'bar' ]);
    }

}

?>
