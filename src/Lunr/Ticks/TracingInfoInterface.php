<?php

/**
 * This file contains the TracingInfoInterface.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks;

use Lunr\Ticks\EventLogging\EventInterface;

/**
 * Interface for accessing tracing info.
 *
 * @phpstan-import-type Tags from EventInterface
 */
interface TracingInfoInterface
{

    /**
     * Get trace ID the event belongs to.
     *
     * @return string|null Trace ID
     */
    public function getTraceId(): ?string;

    /**
     * Get span ID the event belongs to.
     *
     * @return string|null Span ID
     */
    public function getSpanId(): ?string;

    /**
     * Get span ID of the parent the event belongs to.
     *
     * @return string|null Parent span ID
     */
    public function getParentSpanId(): ?string;

    /**
     * Get tags that are specific to the current span.
     *
     * @return Tags Indexed metadata about the current span
     */
    public function getSpanSpecificTags(): array;

}

?>
