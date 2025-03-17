<?php

/**
 * This file contains the Analytics Detail Level enum.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks;

/**
 * Enum for analytics detail level.
 */
enum AnalyticsDetailLevel: int
{

    /**
     * No analytics.
     */
    case None = 0;

    /**
     * Basic analytics only.
     */
    case Info = 1;

    /**
     * Detailed analytics.
     */
    case Detailed = 2;

    /**
     * Full, unabridged analytics.
     */
    case Full = 3;

    /**
     * Check a minimum analytics detail level.
     *
     * @param AnalyticsDetailLevel $level Level to compare with
     *
     * @return bool
     */
    public function atleast(AnalyticsDetailLevel $level): bool
    {
        if ($this === AnalyticsDetailLevel::None)
        {
            // None means disabled
            return FALSE;
        }

        return $this->value >= $level->value;
    }

}

?>
