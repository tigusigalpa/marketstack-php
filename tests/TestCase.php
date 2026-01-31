<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Tigusigalpa\Marketstack\MarketstackServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            MarketstackServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Marketstack' => \Tigusigalpa\Marketstack\Facades\Marketstack::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('marketstack.api_key', 'test-api-key');
        $app['config']->set('marketstack.base_url', 'http://api.marketstack.com/v1');
        $app['config']->set('marketstack.timeout', 30);
    }
}
