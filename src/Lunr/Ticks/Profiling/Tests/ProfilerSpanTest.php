<?php

/**
 * This file contains the ProfilerSpanTest class.
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
class ProfilerSpanTest extends ProfilerTest
{

    /**
     * Test finalize_previous_span() with no previous span.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::finalize_previous_span
     */
    public function testFinalizePreviousSpanWithNoPreviousSpan(): void
    {
        $spanID = '8d1a5341-16f9-4608-bf51-db198e52575c';

        $method = $this->get_reflection_method('finalize_previous_span');

        $method->invokeArgs($this->class, [ 1734352683.4537 ]);

        $this->assertArrayEmpty($this->get_reflection_property_value('spans'));
    }

    /**
     * Test finalize_previous_span() with a previous span.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::finalize_previous_span
     */
    public function testFinalizePreviousSpanWithPreviousSpan(): void
    {
        $spanID = '8d1a5341-16f9-4608-bf51-db198e52575c';

        $base = [
            'name'           => 'UnitTestRun',
            'spanId'         => $spanID,
            'startTimestamp' => $this->startTimestamp,
            'memory'         => 526160,
            'memoryPeak'     => 561488,
            'runTime'        => 0,
        ];

        $this->set_reflection_property_value('spans', [ $base ]);

        $method = $this->get_reflection_method('finalize_previous_span');

        $method->invokeArgs($this->class, [ 1734352683.4537 ]);

        $expected = [
            'name'           => 'UnitTestRun',
            'spanId'         => $spanID,
            'startTimestamp' => $this->startTimestamp,
            'memory'         => 526160,
            'memoryPeak'     => 561488,
            'runTime'        => 0.1021,
        ];

        $this->assertSame($this->get_reflection_property_value('spans'), [ $expected ]);
    }

    /**
     * Test start_new_span() with no previous span.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::start_new_span
     */
    public function testStartNewSpanWithNoPreviousSpan(): void
    {
        $floatval  = 1734352683.3526;
        $stringval = '0.35260200 1734352683';

        $this->mock_function('microtime', fn(bool $float) => $float ? $floatval : $stringval);
        $this->mock_function('memory_get_usage', fn() => 526160);
        $this->mock_function('memory_get_peak_usage', fn() => 561488);

        $spanID = '8d1a5341-16f9-4608-bf51-db198e52575c';

        $this->class->start_new_span('Unit test run', $spanID);

        $expected = [
            'name'           => 'UnitTestRun',
            'spanId'         => $spanID,
            'startTimestamp' => $floatval,
            'memory'         => 526160,
            'memoryPeak'     => 561488,
            'runTime'        => 0,
        ];

        $this->assertSame($this->get_reflection_property_value('spans'), [ $expected ]);

        $this->unmock_function('memory_get_usage');
        $this->unmock_function('memory_get_peak_usage');
        $this->unmock_function('microtime');
    }

    /**
     * Test start_new_span() with a previous span.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::start_new_span
     */
    public function testStartNewSpanWithPreviousSpan(): void
    {
        $floatval  = 1734352683.3526;
        $stringval = '0.35260200 1734352683';

        $this->mock_function('microtime', fn(bool $float) => $float ? $floatval : $stringval);
        $this->mock_function('memory_get_usage', fn() => 526160);
        $this->mock_function('memory_get_peak_usage', fn() => 561488);

        $spanID = '8d1a5341-16f9-4608-bf51-db198e52575c';

        $base = [
            'name'           => 'UnitTestRun',
            'spanId'         => $spanID,
            'startTimestamp' => $this->startTimestamp,
            'memory'         => 526161,
            'memoryPeak'     => 561489,
            'runTime'        => 0,
        ];

        $this->set_reflection_property_value('spans', [ $base ]);

        $spanID2 = '9da74534-21d6-4a75-b58e-d27273a35330';

        $this->class->start_new_span('Unit test run 2', $spanID2);

        $expected = [
            [
                'name'           => 'UnitTestRun',
                'spanId'         => $spanID,
                'startTimestamp' => $this->startTimestamp,
                'memory'         => 526161,
                'memoryPeak'     => 561489,
                'runTime'        => 0.001,
            ],
            [
                'name'           => 'UnitTestRun2',
                'spanId'         => $spanID2,
                'startTimestamp' => $floatval,
                'memory'         => 526160,
                'memoryPeak'     => 561488,
                'runTime'        => 0,
            ]
        ];

        $this->assertSame($this->get_reflection_property_value('spans'), $expected);

        $this->unmock_function('memory_get_usage');
        $this->unmock_function('memory_get_peak_usage');
        $this->unmock_function('microtime');
    }

}

?>
