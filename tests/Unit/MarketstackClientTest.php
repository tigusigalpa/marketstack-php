<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Tigusigalpa\Marketstack\Exceptions\MarketstackException;
use Tigusigalpa\Marketstack\Facades\Marketstack;
use Tigusigalpa\Marketstack\MarketstackClient;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('can create a client instance', function () {
    $client = new MarketstackClient('test-key');

    expect($client)->toBeInstanceOf(MarketstackClient::class)
        ->and($client->getApiKey())->toBe('test-key');
});

it('can get HTTP client with proper configuration', function () {
    $client = new MarketstackClient('test-key');
    $httpClient = $client->getHttpClient();

    expect($httpClient)->toBeInstanceOf(\Illuminate\Http\Client\PendingRequest::class);
});

it('throws exception on API error', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'error' => [
                'code' => 'invalid_access_key',
                'message' => 'Invalid API key',
            ],
        ], 401),
    ]);

    Marketstack::eod()
        ->symbols('AAPL')
        ->collect();
})->throws(MarketstackException::class);

it('can access all endpoint methods', function () {
    $client = new MarketstackClient('test-key');

    expect($client->eod())->toBeInstanceOf(\Tigusigalpa\Marketstack\Endpoints\Eod::class)
        ->and($client->intraday())->toBeInstanceOf(\Tigusigalpa\Marketstack\Endpoints\Intraday::class)
        ->and($client->tickers())->toBeInstanceOf(\Tigusigalpa\Marketstack\Endpoints\Tickers::class)
        ->and($client->exchanges())->toBeInstanceOf(\Tigusigalpa\Marketstack\Endpoints\Exchanges::class)
        ->and($client->currencies())->toBeInstanceOf(\Tigusigalpa\Marketstack\Endpoints\Currencies::class)
        ->and($client->timezones())->toBeInstanceOf(\Tigusigalpa\Marketstack\Endpoints\Timezones::class);
});

it('can build URL for debugging', function () {
    $url = Marketstack::eod()
        ->symbols('AAPL')
        ->dateFrom('2023-01-01')
        ->buildUrl();

    expect($url)->toContain('eod')
        ->and($url)->toContain('symbols=AAPL')
        ->and($url)->toContain('date_from=2023-01-01')
        ->and($url)->toContain('access_key=');
});

it('uses HTTPS when configured', function () {
    config(['marketstack.use_https' => true]);
    
    $client = new MarketstackClient('test-key');
    
    expect($client->getBaseUrl())->toStartWith('https://');
});
