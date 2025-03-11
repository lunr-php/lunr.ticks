<?php

/**
 * This file contains the TracingControllerInterface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks;

/**
 * Interface for controlling the tracing process.
 */
interface TracingControllerInterface
{

    /**
     * Start a new child span.
     *
     * @return void
     */
    public function startChildSpan(): void;

    /**
     * Stop the current child span, returning to the scope of the parent.
     *
     * @return void
     */
    public function stopChildSpan(): void;

}

?>
