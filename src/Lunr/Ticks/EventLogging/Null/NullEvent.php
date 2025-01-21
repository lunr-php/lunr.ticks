<?php

/**
 * This file contains the Event class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\EventLogging\Null;

use Lunr\Ticks\EventLogging\EventInterface;
use Lunr\Ticks\Precision;

/**
 * Class for events.
 *
 * @phpstan-import-type Tags from EventInterface
 * @phpstan-import-type Fields from EventInterface
 */
class NullEvent implements EventInterface
{

    /**
     * Instance of of the Null event logger
     * @var NullEventLogger
     */
    protected readonly NullEventLogger $eventLogger;

    /**
     * Constructor.
     *
     * @param NullEventLogger $eventLogger Instance of the NullEventLogger that created the Event
     */
    public function __construct(NullEventLogger $eventLogger)
    {
        $this->eventLogger = $eventLogger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // no-op
    }

    /**
     * Set event name.
     *
     * @param string $name Event name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        // no-op
    }

    /**
     * Get event name.
     *
     * @return string Event name
     */
    public function getName(): string
    {
        return '';
    }

    /**
     * Set trace ID the event belongs to.
     *
     * @param string $traceID Trace ID
     *
     * @return void
     */
    public function setTraceId(string $traceID): void
    {
        // no-op
    }

    /**
     * Get trace ID the event belongs to.
     *
     * @return string|null Trace ID
     */
    public function getTraceId(): ?string
    {
        return NULL;
    }

    /**
     * Set span ID the event belongs to.
     *
     * @param string $spanID Span ID
     *
     * @return void
     */
    public function setSpanId(string $spanID): void
    {
        // no-op
    }

    /**
     * Get span ID the event belongs to.
     *
     * @return string|null Span ID
     */
    public function getSpanId(): ?string
    {
        return NULL;
    }

    /**
     * Set span ID of the parent the event belongs to.
     *
     * @param string $spanID Span ID
     *
     * @return void
     */
    public function setParentSpanId(string $spanID): void
    {
        // no-op
    }

    /**
     * Get span ID of the parent the event belongs to.
     *
     * @return string|null Parent span ID
     */
    public function getParentSpanId(): ?string
    {
        return NULL;
    }

    /**
     * Set a UUID value.
     *
     * @param string $key  Name for the UUID value
     * @param string $uuid The UUID to set
     *
     * @return void
     */
    public function setUuidValue(string $key, string $uuid): void
    {
        // no-op
    }

    /**
     * Set indexed metadata.
     *
     * This clears all previously set values and replaces them.
     *
     * @param Tags $tags Indexed metadata
     *
     * @return void
     */
    public function setTags(array $tags): void
    {
        // no-op
    }

    /**
     * Add indexed metadata.
     *
     * Set new values on top of previously set values.
     *
     * @param Tags $tags Indexed metadata
     *
     * @return void
     */
    public function addTags(array $tags): void
    {
        // no-op
    }

    /**
     * Get indexed metadata.
     *
     * @return Tags Indexed metadata
     */
    public function getTags(): array
    {
        return [];
    }

    /**
     * Set unstructured metadata.
     *
     * This clears all previously set values and replaces them.
     *
     * @param Fields $fields Unstructured metadata
     *
     * @return void
     */
    public function setFields(array $fields): void
    {
        // no-op
    }

    /**
     * Add unstructured metadata.
     *
     * Set new values on top of previously set values.
     *
     * @param Fields $fields Unstructured metadata
     *
     * @return void
     */
    public function addFields(array $fields): void
    {
        // no-op
    }

    /**
     * Get unstructured metadata.
     *
     * @return Fields Unstructured metadata
     */
    public function getFields(): array
    {
        return [];
    }

    /**
     * Record the current timestamp for the event.
     *
     * @param Precision $precision Timestamp precision (defaults to Nanoseconds)
     *
     * @return void
     */
    public function recordTimestamp(Precision $precision = Precision::NanoSeconds): void
    {
        // no-op
    }

    /**
     * Set custom timestamp for the event.
     *
     * @param int|string $timestamp Timestamp
     *
     * @return void
     */
    public function setTimestamp(int|string $timestamp): void
    {
        // no-op
    }

    /**
     * Return the timestamp for the event.
     *
     * @return int Timestamp
     */
    public function getTimestamp(): int
    {
        return -1;
    }

    /**
     * Record the event.
     *
     * @param Precision $precision Timestamp precision (defaults to Nanoseconds)
     *
     * @return void
     */
    public function record($precision = Precision::NanoSeconds): void
    {
        // no-op
    }

}

?>
