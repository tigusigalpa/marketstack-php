<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack\Facades;

use Illuminate\Support\Facades\Facade;
use Tigusigalpa\Marketstack\Endpoints\Currencies;
use Tigusigalpa\Marketstack\Endpoints\Eod;
use Tigusigalpa\Marketstack\Endpoints\Exchanges;
use Tigusigalpa\Marketstack\Endpoints\Intraday;
use Tigusigalpa\Marketstack\Endpoints\Tickers;
use Tigusigalpa\Marketstack\Endpoints\Timezones;

/**
 * Facade for the Marketstack client.
 *
 * @method static Eod eod()
 * @method static Intraday intraday()
 * @method static Tickers tickers()
 * @method static Exchanges exchanges()
 * @method static Currencies currencies()
 * @method static Timezones timezones()
 *
 * @see \Tigusigalpa\Marketstack\MarketstackClient
 */
class Marketstack extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'marketstack';
    }
}
