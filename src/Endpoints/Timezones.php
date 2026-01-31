<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack\Endpoints;

use Tigusigalpa\Marketstack\DTO\TimezoneData;

/**
 * Timezones endpoint.
 *
 * Provides access to timezone information.
 */
class Timezones extends BaseEndpoint
{
    /**
     * The endpoint path.
     */
    protected string $endpoint = 'timezones';

    /**
     * Get a specific timezone.
     *
     * @param string $timezone
     * @return $this
     */
    public function timezone(string $timezone): static
    {
        $this->endpoint = "timezones/{$timezone}";
        return $this;
    }

    /**
     * Transform a data item to a DTO.
     *
     * @param array<string, mixed> $data
     * @return TimezoneData
     */
    protected function transformToDto(array $data): object
    {
        return new TimezoneData($data);
    }
}
