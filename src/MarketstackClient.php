<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Tigusigalpa\Marketstack\Endpoints\Currencies;
use Tigusigalpa\Marketstack\Endpoints\Eod;
use Tigusigalpa\Marketstack\Endpoints\Exchanges;
use Tigusigalpa\Marketstack\Endpoints\Intraday;
use Tigusigalpa\Marketstack\Endpoints\Tickers;
use Tigusigalpa\Marketstack\Endpoints\Timezones;

/**
 * Main client for interacting with the Marketstack API.
 *
 * This client provides a fluent interface for accessing various Marketstack
 * API endpoints such as EOD data, intraday data, tickers, exchanges, etc.
 */
class MarketstackClient
{
    /**
     * The API key for authentication.
     */
    protected string $apiKey;

    /**
     * The base URL for API requests.
     */
    protected string $baseUrl;

    /**
     * The timeout for API requests in seconds.
     */
    protected int $timeout;

    /**
     * Create a new Marketstack client instance.
     *
     * @param string $apiKey The API key for authentication
     * @param string|null $baseUrl The base URL for API requests
     * @param int $timeout The timeout for requests in seconds
     */
    public function __construct(
        string $apiKey,
        ?string $baseUrl = null,
        int $timeout = 30
    ) {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl ?? config('marketstack.base_url', 'http://api.marketstack.com/v1');
        $this->timeout = $timeout;

        if (config('marketstack.use_https', false)) {
            $this->baseUrl = str_replace('http://', 'https://', $this->baseUrl);
        }
    }

    /**
     * Get a configured HTTP client instance.
     *
     * @return PendingRequest
     */
    public function getHttpClient(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->timeout($this->timeout)
            ->withQueryParameters(['access_key' => $this->apiKey])
            ->acceptJson();
    }

    /**
     * Access the End-of-Day (EOD) data endpoint.
     *
     * @return Eod
     */
    public function eod(): Eod
    {
        return new Eod($this);
    }

    /**
     * Access the Intraday data endpoint.
     *
     * @return Intraday
     */
    public function intraday(): Intraday
    {
        return new Intraday($this);
    }

    /**
     * Access the Tickers endpoint.
     *
     * @return Tickers
     */
    public function tickers(): Tickers
    {
        return new Tickers($this);
    }

    /**
     * Access the Exchanges endpoint.
     *
     * @return Exchanges
     */
    public function exchanges(): Exchanges
    {
        return new Exchanges($this);
    }

    /**
     * Access the Currencies endpoint.
     *
     * @return Currencies
     */
    public function currencies(): Currencies
    {
        return new Currencies($this);
    }

    /**
     * Access the Timezones endpoint.
     *
     * @return Timezones
     */
    public function timezones(): Timezones
    {
        return new Timezones($this);
    }

    /**
     * Get the API key.
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Get the base URL.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
