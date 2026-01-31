<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack\Endpoints;

use Tigusigalpa\Marketstack\DTO\ExchangeData;
use Tigusigalpa\Marketstack\DTO\TickerData;

/**
 * Exchanges endpoint.
 *
 * Provides access to stock exchange information.
 */
class Exchanges extends BaseEndpoint
{
    /**
     * The endpoint path.
     */
    protected string $endpoint = 'exchanges';

    /**
     * Search for exchanges by keyword.
     *
     * @param string $search
     * @return $this
     */
    public function search(string $search): static
    {
        return $this->setParam('search', $search);
    }

    /**
     * Get a specific exchange by MIC code.
     *
     * @param string $mic
     * @return $this
     */
    public function mic(string $mic): static
    {
        $this->endpoint = "exchanges/{$mic}";
        return $this;
    }

    /**
     * Get tickers for a specific exchange.
     *
     * @return Tickers
     */
    public function tickers(): Tickers
    {
        $tickers = new Tickers($this->client);
        
        if (str_contains($this->endpoint, '/')) {
            $mic = explode('/', $this->endpoint)[1];
            $tickers->exchange($mic);
        }
        
        return $tickers;
    }

    /**
     * Transform a data item to a DTO.
     *
     * @param array<string, mixed> $data
     * @return ExchangeData
     */
    protected function transformToDto(array $data): object
    {
        return new ExchangeData($data);
    }
}
