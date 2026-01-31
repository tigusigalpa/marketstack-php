<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack\Endpoints;

use Tigusigalpa\Marketstack\DTO\IntradayData;

/**
 * Intraday data endpoint.
 *
 * Provides access to real-time and historical intraday stock market data.
 */
class Intraday extends BaseEndpoint
{
    /**
     * The endpoint path.
     */
    protected string $endpoint = 'intraday';

    /**
     * Set the interval for intraday data.
     *
     * @param string $interval Interval (e.g., '1min', '5min', '1hour')
     * @return $this
     */
    public function interval(string $interval): static
    {
        return $this->setParam('interval', $interval);
    }

    /**
     * Set the start date for the date range.
     *
     * @param string $date Date in YYYY-MM-DD format
     * @return $this
     */
    public function dateFrom(string $date): static
    {
        return $this->setParam('date_from', $date);
    }

    /**
     * Set the end date for the date range.
     *
     * @param string $date Date in YYYY-MM-DD format
     * @return $this
     */
    public function dateTo(string $date): static
    {
        return $this->setParam('date_to', $date);
    }

    /**
     * Get the latest intraday data.
     *
     * @return $this
     */
    public function latest(): static
    {
        $this->endpoint = 'intraday/latest';
        return $this;
    }

    /**
     * Filter by exchange MIC code.
     *
     * @param string $exchange
     * @return $this
     */
    public function exchange(string $exchange): static
    {
        return $this->setParam('exchange', $exchange);
    }

    /**
     * Transform a data item to a DTO.
     *
     * @param array<string, mixed> $data
     * @return IntradayData
     */
    protected function transformToDto(array $data): object
    {
        return new IntradayData($data);
    }
}
