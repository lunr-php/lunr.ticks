<?php

/**
 * This file contains the Profiler class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Ticks\Profiling;

use Lunr\Ticks\EventLogging\EventInterface;
use Lunr\Ticks\TracingControllerInterface;
use Lunr\Ticks\TracingInfoInterface;
use RuntimeException;

/**
 * A generic profiler.
 *
 * @phpstan-import-type Tags from EventInterface
 * @phpstan-import-type Fields from EventInterface
 */
class Profiler
{

    /**
     * An observability event.
     * @var EventInterface
     */
    protected readonly EventInterface $event;

    /**
     * A tracing controller.
     * @var TracingControllerInterface&TracingInfoInterface
     */
    protected readonly TracingControllerInterface&TracingInfoInterface $controller;

    /**
     * Fields to add to influxdb points
     * @var Fields
     */
    protected array $fields;

    /**
     * Tags to add to influxdb points
     * @var Tags
     */
    protected array $tags;

    /**
     * Set of profiled spans
     * @var array<int,array{"name":string,"spanID":string,"startTimestamp":float,"memory":int,"memoryPeak":int,"executionTime":float}>
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
     * @param EventInterface                                  $event          An observability event.
     * @param TracingControllerInterface&TracingInfoInterface $controller     A tracing controller.
     * @param float|null                                      $startTimestamp Custom start timestamp (optional)
     */
    public function __construct(EventInterface $event, TracingControllerInterface&TracingInfoInterface $controller, ?float $startTimestamp = NULL)
    {
        $this->startTimestamp = $startTimestamp ?? microtime(as_float: TRUE);

        $this->fields = [];
        $this->tags   = [];
        $this->spans  = [];

        $this->event      = $event;
        $this->controller = $controller;
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
     * Add single piece of unstructured metadata.
     *
     * @param string                     $key   Key name
     * @param bool|float|int|string|null $value Field value
     *
     * @return void
     */
    public function addField(string $key, bool|float|int|string|null $value): void
    {
        $this->event->addFields([ $key => $value ]);
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
        $this->event->addFields($fields);
    }

    /**
     * Get single piece of unstructured metadata.
     *
     * @param string $key Key name
     *
     * @return bool|float|int|string|null
     */
    public function getField(string $key): bool|float|int|string|null
    {
        return $this->event->getFields()[$key] ?? NULL;
    }

    /**
     * Get unstructured metadata.
     *
     * @return Fields
     */
    public function getFields(): array
    {
        return $this->event->getFields();
    }

    /**
     * Add single piece of indexed metadata.
     *
     * @param string      $key   Key name
     * @param string|null $value Tag value
     *
     * @return void
     */
    public function addTag(string $key, ?string $value): void
    {
        $this->event->addTags([ $key => $value ]);
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
        $this->event->addTags($tags);
    }

    /**
     * Get single piece of indexed metadata.
     *
     * @param string $key Key name
     *
     * @return bool|string|null
     */
    public function getTag(string $key): bool|string|null
    {
        return $this->event->getTags()[$key] ?? NULL;
    }

    /**
     * Get indexed metadata.
     *
     * @return Tags
     */
    public function getTags(): array
    {
        return $this->event->getTags();
    }

    /**
     * Report start of a span
     *
     * @param string $name Name (identifier) of the Span
     *
     * @return void
     */
    public function startNewSpan(string $name): void
    {
        $start = microtime(as_float: TRUE);

        $this->finalizePreviousSpan($start);

        $this->controller->startChildSpan();

        $span = [
            'name'           => str_replace(' ', '', ucwords($name)),
            'spanID'         => $this->controller->getSpanId() ?? throw new RuntimeException('Span ID not available!'),
            'startTimestamp' => $start,
            'memory'         => memory_get_usage(),
            'memoryPeak'     => memory_get_peak_usage(),
            'executionTime'  => 0,
        ];

        $this->spans[] = $span;
    }

    /**
     * Finalize the previous span by writing the execution time.
     *
     * @param float $time The current time to use as end time for the previous span.
     *
     * @return void
     */
    protected function finalizePreviousSpan(float $time): void
    {
        $lastReport = count($this->spans) - 1;

        if ($lastReport < 0)
        {
            return;
        }

        $this->controller->stopChildSpan();

        if (!isset($this->spans[$lastReport]))
        {
            return;
        }

        $this->spans[$lastReport]['executionTime'] = (float) bcsub((string) $time, (string) $this->spans[$lastReport]['startTimestamp'], 4);
    }

    /**
     * Record the profiling information.
     *
     * @return void
     */
    protected function record(): void
    {
        $time = microtime(as_float: TRUE);

        $this->finalizePreviousSpan($time);

        $fields = $this->fields + [
            'startTimestamp'     => $this->startTimestamp,
            'endTimestamp'       => $time,
            'totalExecutionTime' => (float) bcsub((string) $time, (string) $this->startTimestamp, 4),
            'memory'             => memory_get_usage(),
            'memoryPeak'         => memory_get_peak_usage(),
        ];

        foreach ($this->spans as $span)
        {
            $name = $span['name'];

            $this->event->setUuidValue('spanId' . $name, $span['spanID']);

            unset($span['spanID'], $span['name']);

            foreach ($span as $key => $field)
            {
                $fields[$key . $name] = $field;
            }
        }

        $this->event->setTraceId($this->controller->getTraceId() ?? throw new RuntimeException('Trace ID not available!'));
        $this->event->setSpanId($this->controller->getSpanId() ?? throw new RuntimeException('Span ID not available!'));
        $this->event->addFields($fields);
        $this->event->addTags(array_merge($this->controller->getSpanSpecificTags(), $this->tags));
        $this->event->recordTimestamp();

        $this->event->record();
    }

}

?>
