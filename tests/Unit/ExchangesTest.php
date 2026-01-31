<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Tigusigalpa\Marketstack\DTO\ExchangeData;
use Tigusigalpa\Marketstack\DTO\TickerData;
use Tigusigalpa\Marketstack\Facades\Marketstack;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('can fetch exchanges', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                [
                    'name' => 'NASDAQ Stock Exchange',
                    'acronym' => 'NASDAQ',
                    'mic' => 'XNAS',
                    'country' => 'USA',
                    'country_code' => 'US',
                    'city' => 'New York',
                    'website' => 'www.nasdaq.com',
                ],
            ],
        ], 200),
    ]);

    $data = Marketstack::exchanges()
        ->collect();

    expect($data)->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($data->first())->toBeInstanceOf(ExchangeData::class)
        ->and($data->first()->mic)->toBe('XNAS');
});

it('can search exchanges', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['name' => 'NASDAQ Stock Exchange', 'mic' => 'XNAS'],
            ],
        ], 200),
    ]);

    $data = Marketstack::exchanges()
        ->search('NASDAQ')
        ->collect();

    expect($data->first()->name)->toBe('NASDAQ Stock Exchange');
});

it('can fetch a specific exchange by MIC', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                'name' => 'NASDAQ Stock Exchange',
                'mic' => 'XNAS',
                'country' => 'USA',
            ],
        ], 200),
    ]);

    $data = Marketstack::exchanges()
        ->mic('XNAS')
        ->dto();

    expect($data)->toBeInstanceOf(ExchangeData::class)
        ->and($data->mic)->toBe('XNAS');
});

it('can fetch tickers for an exchange', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['symbol' => 'AAPL', 'name' => 'Apple Inc'],
                ['symbol' => 'GOOG', 'name' => 'Alphabet Inc'],
            ],
        ], 200),
    ]);

    $data = Marketstack::exchanges()
        ->mic('XNAS')
        ->tickers()
        ->collect();

    expect($data)->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($data->count())->toBe(2)
        ->and($data->first())->toBeInstanceOf(TickerData::class);
});
