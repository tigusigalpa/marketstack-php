<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack\Endpoints;

use Tigusigalpa\Marketstack\DTO\EodData;

/**
 * End-of-Day (EOD) data endpoint.
 *
 * Provides access to historical end-of-day stock market data.
 */
class Eod extends BaseEndpoint
{
    /**
     * The endpoint path.
     */
    protected string $endpoint = 'eod';

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
     * Get data for a specific date.
     *
     * @param string $symbol The stock symbol
     * @return $this
     */
    public function latest(string $symbol): static
    {
        $this->endpoint = "eod/latest";
        return $this->setParam('symbols', $symbol);
    }

    /**
     * Get data for a specific date.
     *
     * @param string $date Date in YYYY-MM-DD format
     * @return $this
     */
    public function date(string $date): static
    {
        $this->endpoint = "eod/{$date}";
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
     * @return EodData
     */
    protected function transformToDto(array $data): object
    {
        return new EodData($data);
    }
}
