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

    /**
     * Get a new ID that can be used as a span ID.
     *
     * @return string New span ID
     */
    public function getNewSpanId(): string;

    /**
     * Check whether a given string is valid for use as a span ID.
     *
     * @param string $id String to verify
     *
     * @return bool Whether the string is valid for use as a span ID or not
     */
    public function isValidSpanId(string $id): bool;

}

?>
