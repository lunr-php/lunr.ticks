<?php

/**
 * This file contains the AnalyticsDetailLevelTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\Tests;

use Lunr\Halo\LunrBaseTestCase;
use Lunr\Ticks\AnalyticsDetailLevel;

/**
 * This class contains tests for the AnalyticsDetailLevel enum.
 *
 * @covers Lunr\Ticks\AnalyticsDetailLevel
 */
class AnalyticsDetailLevelTest extends LunrBaseTestCase
{

    /**
     * Test that atLeast() works correctly.
     *
     * @covers Lunr\Ticks\AnalyticsDetailLevel::atLeast
     */
    public function testAtLeastWithNone()
    {
        $this->assertFalse(AnalyticsDetailLevel::None->atLeast(AnalyticsDetailLevel::None));
        $this->assertFalse(AnalyticsDetailLevel::None->atLeast(AnalyticsDetailLevel::Info));
        $this->assertFalse(AnalyticsDetailLevel::None->atLeast(AnalyticsDetailLevel::Detailed));
        $this->assertFalse(AnalyticsDetailLevel::None->atLeast(AnalyticsDetailLevel::Full));
    }

    /**
     * Test that atLeast() works correctly.
     *
     * @covers Lunr\Ticks\AnalyticsDetailLevel::atLeast
     */
    public function testAtLeastWithInfo()
    {
        $this->assertTrue(AnalyticsDetailLevel::Info->atLeast(AnalyticsDetailLevel::None));
        $this->assertTrue(AnalyticsDetailLevel::Info->atLeast(AnalyticsDetailLevel::Info));
        $this->assertFalse(AnalyticsDetailLevel::Info->atLeast(AnalyticsDetailLevel::Detailed));
        $this->assertFalse(AnalyticsDetailLevel::Info->atLeast(AnalyticsDetailLevel::Full));
    }

    /**
     * Test that atLeast() works correctly.
     *
     * @covers Lunr\Ticks\AnalyticsDetailLevel::atLeast
     */
    public function testAtLeastWithDetailed()
    {
        $this->assertTrue(AnalyticsDetailLevel::Detailed->atLeast(AnalyticsDetailLevel::None));
        $this->assertTrue(AnalyticsDetailLevel::Detailed->atLeast(AnalyticsDetailLevel::Info));
        $this->assertTrue(AnalyticsDetailLevel::Detailed->atLeast(AnalyticsDetailLevel::Detailed));
        $this->assertFalse(AnalyticsDetailLevel::Detailed->atLeast(AnalyticsDetailLevel::Full));
    }

    /**
     * Test that atLeast() works correctly.
     *
     * @covers Lunr\Ticks\AnalyticsDetailLevel::atLeast
     */
    public function testAtLeastWithFull()
    {
        $this->assertTrue(AnalyticsDetailLevel::Full->atLeast(AnalyticsDetailLevel::None));
        $this->assertTrue(AnalyticsDetailLevel::Full->atLeast(AnalyticsDetailLevel::Info));
        $this->assertTrue(AnalyticsDetailLevel::Full->atLeast(AnalyticsDetailLevel::Detailed));
        $this->assertTrue(AnalyticsDetailLevel::Full->atLeast(AnalyticsDetailLevel::Full));
    }

}

?>
