<?php

/**
 * This file contains the Profiler class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\Profiling;

use Lunr\Ticks\EventLogging\EventInterface;

/**
 * A generic profiler.
 */
class Profiler
{

    /**
     * An observability event.
     * @var EventInterface
     */
    protected readonly EventInterface $event;

    /**
     * Fields to add to influxdb points
     * @var array<string,bool|float|int|string|null>
     */
    protected array $fields;

    /**
     * Tags to add to influxdb points
     * @var array<string,string>
     */
    protected array $tags;

    /**
     * Set of profiled spans
     * @var array<int,array{"name":string,"spanId":string,"startTimestamp":float,"memory":int,"memoryPeak":int,"runTime":float}>
     */
    protected array $spans;

    /**
     * Time the profiler was started.
     * @var float
     */
    protected readonly float $startTimestamp;

    /**
     * Constructor.
     *
     * @param EventInterface $event An observability event.
     */
    public function __construct(EventInterface $event)
    {
        $this->startTimestamp = microtime(TRUE);

        $this->fields = [];
        $this->tags   = [];
        $this->spans  = [];

        $this->event = $event;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->record();

        unset($this->tags);
        unset($this->fields);
    }

    /**
     * Set trace ID the event belongs to.
     *
     * @param string $trace_id Trace ID
     *
     * @return void
     */
    public function set_trace_id(string $trace_id): void
    {
        $this->event->set_trace_id($trace_id);
    }

    /**
     * Set span ID the event belongs to.
     *
     * @param string $span_id Span ID
     *
     * @return void
     */
    public function set_span_id(string $span_id): void
    {
        // InfluxDB 1.x doesn't do well with UUID tag values, so we store this as a field
        $this->event->add_fields([ 'spanID' => $span_id ]);
    }

    /**
     * Add single piece of unstructured metadata.
     *
     * @param string                     $key   Key name
     * @param bool|float|int|string|null $value Field value
     *
     * @return void
     */
    public function add_field(string $key, bool|float|int|string|null $value): void
    {
        $this->event->add_fields([ $key => $value ]);
    }

    /**
     * Add unstructured metadata.
     *
     * Set new values on top of previously set values.
     *
     * @param array<string,bool|float|int|string|null> $fields Unstructured metadata
     *
     * @return void
     */
    public function add_fields(array $fields): void
    {
        $this->event->add_fields($fields);
    }

    /**
     * Add single piece of indexed metadata.
     *
     * @param string      $key   Key name
     * @param string|null $value Tag value
     *
     * @return void
     */
    public function add_tag(string $key, ?string $value): void
    {
        $this->event->add_tags([ $key => $value ]);
    }

    /**
     * Add indexed metadata.
     *
     * Set new values on top of previously set values.
     *
     * @param array<string,string|null> $tags Indexed metadata
     *
     * @return void
     */
    public function add_tags(array $tags): void
    {
        $this->event->add_tags($tags);
    }

    /**
     * Report start of a span
     *
     * @param string $name   Name (identifier) of the Span
     * @param string $spanID ID of the new Span
     *
     * @return void
     */
    public function start_new_span(string $name, string $spanID): void
    {
        $start = microtime(TRUE);

        $this->finalize_previous_span($start);

        $span = [
            'name'           => str_replace(' ', '', ucwords($name)),
            'spanId'         => $spanID,
            'startTimestamp' => $start,
            'memory'         => memory_get_usage(),
            'memoryPeak'     => memory_get_peak_usage(),
            'runTime'        => 0,
        ];

        $this->spans[] = $span;
    }

    /**
     * Finalize the previous span by writing the runtime.
     *
     * @param float $time The current time to use as end time for the previous span.
     *
     * @return void
     */
    protected function finalize_previous_span(float $time): void
    {
        $last_report = count($this->spans) - 1;

        if ($last_report < 0)
        {
            return;
        }

        if (isset($this->spans[$last_report]))
        {
            $this->spans[$last_report]['runTime'] = (float) bcsub((string) $time, (string) $this->spans[$last_report]['startTimestamp'], 4);
        }
    }

    /**
     * Record the profiling information.
     *
     * @return void
     */
    protected function record(): void
    {
        $time = microtime(TRUE);

        $this->finalize_previous_span($time);

        $fields = $this->fields + [
            'startTimestamp' => $this->startTimestamp,
            'endTimestamp'   => $time,
            'totalRunTime'   => (float) bcsub((string) $time, (string) $this->startTimestamp, 4),
            'memory'         => memory_get_usage(),
            'memoryPeak'     => memory_get_peak_usage(),
        ];

        foreach ($this->spans as $span)
        {
            $name = $span['name'];

            $this->event->set_uuid_value('spanId' . $name, $span['spanId']);

            unset($span['spanId'], $span['name']);

            foreach ($span as $key => $field)
            {
                $fields[$key . $name] = $field;
            }
        }

        $this->event->add_fields($fields);
        $this->event->add_tags($this->tags);
        $this->event->record_timestamp();

        $this->event->record();
    }

}

?>
