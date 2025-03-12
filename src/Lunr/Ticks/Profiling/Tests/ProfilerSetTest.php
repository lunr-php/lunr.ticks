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
