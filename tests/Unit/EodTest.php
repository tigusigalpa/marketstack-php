<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Tigusigalpa\Marketstack\DTO\EodData;
use Tigusigalpa\Marketstack\Facades\Marketstack;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('can fetch EOD data with symbols', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                [
                    'symbol' => 'AAPL',
                    'exchange' => 'XNAS',
                    'date' => '2023-01-31',
                    'open' => 143.97,
                    'high' => 147.23,
                    'low' => 143.90,
                    'close' => 144.29,
                    'volume' => 65136600.0,
                ],
            ],
        ], 200),
    ]);

    $data = Marketstack::eod()
        ->symbols('AAPL')
        ->dateFrom('2023-01-01')
        ->dateTo('2023-01-31')
        ->collect();

    expect($data)->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($data->count())->toBe(1)
        ->and($data->first())->toBeInstanceOf(EodData::class)
        ->and($data->first()->symbol)->toBe('AAPL')
        ->and($data->first()->close)->toBe(144.29);
});

it('can fetch EOD data with multiple symbols', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['symbol' => 'AAPL', 'close' => 144.29],
                ['symbol' => 'GOOG', 'close' => 91.25],
            ],
        ], 200),
    ]);

    $data = Marketstack::eod()
        ->symbols('AAPL', 'GOOG')
        ->limit(100)
        ->collect();

    expect($data->count())->toBe(2)
        ->and($data->pluck('symbol')->toArray())->toBe(['AAPL', 'GOOG']);
});

it('can fetch latest EOD data', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['symbol' => 'AAPL', 'close' => 144.29],
            ],
        ], 200),
    ]);

    $data = Marketstack::eod()
        ->latest('AAPL')
        ->dto();

    expect($data)->toBeInstanceOf(EodData::class)
        ->and($data->symbol)->toBe('AAPL');
});

it('can fetch EOD data for specific date', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['symbol' => 'AAPL', 'date' => '2023-01-15', 'close' => 144.29],
            ],
        ], 200),
    ]);

    $data = Marketstack::eod()
        ->date('2023-01-15')
        ->symbols('AAPL')
        ->collect();

    expect($data->first()->date)->toBe('2023-01-15');
});

it('can sort EOD data', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['symbol' => 'AAPL', 'date' => '2023-01-01'],
                ['symbol' => 'AAPL', 'date' => '2023-01-02'],
            ],
        ], 200),
    ]);

    $data = Marketstack::eod()
        ->symbols('AAPL')
        ->sort('ASC')
        ->collect();

    expect($data->count())->toBe(2);
});

it('can filter by exchange', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['symbol' => 'AAPL', 'exchange' => 'XNAS'],
            ],
        ], 200),
    ]);

    $data = Marketstack::eod()
        ->symbols('AAPL')
        ->exchange('XNAS')
        ->collect();

    expect($data->first()->exchange)->toBe('XNAS');
});

it('returns json data', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['symbol' => 'AAPL', 'close' => 144.29],
            ],
        ], 200),
    ]);

    $data = Marketstack::eod()
        ->symbols('AAPL')
        ->json();

    expect($data)->toBeArray()
        ->and($data['data'])->toBeArray()
        ->and($data['data'][0]['symbol'])->toBe('AAPL');
});
