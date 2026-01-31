<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Tigusigalpa\Marketstack\DTO\TickerData;
use Tigusigalpa\Marketstack\Facades\Marketstack;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('can fetch tickers', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                [
                    'name' => 'Apple Inc',
                    'symbol' => 'AAPL',
                    'has_intraday' => true,
                    'has_eod' => true,
                    'country' => 'USA',
                ],
            ],
        ], 200),
    ]);

    $data = Marketstack::tickers()
        ->collect();

    expect($data)->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($data->first())->toBeInstanceOf(TickerData::class)
        ->and($data->first()->symbol)->toBe('AAPL');
});

it('can search tickers', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['name' => 'Apple Inc', 'symbol' => 'AAPL'],
            ],
        ], 200),
    ]);

    $data = Marketstack::tickers()
        ->search('Apple')
        ->collect();

    expect($data->first()->name)->toBe('Apple Inc');
});

it('can filter tickers by exchange', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['symbol' => 'AAPL', 'stock_exchange' => ['mic' => 'XNAS']],
            ],
        ], 200),
    ]);

    $data = Marketstack::tickers()
        ->exchange('XNAS')
        ->collect();

    expect($data->count())->toBeGreaterThan(0);
});

it('can fetch a specific ticker', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                'name' => 'Apple Inc',
                'symbol' => 'AAPL',
                'has_intraday' => true,
                'has_eod' => true,
            ],
        ], 200),
    ]);

    $data = Marketstack::tickers()
        ->ticker('AAPL')
        ->dto();

    expect($data)->toBeInstanceOf(TickerData::class)
        ->and($data->symbol)->toBe('AAPL');
});
