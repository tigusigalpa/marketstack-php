<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Tigusigalpa\Marketstack\DTO\TimezoneData;
use Tigusigalpa\Marketstack\Facades\Marketstack;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('can fetch timezones', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                [
                    'timezone' => 'America/New_York',
                    'abbr' => 'EST',
                    'abbr_dst' => 'EDT',
                ],
            ],
        ], 200),
    ]);

    $data = Marketstack::timezones()
        ->collect();

    expect($data)->toBeInstanceOf(\Illuminate\Support\Collection::class)
        ->and($data->first())->toBeInstanceOf(TimezoneData::class)
        ->and($data->first()->timezone)->toBe('America/New_York');
});

it('can fetch a specific timezone', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                'timezone' => 'America/New_York',
                'abbr' => 'EST',
                'abbr_dst' => 'EDT',
            ],
        ], 200),
    ]);

    $data = Marketstack::timezones()
        ->timezone('America/New_York')
        ->dto();

    expect($data)->toBeInstanceOf(TimezoneData::class)
        ->and($data->timezone)->toBe('America/New_York')
        ->and($data->abbr)->toBe('EST');
});

it('can paginate timezones', function () {
    Http::fake([
        'api.marketstack.com/*' => Http::response([
            'data' => [
                ['timezone' => 'America/New_York', 'abbr' => 'EST'],
                ['timezone' => 'Europe/London', 'abbr' => 'GMT'],
            ],
        ], 200),
    ]);

    $data = Marketstack::timezones()
        ->limit(2)
        ->collect();

    expect($data->count())->toBe(2);
});
