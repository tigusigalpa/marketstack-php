<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Marketstack API Key
    |--------------------------------------------------------------------------
    |
    | Your Marketstack API access key. You can obtain this from your
    | Marketstack dashboard at https://marketstack.com/dashboard
    |
    */
    'api_key' => env('MARKETSTACK_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the Marketstack API. Change this only if you need
    | to use a different endpoint (e.g., for testing purposes).
    |
    */
    'base_url' => env('MARKETSTACK_BASE_URL', 'http://api.marketstack.com/v1'),

    /*
    |--------------------------------------------------------------------------
    | Use HTTPS
    |--------------------------------------------------------------------------
    |
    | Whether to use HTTPS for API requests. Note that HTTPS is only
    | available for paid plans. Free plans must use HTTP.
    |
    */
    'use_https' => env('MARKETSTACK_USE_HTTPS', false),

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout in seconds for API requests.
    |
    */
    'timeout' => env('MARKETSTACK_TIMEOUT', 30),
];
