<?php

/**
 * This file contains the EventLogger class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\EventLogging\Null;

use Lunr\Ticks\EventLogging\EventLoggerInterface;

/**
 * Class for logging events.
 */
class NullEventLogger implements EventLoggerInterface
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        // no-op
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // no-op
    }

    /**
     * Get an instance of a new event
     *
     * @param string $name Event name
     *
     * @return NullEvent Instance of a new NullEvent
     */
    public function newEvent(string $name): NullEvent
    {
        return new NullEvent($this);
    }

}

?>
