<?php

/**
 * This file contains the EventInterface class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\EventLogging;

use Lunr\Ticks\Precision;

/**
 * Interface for events.
 *
 * @phpstan-type Tags   array<string,bool|string|null>
 * @phpstan-type Fields array<string,scalar|null>
 */
interface EventInterface
{

    /**
     * Set event name.
     *
     * @param string $name Event name
     *
     * @return void
     */
    public function setName(string $name): void;

    /**
     * Get event name.
     *
     * @return string Event name
     */
    public function getName(): string;

    /**
     * Set trace ID the event belongs to.
     *
     * @param string $traceID Trace ID
     *
     * @return void
     */
    public function setTraceId(string $traceID): void;

    /**
     * Get trace ID the event belongs to.
     *
     * @return string|null Trace ID
     */
    public function getTraceId(): ?string;

    /**
     * Set span ID the event belongs to.
     *
     * @param string $spanID Span ID
     *
     * @return void
     */
    public function setSpanId(string $spanID): void;

    /**
     * Get span ID the event belongs to.
     *
     * @return string|null Span ID
     */
    public function getSpanId(): ?string;

    /**
     * Set span ID of the parent the event belongs to.
     *
     * @param string $spanID Span ID
     *
     * @return void
     */
    public function setParentSpanId(string $spanID): void;

    /**
     * Get span ID of the parent the event belongs to.
     *
     * @return string|null Parent span ID
     */
    public function getParentSpanId(): ?string;

    /**
     * Set a UUID value.
     *
     * @param string $key  Name for the UUID value
     * @param string $uuid The UUID to set
     *
     * @return void
     */
    public function setUuidValue(string $key, string $uuid): void;

    /**
     * Set indexed metadata.
     *
     * This clears all previously set values and replaces them.
     *
     * @param Tags $tags Indexed metadata
     *
     * @return void
     */
    public function setTags(array $tags): void;

    /**
     * Add indexed metadata.
     *
     * Set new values on top of previously set values.
     *
     * @param Tags $tags Indexed metadata
     *
     * @return void
     */
    public function addTags(array $tags): void;

    /**
     * Get indexed metadata.
     *
     * @return Tags Indexed metadata
     */
    public function getTags(): array;

    /**
     * Set unstructured metadata.
     *
     * This clears all previously set values and replaces them.
     *
     * @param Fields $fields Unstructured metadata
     *
     * @return void
     */
    public function setFields(array $fields): void;

    /**
     * Add unstructured metadata.
     *
     * Set new values on top of previously set values.
     *
     * @param Fields $fields Unstructured metadata
     *
     * @return void
     */
    public function addFields(array $fields): void;

    /**
     * Get unstructured metadata.
     *
     * @return Fields Unstructured metadata
     */
    public function getFields(): array;

    /**
     * Record the current timestamp for the event.
     *
     * @param Precision $precision Timestamp precision
     *
     * @return void
     */
    public function recordTimestamp(Precision $precision = Precision::NanoSeconds): void;

    /**
     * Set custom timestamp for the event.
     *
     * @param int|string $timestamp Timestamp
     *
     * @return void
     */
    public function setTimestamp(int|string $timestamp): void;

    /**
     * Return the timestamp for the event.
     *
     * @return int|string Timestamp
     */
    public function getTimestamp(): int|string;

    /**
     * Record the event.
     *
     * @param Precision $precision Timestamp precision (defaults to Nanoseconds)
     *
     * @return void
     */
    public function record(Precision $precision = Precision::NanoSeconds): void;

}

?>
