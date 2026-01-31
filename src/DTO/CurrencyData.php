<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack\DTO;

/**
 * Data Transfer Object for Currency data.
 *
 * @property-read string|null $code
 * @property-read string|null $symbol
 * @property-read string|null $name
 */
class CurrencyData
{
    /**
     * Create a new Currency data instance.
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
