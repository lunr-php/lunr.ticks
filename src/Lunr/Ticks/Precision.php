<?php

/**
 * This file contains the Precision enum.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks;

/**
 * Enum for timestamp precision.
 */
enum Precision
{

    /**
     * Precision to the hour.
     */
    case Hours;

    /**
     * Precision to the minute.
     */
    case Minutes;

    /**
     * Precision to the second.
     */
    case Seconds;

    /**
     * Precision to the millisecond.
     */
    case MilliSeconds;

    /**
     * Precision to the microsecond.
     */
    case MicroSeconds;

    /**
     * Precision to the nanosecond.
     */
    case NanoSeconds;

}

?>
