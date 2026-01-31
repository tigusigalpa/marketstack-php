<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Tigusigalpa\Marketstack\DTO\IntradayData;
use Tigusigalpa\Marketstack\Facades\Marketstack;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('can fetch intraday data with interval', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                [
                    'symbol' => 'TSLA',
                    'exchange' => 'XNAS',
                    'date' => '2023-01-31T15:30:00+0000',
                    'open' => 143.97,
                    'high' => 147.23,
                    'low' => 143.90,
                    'close' => 144.29,
                    'last' => 144.29,
                    'volume' => 1234567.0,
                ],
            ],
        ], 200),
    ]);

    $data = Marketstack::intraday()
        ->symbols('TSLA')
        ->interval('1h')
        ->collect();

    expect($data)->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($data->count())->toBe(1)
        ->and($data->first())->toBeInstanceOf(IntradayData::class)
        ->and($data->first()->symbol)->toBe('TSLA');
});

it('can fetch latest intraday data', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['symbol' => 'TSLA', 'last' => 144.29],
            ],
        ], 200),
    ]);

    $data = Marketstack::intraday()
        ->symbols('TSLA')
        ->latest()
        ->dto();

    expect($data)->toBeInstanceOf(IntradayData::class)
        ->and($data->symbol)->toBe('TSLA');
});

it('can fetch intraday data with date range', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['symbol' => 'TSLA', 'date' => '2023-01-15T10:00:00+0000'],
                ['symbol' => 'TSLA', 'date' => '2023-01-15T11:00:00+0000'],
            ],
        ], 200),
    ]);

    $data = Marketstack::intraday()
        ->symbols('TSLA')
        ->dateFrom('2023-01-15')
        ->dateTo('2023-01-15')
        ->interval('1h')
        ->collect();

    expect($data->count())->toBe(2);
});

it('can filter intraday data by exchange', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['symbol' => 'TSLA', 'exchange' => 'XNAS'],
            ],
        ], 200),
    ]);

    $data = Marketstack::intraday()
        ->symbols('TSLA')
        ->exchange('XNAS')
        ->interval('1h')
        ->collect();

    expect($data->first()->exchange)->toBe('XNAS');
});
