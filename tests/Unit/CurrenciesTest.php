<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Tigusigalpa\Marketstack\DTO\CurrencyData;
use Tigusigalpa\Marketstack\Facades\Marketstack;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('can fetch currencies', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                [
                    'code' => 'USD',
                    'symbol' => '$',
                    'name' => 'US Dollar',
                ],
            ],
        ], 200),
    ]);

    $data = Marketstack::currencies()
        ->collect();

    expect($data)->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($data->first())->toBeInstanceOf(CurrencyData::class)
        ->and($data->first()->code)->toBe('USD');
});

it('can fetch a specific currency by code', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                'code' => 'USD',
                'symbol' => '$',
                'name' => 'US Dollar',
            ],
        ], 200),
    ]);

    $data = Marketstack::currencies()
        ->code('USD')
        ->dto();

    expect($data)->toBeInstanceOf(CurrencyData::class)
        ->and($data->code)->toBe('USD')
        ->and($data->symbol)->toBe('$');
});

it('can paginate currencies', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['code' => 'USD', 'name' => 'US Dollar'],
                ['code' => 'EUR', 'name' => 'Euro'],
            ],
        ], 200),
    ]);

    $data = Marketstack::currencies()
        ->limit(2)
        ->offset(0)
        ->collect();

    expect($data->count())->toBe(2);
});
