<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack\DTO;

/**
 * Data Transfer Object for End-of-Day data.
 *
 * @property-read string|null $symbol
 * @property-read string|null $exchange
 * @property-read string|null $date
 * @property-read float|null $open
 * @property-read float|null $high
 * @property-read float|null $low
 * @property-read float|null $close
 * @property-read float|null $volume
 * @property-read float|null $adj_open
 * @property-read float|null $adj_high
 * @property-read float|null $adj_low
 * @property-read float|null $adj_close
 * @property-read float|null $adj_volume
 * @property-read float|null $split_factor
 * @property-read float|null $dividend
 */
class EodData
{
    /**
     * Create a new EOD data instance.
     *
     * @param array<string, mixed> $data
     */
    public function __construct(
        protected array $data
    ) {
    }

    /**
     * Get a property value.
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->data[$name] ?? null;
    }

    /**
     * Check if a property exists.
     *
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Get all data as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
