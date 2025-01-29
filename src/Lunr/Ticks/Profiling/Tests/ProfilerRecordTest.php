<?php

/**
 * This file contains the ProfilerRecordTest class.
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
class ProfilerRecordTest extends ProfilerTestCase
{

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

        $fields = [
            'startTimestamp' => 1734352683.3516,
            'endTimestamp'   => 1734352684.6526,
            'totalRunTime'   => 1.3010,
            'memory'         => 526160,
            'memoryPeak'     => 561488,
        ];

        $this->event->expects($this->once())
                    ->method('add_fields')
                    ->with($fields);

        $this->event->expects($this->once())
                    ->method('add_tags')
                    ->with([]);

        $this->event->expects($this->once())
                    ->method('record_timestamp');

        $this->event->expects($this->once())
                    ->method('record');

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
    public function testRecordWithOneSpans(): void
    {
        $floatval  = 1734352684.6526;
        $stringval = '0.65260200 1734352684';

        $this->mockFunction('microtime', fn(bool $float) => $float ? $floatval : $stringval);
        $this->mockFunction('memory_get_usage', fn() => 526160);
        $this->mockFunction('memory_get_peak_usage', fn() => 561488);

        $spanID = '8d1a5341-16f9-4608-bf51-db198e52575c';

        $base = [
            'name'           => 'UnitTestRun',
            'spanId'         => $spanID,
            'startTimestamp' => $this->startTimestamp,
            'memory'         => 526161,
            'memoryPeak'     => 561489,
            'runTime'        => 0,
        ];

        $this->setReflectionPropertyValue('spans', [ $base ]);
        $this->setReflectionPropertyValue('fields', [ 'baz' => 2.0 ]);
        $this->setReflectionPropertyValue('tags', [ 'foo' => 'bar' ]);

        $fields = [
            'baz'                       => 2.0,
            'startTimestamp'            => 1734352683.3516,
            'endTimestamp'              => 1734352684.6526,
            'totalRunTime'              => 1.3010,
            'memory'                    => 526160,
            'memoryPeak'                => 561488,
            'startTimestampUnitTestRun' => 1734352683.3516,
            'memoryUnitTestRun'         => 526161,
            'memoryPeakUnitTestRun'     => 561489,
            'runTimeUnitTestRun'        => 1.301,
        ];

        $this->event->expects($this->once())
                    ->method('add_fields')
                    ->with($fields);

        $tags = [
            'foo' => 'bar',
        ];

        $this->event->expects($this->once())
                    ->method('add_tags')
                    ->with($tags);

        $this->event->expects($this->once())
                    ->method('record_timestamp');

        $this->event->expects($this->once())
                    ->method('record');

        $this->event->expects($this->once())
                    ->method('set_uuid_value')
                    ->with('spanIdUnitTestRun', $spanID);

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

        $spanID  = '8d1a5341-16f9-4608-bf51-db198e52575c';
        $spanID2 = '9da74534-21d6-4a75-b58e-d27273a35330';

        $base = [
            [
                'name'           => 'UnitTestRun',
                'spanId'         => $spanID,
                'startTimestamp' => $this->startTimestamp,
                'memory'         => 526161,
                'memoryPeak'     => 561489,
                'runTime'        => 0.0001,
            ],
            [
                'name'           => 'AnotherUnitTestRun',
                'spanId'         => $spanID2,
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
            'startTimestampUnitTestRun'        => 1734352683.3516,
            'memoryUnitTestRun'                => 526161,
            'memoryPeakUnitTestRun'            => 561489,
            'runTimeUnitTestRun'               => 0.0001,
            'startTimestampAnotherUnitTestRun' => 1734352683.3517,
            'memoryAnotherUnitTestRun'         => 526161,
            'memoryPeakAnotherUnitTestRun'     => 561489,
            'runTimeAnotherUnitTestRun'        => 1.3009,
        ];

        $this->event->expects($this->once())
                    ->method('add_fields')
                    ->with($fields);

        $tags = [
            'foo' => 'bar',
        ];

        $this->event->expects($this->once())
                    ->method('add_tags')
                    ->with($tags);

        $this->event->expects($this->once())
                    ->method('record_timestamp');

        $this->event->expects($this->once())
                    ->method('record');

        $this->event->expects($this->exactly(2))
                    ->method('set_uuid_value')
                    ->withConsecutive(
                        [ 'spanIdUnitTestRun', $spanID ],
                        [ 'spanIdAnotherUnitTestRun', $spanID2 ]
                    );

        $method = $this->getReflectionMethod('record');

        $method->invoke($this->class);

        $this->unmockFunction('memory_get_usage');
        $this->unmockFunction('memory_get_peak_usage');
        $this->unmockFunction('microtime');
    }

}

?>
