<?php

/**
 * This file contains the ProfilerGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\Profiling\Tests;

/**
 * This class contains tests for the Profiler class.
 *
 * @covers Lunr\Ticks\Profiling\Profiler
 */
class ProfilerGetTest extends ProfilerTestCase
{

    /**
     * Test that getField() gets a field from the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::getField
     */
    public function testGetField(): void
    {
        $this->event->shouldReceive('getFields')
                    ->once()
                    ->andReturn([ 'foo' => 'bar' ]);

        $this->assertSame('bar', $this->class->getField('foo'));
    }

    /**
     * Test that getField() returns NULL if field doesn't exists.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::getField
     */
    public function testGetFieldReturnsNull(): void
    {
        $this->event->shouldReceive('getFields')
                    ->once()
                    ->andReturn([ 'foo' => 'bar' ]);

        $this->assertNull($this->class->getField('bar'));
    }

    /**
     * Test that getFields() gets fields from the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::getFields
     */
    public function testGetFields(): void
    {
        $this->event->shouldReceive('getFields')
                    ->once()
                    ->andReturn([ 'foo' => 'bar' ]);

        $this->assertSame([ 'foo' => 'bar' ], $this->class->getFields());
    }

    /**
     * Test that getTag() gets a tag from the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::getTag
     */
    public function testGetTag(): void
    {
        $this->event->shouldReceive('getTags')
                    ->once()
                    ->andReturn([ 'foo' => 'bar' ]);

        $this->assertSame('bar', $this->class->getTag('foo'));
    }

    /**
     * Test that getTag() returns NULL if tag doesn't exists.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::getTag
     */
    public function testGetTagReturnsNull(): void
    {
        $this->event->shouldReceive('getTags')
                    ->once()
                    ->andReturn([ 'foo' => 'bar' ]);

        $this->assertNull($this->class->getTag('bar'));
    }

    /**
     * Test that getTags() gets tags from the event.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::getTags
     */
    public function testGetTags(): void
    {
        $this->event->shouldReceive('getTags')
                    ->once()
                    ->andReturn([ 'foo' => 'bar' ]);

        $this->assertSame([ 'foo' => 'bar' ], $this->class->getTags());
    }

}

?>
