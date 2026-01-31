<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack\Endpoints;

use Tigusigalpa\Marketstack\DTO\TickerData;

/**
 * Tickers endpoint.
 *
 * Provides access to stock ticker information.
 */
class Tickers extends BaseEndpoint
{
    /**
     * The endpoint path.
     */
    protected string $endpoint = 'tickers';

    /**
     * Search for tickers by keyword.
     *
     * @param string $search
     * @return $this
     */
    public function search(string $search): static
    {
        return $this->setParam('search', $search);
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
     * Get a specific ticker by symbol.
     *
     * @param string $symbol
     * @return $this
     */
    public function ticker(string $symbol): static
    {
        $this->endpoint = "tickers/{$symbol}";
        return $this;
    }

    /**
     * Transform a data item to a DTO.
     *
     * @param array<string, mixed> $data
     * @return TickerData
     */
    protected function transformToDto(array $data): object
    {
        return new TickerData($data);
    }
}
