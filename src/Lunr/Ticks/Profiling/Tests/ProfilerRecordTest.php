<?php

/**
 * This file contains the ProfilerRecordTest class.
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
class ProfilerRecordTest extends ProfilerTestCase
{

    /**
     * Test record() throws an exception if the Span ID is not available.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::record
     */
    public function testRecordThrowsExceptionIfSpanIdNotAvailable(): void
    {
        $this->controller->shouldReceive('getSpanId')
                         ->once()
                         ->andReturn(NULL);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Span ID not available!');

        $method = $this->getReflectionMethod('record');

        $method->invoke($this->class);
    }

    /**
     * Test record() throws an exception if the Trace ID is not available.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::record
     */
    public function testRecordThrowsExceptionIfTraceIdNotAvailable(): void
    {
        $this->controller->shouldReceive('getTraceId')
                         ->once()
                         ->andReturn(NULL);

        $this->controller->shouldReceive('getSpanId')
                         ->once()
                         ->andReturn('3f946299-16b5-44ee-8290-3f0fdbbbab1d');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Trace ID not available!');

        $method = $this->getReflectionMethod('record');

        $method->invoke($this->class);
    }

    /**
     * Test record() with no spans.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::record
     */
    public function testRecordWithoutSpans(): void
    {
        $floatval  = 1734352684.6526;
        $stringval = '0.65260200 1734352684';

        $this->mockFunction('microtime', fn(bool $float) => $float ? $floatval : $stringval);
        $this->mockFunction('memory_get_usage', fn() => 526160);
        $this->mockFunction('memory_get_peak_usage', fn() => 561488);

        $this->controller->shouldReceive('getTraceId')
                         ->once()
                         ->andReturn('e0af2cd4-6a1c-4bd6-8fca-d3684e699784');

        $this->controller->shouldReceive('getSpanId')
                         ->once()
                         ->andReturn('3f946299-16b5-44ee-8290-3f0fdbbbab1d');

        $this->event->shouldReceive('setTraceId')
                    ->once()
                    ->with('e0af2cd4-6a1c-4bd6-8fca-d3684e699784');

        $fields = [
            'startTimestamp' => 1734352683.3516,
            'endTimestamp'   => 1734352684.6526,
            'totalRunTime'   => 1.3010,
            'memory'         => 526160,
            'memoryPeak'     => 561488,
            'spanID'         => '3f946299-16b5-44ee-8290-3f0fdbbbab1d',
        ];

        $this->event->shouldReceive('addFields')
                    ->once()
                    ->with($fields);

        $this->event->shouldReceive('addTags')
                    ->once()
                    ->with([]);

        $this->event->shouldReceive('recordTimestamp')
                    ->once();

        $this->event->shouldReceive('record')
                    ->once();

        $method = $this->getReflectionMethod('record');

        $method->invoke($this->class);

        $this->unmockFunction('memory_get_usage');
        $this->unmockFunction('memory_get_peak_usage');
        $this->unmockFunction('microtime');
    }

    /**
     * Test record() with one span.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::record
     */
    public function testRecordWithOneSpan(): void
    {
        $floatval  = 1734352684.6526;
        $stringval = '0.65260200 1734352684';

        $this->mockFunction('microtime', fn(bool $float) => $float ? $floatval : $stringval);
        $this->mockFunction('memory_get_usage', fn() => 526160);
        $this->mockFunction('memory_get_peak_usage', fn() => 561488);

        $spanID  = '3f946299-16b5-44ee-8290-3f0fdbbbab1d';
        $spanID1 = '8d1a5341-16f9-4608-bf51-db198e52575c';

        $base = [
            'name'           => 'UnitTestRun',
            'spanID'         => $spanID1,
            'startTimestamp' => $this->startTimestamp,
            'memory'         => 526161,
            'memoryPeak'     => 561489,
            'runTime'        => 0,
        ];

        $this->setReflectionPropertyValue('spans', [ $base ]);
        $this->setReflectionPropertyValue('fields', [ 'baz' => 2.0 ]);
        $this->setReflectionPropertyValue('tags', [ 'foo' => 'bar' ]);

        $this->controller->shouldReceive('getTraceId')
                         ->once()
                         ->andReturn('e0af2cd4-6a1c-4bd6-8fca-d3684e699784');

        $this->controller->shouldReceive('getSpanId')
                         ->once()
                         ->andReturn($spanID);

        $this->controller->shouldReceive('stopChildSpan')
                         ->once();

        $this->event->shouldReceive('setTraceId')
                    ->once()
                    ->with('e0af2cd4-6a1c-4bd6-8fca-d3684e699784');

        $fields = [
            'baz'                       => 2.0,
            'startTimestamp'            => 1734352683.3516,
            'endTimestamp'              => 1734352684.6526,
            'totalRunTime'              => 1.3010,
            'memory'                    => 526160,
            'memoryPeak'                => 561488,
            'spanID'                    => $spanID,
            'startTimestampUnitTestRun' => 1734352683.3516,
            'memoryUnitTestRun'         => 526161,
            'memoryPeakUnitTestRun'     => 561489,
            'runTimeUnitTestRun'        => 1.301,
        ];

        $this->event->shouldReceive('addFields')
                    ->once()
                    ->with($fields);

        $tags = [
            'foo' => 'bar',
        ];

        $this->event->shouldReceive('addTags')
                    ->once()
                    ->with($tags);

        $this->event->shouldReceive('recordTimestamp')
                    ->once();

        $this->event->shouldReceive('record')
                    ->once();

        $this->event->shouldReceive('setUuidValue')
                    ->once()
                    ->with('spanIdUnitTestRun', $spanID1);

        $method = $this->getReflectionMethod('record');

        $method->invoke($this->class);

        $this->unmockFunction('memory_get_usage');
        $this->unmockFunction('memory_get_peak_usage');
        $this->unmockFunction('microtime');
    }

    /**
     * Test record() with multiple spans.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::record
     */
    public function testRecordWithMultipleSpans(): void
    {
        $floatval  = 1734352684.6526;
        $stringval = '0.65260200 1734352684';

        $this->mockFunction('microtime', fn(bool $float) => $float ? $floatval : $stringval);
        $this->mockFunction('memory_get_usage', fn() => 526160);
        $this->mockFunction('memory_get_peak_usage', fn() => 561488);

        $spanID  = '3f946299-16b5-44ee-8290-3f0fdbbbab1d';
        $spanID1 = '8d1a5341-16f9-4608-bf51-db198e52575c';
        $spanID2 = '9da74534-21d6-4a75-b58e-d27273a35330';

        $this->controller->shouldReceive('getTraceId')
                         ->once()
                         ->andReturn('e0af2cd4-6a1c-4bd6-8fca-d3684e699784');

        $this->controller->shouldReceive('getSpanId')
                         ->once()
                         ->andReturn($spanID);

        $this->controller->shouldReceive('stopChildSpan')
                         ->once();

        $this->event->shouldReceive('setTraceId')
                    ->once()
                    ->with('e0af2cd4-6a1c-4bd6-8fca-d3684e699784');

        $base = [
            [
                'name'           => 'UnitTestRun',
                'spanID'         => $spanID1,
                'startTimestamp' => $this->startTimestamp,
                'memory'         => 526161,
                'memoryPeak'     => 561489,
                'runTime'        => 0.0001,
            ],
            [
                'name'           => 'AnotherUnitTestRun',
                'spanID'         => $spanID2,
                'startTimestamp' => 1734352683.3517,
                'memory'         => 526161,
                'memoryPeak'     => 561489,
                'runTime'        => 0,
            ]
        ];

        $this->setReflectionPropertyValue('spans', $base);
        $this->setReflectionPropertyValue('fields', [ 'baz' => 2.0 ]);
        $this->setReflectionPropertyValue('tags', [ 'foo' => 'bar' ]);

        $fields = [
            'baz'                              => 2.0,
            'startTimestamp'                   => 1734352683.3516,
            'endTimestamp'                     => 1734352684.6526,
            'totalRunTime'                     => 1.3010,
            'memory'                           => 526160,
            'memoryPeak'                       => 561488,
            'spanID'                           => $spanID,
            'startTimestampUnitTestRun'        => 1734352683.3516,
            'memoryUnitTestRun'                => 526161,
            'memoryPeakUnitTestRun'            => 561489,
            'runTimeUnitTestRun'               => 0.0001,
            'startTimestampAnotherUnitTestRun' => 1734352683.3517,
            'memoryAnotherUnitTestRun'         => 526161,
            'memoryPeakAnotherUnitTestRun'     => 561489,
            'runTimeAnotherUnitTestRun'        => 1.3009,
        ];

        $this->event->shouldReceive('addFields')
                    ->once()
                    ->with($fields);

        $tags = [
            'foo' => 'bar',
        ];

        $this->event->shouldReceive('addTags')
                    ->once()
                    ->with($tags);

        $this->event->shouldReceive('recordTimestamp')
                    ->once();

        $this->event->shouldReceive('record')
                    ->once();

        $this->event->shouldReceive('setUuidValue')
                    ->once()
                    ->with('spanIdUnitTestRun', $spanID1);

        $this->event->shouldReceive('setUuidValue')
                    ->once()
                    ->with('spanIdAnotherUnitTestRun', $spanID2);

        $method = $this->getReflectionMethod('record');

        $method->invoke($this->class);

        $this->unmockFunction('memory_get_usage');
        $this->unmockFunction('memory_get_peak_usage');
        $this->unmockFunction('microtime');
    }

}

?>
