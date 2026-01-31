<?php

declare(strict_types=1);

namespace Tigusigalpa\Marketstack;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider for the Marketstack package.
 *
 * Registers the Marketstack client in the Laravel service container
 * and publishes the configuration file.
 */
class MarketstackServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/marketstack.php',
            'marketstack'
        );

        $this->app->singleton(MarketstackClient::class, function ($app) {
            $config = $app['config']['marketstack'];

            return new MarketstackClient(
                apiKey: $config['api_key'] ?? '',
                baseUrl: $config['base_url'] ?? null,
                timeout: $config['timeout'] ?? 30
            );
        });

        $this->app->alias(MarketstackClient::class, 'marketstack');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/marketstack.php' => config_path('marketstack.php'),
            ], 'marketstack-config');
        }
    }
}
