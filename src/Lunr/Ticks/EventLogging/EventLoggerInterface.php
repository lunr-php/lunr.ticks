<?php

/**
 * This file contains the EventLoggerInterface class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\EventLogging;

/**
 * Interface for logging events.
 */
interface EventLoggerInterface
{

    /**
     * Get an instance of a new event
     *
     * @param string $name Event name
     *
     * @return EventInterface Instance of a new Event
     */
    public function newEvent(string $name): EventInterface;

}

?>
