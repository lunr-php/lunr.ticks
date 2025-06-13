<?php

/**
 * This file contains the ProfilerSpanTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\Profiling\Tests;

use RuntimeException;

/**
 * This class contains tests for the Profiler class.
 *
 * @covers Lunr\Ticks\Profiling\Profiler
 */
class ProfilerSpanTest extends ProfilerTestCase
{

    /**
     * Test finalizePreviousSpan() with no previous span.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::finalizePreviousSpan
     */
    public function testFinalizePreviousSpanWithNoPreviousSpan(): void
    {
        $method = $this->getReflectionMethod('finalizePreviousSpan');

        $method->invokeArgs($this->class, [ 1734352683.4537 ]);

        $this->assertArrayEmpty($this->getReflectionPropertyValue('spans'));
    }

    /**
     * Test finalizePreviousSpan() with a previous span.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::finalizePreviousSpan
     */
    public function testFinalizePreviousSpanWithPreviousSpan(): void
    {
        $spanID = '8d1a5341-16f9-4608-bf51-db198e52575c';

        $base = [
            'name'           => 'UnitTestRun',
            'spanID'         => $spanID,
            'startTimestamp' => $this->startTimestamp,
            'memory'         => 526160,
            'memoryPeak'     => 561488,
            'executionTime'  => 0,
        ];

        $this->setReflectionPropertyValue('spans', [ $base ]);

        $this->controller->shouldReceive('stopChildSpan')
                         ->once();

        $method = $this->getReflectionMethod('finalizePreviousSpan');

        $method->invokeArgs($this->class, [ 1734352683.4537 ]);

        $expected = [
            'name'           => 'UnitTestRun',
            'spanID'         => $spanID,
            'startTimestamp' => $this->startTimestamp,
            'memory'         => 526160,
            'memoryPeak'     => 561488,
            'executionTime'  => 0.1021,
        ];

        $this->assertSame($this->getReflectionPropertyValue('spans'), [ $expected ]);
    }

    /**
     * Test startNewSpan() throws an exception if the Span ID is not available.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::startNewSpan
     */
    public function testStartNewSpanThrowsExceptionIfSpanIDNotAvailable(): void
    {
        $this->controller->shouldReceive('getSpanId')
                         ->once()
                         ->andReturn(NULL);

        $this->controller->shouldReceive('startChildSpan')
                         ->once();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Span ID not available!');

        $this->class->startNewSpan('Unit test run');
    }

    /**
     * Test startNewSpan() with no previous span.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::startNewSpan
     */
    public function testStartNewSpanWithNoPreviousSpan(): void
    {
        $floatval  = 1734352683.3526;
        $stringval = '0.35260200 1734352683';

        $this->mockFunction('microtime', fn(bool $float) => $float ? $floatval : $stringval);
        $this->mockFunction('memory_get_usage', fn() => 526160);
        $this->mockFunction('memory_get_peak_usage', fn() => 561488);

        $spanID = '8d1a5341-16f9-4608-bf51-db198e52575c';

        $this->controller->shouldReceive('getSpanId')
                         ->once()
                         ->andReturn($spanID);

        $this->controller->shouldReceive('startChildSpan')
                         ->once();

        $this->class->startNewSpan('Unit test run');

        $expected = [
            'name'           => 'UnitTestRun',
            'spanID'         => $spanID,
            'startTimestamp' => $floatval,
            'memory'         => 526160,
            'memoryPeak'     => 561488,
            'executionTime'  => 0,
        ];

        $this->assertSame($this->getReflectionPropertyValue('spans'), [ $expected ]);

        $this->unmockFunction('memory_get_usage');
        $this->unmockFunction('memory_get_peak_usage');
        $this->unmockFunction('microtime');
    }

    /**
     * Test startNewSpan() with a previous span.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::startNewSpan
     */
    public function testStartNewSpanWithPreviousSpan(): void
    {
        $floatval  = 1734352683.3526;
        $stringval = '0.35260200 1734352683';

        $this->mockFunction('microtime', fn(bool $float) => $float ? $floatval : $stringval);
        $this->mockFunction('memory_get_usage', fn() => 526160);
        $this->mockFunction('memory_get_peak_usage', fn() => 561488);

        $spanID  = '8d1a5341-16f9-4608-bf51-db198e52575c';
        $spanID2 = '9da74534-21d6-4a75-b58e-d27273a35330';

        $this->controller->shouldReceive('getSpanId')
                         ->once()
                         ->andReturn($spanID2);

        $this->controller->shouldReceive('stopChildSpan')
                         ->once();

        $this->controller->shouldReceive('startChildSpan')
                         ->once();

        $base = [
            'name'           => 'UnitTestRun',
            'spanID'         => $spanID,
            'startTimestamp' => $this->startTimestamp,
            'memory'         => 526161,
            'memoryPeak'     => 561489,
            'executionTime'  => 0,
        ];

        $this->setReflectionPropertyValue('spans', [ $base ]);

        $this->class->startNewSpan('Unit test run 2');

        $expected = [
            [
                'name'           => 'UnitTestRun',
                'spanID'         => $spanID,
                'startTimestamp' => $this->startTimestamp,
                'memory'         => 526161,
                'memoryPeak'     => 561489,
                'executionTime'  => 0.001,
            ],
            [
                'name'           => 'UnitTestRun2',
                'spanID'         => $spanID2,
                'startTimestamp' => $floatval,
                'memory'         => 526160,
                'memoryPeak'     => 561488,
                'executionTime'  => 0,
            ]
        ];

        $this->assertSame($this->getReflectionPropertyValue('spans'), $expected);

        $this->unmockFunction('memory_get_usage');
        $this->unmockFunction('memory_get_peak_usage');
        $this->unmockFunction('microtime');
    }

}

?>
