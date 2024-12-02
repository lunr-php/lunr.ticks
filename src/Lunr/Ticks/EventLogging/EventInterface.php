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
    public function set_name(string $name): void;

    /**
     * Get event name.
     *
     * @return string Event name
     */
    public function get_name(): string;

    /**
     * Set trace ID the event belongs to.
     *
     * @param string $traceID Trace ID
     *
     * @return void
     */
    public function set_trace_id(string $traceID): void;

    /**
     * Get trace ID the event belongs to.
     *
     * @return string|null Trace ID
     */
    public function get_trace_id(): ?string;

    /**
     * Set span ID the event belongs to.
     *
     * @param string $spanID Span ID
     *
     * @return void
     */
    public function set_span_id(string $spanID): void;

    /**
     * Get span ID the event belongs to.
     *
     * @return string|null Span ID
     */
    public function get_span_id(): ?string;

    /**
     * Set span ID of the parent the event belongs to.
     *
     * @param string $spanID Span ID
     *
     * @return void
     */
    public function set_parent_span_id(string $spanID): void;

    /**
     * Get span ID of the parent the event belongs to.
     *
     * @return string|null Parent span ID
     */
    public function get_parent_span_id(): ?string;

    /**
     * Set a UUID value.
     *
     * @param string $key  Name for the UUID value
     * @param string $uuid The UUID to set
     *
     * @return void
     */
    public function set_uuid_value(string $key, string $uuid): void;

    /**
     * Set indexed metadata.
     *
     * This clears all previously set values and replaces them.
     *
     * @param array<string,string|null> $tags Indexed metadata
     *
     * @return void
     */
    public function set_tags(array $tags): void;

    /**
     * Add indexed metadata.
     *
     * Set new values on top of previously set values.
     *
     * @param array<string,string|null> $tags Indexed metadata
     *
     * @return void
     */
    public function add_tags(array $tags): void;

    /**
     * Get indexed metadata.
     *
     * @return array<string,string|null> Indexed metadata
     */
    public function get_tags(): array;

    /**
     * Set unstructured metadata.
     *
     * This clears all previously set values and replaces them.
     *
     * @param array<string,bool|float|int|string|null> $fields Unstructured metadata
     *
     * @return void
     */
    public function set_fields(array $fields): void;

    /**
     * Add unstructured metadata.
     *
     * Set new values on top of previously set values.
     *
     * @param array<string,bool|float|int|string|null> $fields Unstructured metadata
     *
     * @return void
     */
    public function add_fields(array $fields): void;

    /**
     * Get unstructured metadata.
     *
     * @return array<string,bool|float|int|string|null> Unstructured metadata
     */
    public function get_fields(): array;

    /**
     * Record the current timestamp for the event.
     *
     * @param Precision $precision Timestamp precision
     *
     * @return void
     */
    public function record_timestamp(Precision $precision = Precision::NanoSeconds): void;

    /**
     * Set custom timestamp for the event.
     *
     * @param int|string $timestamp Timestamp
     *
     * @return void
     */
    public function set_timestamp(int|string $timestamp): void;

    /**
     * Return the timestamp for the event.
     *
     * @return int|string Timestamp
     */
    public function get_timestamp(): int|string;

    /**
     * Record the event.
     *
     * @return void
     */
    public function record(): void;

}

?>
