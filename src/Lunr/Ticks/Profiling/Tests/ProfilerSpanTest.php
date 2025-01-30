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
class ProfilerSpanTest extends ProfilerTestCase
{

    /**
     * Test finalizePreviousSpan() with no previous span.
     *
     * @covers Lunr\Ticks\Profiling\Profiler::finalizePreviousSpan
     */
    public function testFinalizePreviousSpanWithNoPreviousSpan(): void
    {
        $spanID = '8d1a5341-16f9-4608-bf51-db198e52575c';

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
            'spanId'         => $spanID,
            'startTimestamp' => $this->startTimestamp,
            'memory'         => 526160,
            'memoryPeak'     => 561488,
            'runTime'        => 0,
        ];

        $this->setReflectionPropertyValue('spans', [ $base ]);

        $method = $this->getReflectionMethod('finalizePreviousSpan');

        $method->invokeArgs($this->class, [ 1734352683.4537 ]);

        $expected = [
            'name'           => 'UnitTestRun',
            'spanId'         => $spanID,
            'startTimestamp' => $this->startTimestamp,
            'memory'         => 526160,
            'memoryPeak'     => 561488,
            'runTime'        => 0.1021,
        ];

        $this->assertSame($this->getReflectionPropertyValue('spans'), [ $expected ]);
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

        $this->class->startNewSpan('Unit test run', $spanID);

        $expected = [
            'name'           => 'UnitTestRun',
            'spanId'         => $spanID,
            'startTimestamp' => $floatval,
            'memory'         => 526160,
            'memoryPeak'     => 561488,
            'runTime'        => 0,
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

        $spanID2 = '9da74534-21d6-4a75-b58e-d27273a35330';

        $this->class->startNewSpan('Unit test run 2', $spanID2);

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

        $this->assertSame($this->getReflectionPropertyValue('spans'), $expected);

        $this->unmockFunction('memory_get_usage');
        $this->unmockFunction('memory_get_peak_usage');
        $this->unmockFunction('microtime');
    }

}

?>
