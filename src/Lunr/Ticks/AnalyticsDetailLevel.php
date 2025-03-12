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
     * Basic analytics only.
     */
    case Info = 0;

    /**
     * Detailed analytics.
     */
    case Detailed = 1;

    /**
     * Full, unabridged analytics.
     */
    case Full = 2;

}

?>
