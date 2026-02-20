# Marketstack PHP - API Client for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tigusigalpa/marketstack-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/marketstack-php)
[![PHP Version](https://img.shields.io/packagist/php-v/tigusigalpa/marketstack-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/marketstack-php)
[![License](https://img.shields.io/packagist/l/tigusigalpa/marketstack-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/marketstack-php)

**Marketstack PHP** is a PHP client for the [Marketstack REST API](https://docs.apilayer.com/marketstack/docs/api-documentation), built with first-class support for the Laravel framework. It provides a convenient and flexible interface for integrating stock market data into your applications, whether you need real-time quotes, historical prices, or intraday data.

The package is designed for PHP 8.1+ and Laravel 10/11, providing a modern and developer-friendly toolkit.

## What is Marketstack?

[Marketstack](https://marketstack.com/) is a service that provides a REST API for accessing stock market data. It covers over 125,000 stock tickers from 72 global exchanges, including NYSE, NASDAQ, LSE, and more. This SDK simplifies the integration of Marketstack's financial data into your Laravel projects, such as trading platforms, portfolio trackers, and financial analytics tools.

## Key Features

*   **Fluent Interface:** An elegant, chainable syntax for writing clean and expressive code.
*   **Native Laravel Integration:** The package includes a service provider, facade, and configuration file, allowing you to get started with minimal setup.
*   **Type-Safe DTOs:** The use of Data Transfer Objects (DTOs) provides IDE autocompletion and improves code reliability.
*   **Fully Tested:** All package functionality is thoroughly tested using Pest.
*   **PSR-12 Compliant:** The code adheres to modern PHP standards.
*   **Multiple Response Formats:** Get data as Laravel Collections, DTOs, JSON, or a raw HTTP response.
*   **Error Handling:** Custom exceptions for convenient debugging.

## Quick Start

Getting stock market data takes just a few lines of code:

```php
use Tigusigalpa\Marketstack\Facades\Marketstack;

// Get the latest stock price for Apple
$stock = Marketstack::eod()->latest(\'AAPL\')->dto();
echo "AAPL closed at: $" . $stock->close;
```

## Installation

You can install the package via Composer:

```bash
composer require tigusigalpa/marketstack-php
```

### Publish Configuration

Publish the configuration file to customize its settings:

```bash
php artisan vendor:publish --tag=marketstack-config
```

This will create a `config/marketstack.php` file in your application.

### Environment Configuration

Add your Marketstack API key to your `.env` file:

```env
MARKETSTACK_API_KEY=your_api_key_here
MARKETSTACK_USE_HTTPS=false  # Set to true for paid plans
MARKETSTACK_TIMEOUT=30
```

> **Note**: HTTPS is only available for paid Marketstack plans. Free plans must use HTTP.

## Usage

The package provides a convenient interface for all Marketstack API endpoints.

### End-of-Day (EOD) Data

```php
// Get EOD data with a date range
$eodData = Marketstack::eod()
    ->symbols(\'AAPL\')
    ->dateFrom(\'2023-01-01\')
    ->dateTo(\'2023-12-31\')
    ->exchange(\'XNAS\')
    ->limit(100)
    ->collect();

// Get the latest EOD data for a ticker
$latest = Marketstack::eod()
    ->latest(\'AAPL\')
    ->dto();
```

### Intraday Data

```php
// Get intraday data with an interval
$intraday = Marketstack::intraday()
    ->symbols(\'TSLA\')
    ->interval(\'1h\')  // Options: 1min, 5min, 10min, 15min, 30min, 1hour
    ->dateFrom(\'2023-01-15\')
    ->collect();
```

### Tickers

```php
// Search for tickers
$searchResults = Marketstack::tickers()
    ->search(\'Apple\')
    ->collect();

// Get information for a specific ticker
$ticker = Marketstack::tickers()
    ->ticker(\'AAPL\')
    ->dto();
```

### Response Formats

The package supports multiple response formats:

```php
// Collection of DTOs (recommended)
$collection = Marketstack::eod()->symbols(\'AAPL\')->collect();

// Single DTO or null
$dto = Marketstack::eod()->latest(\'AAPL\')->dto();

// Raw JSON
$json = Marketstack::eod()->symbols(\'AAPL\')->json();

// Raw HTTP Response
$response = Marketstack::eod()->symbols(\'AAPL\')->get();
```

### Error Handling

The package throws a `MarketstackException` when an API request fails:

```php
use Tigusigalpa\Marketstack\Exceptions\MarketstackException;

try {
    $data = Marketstack::eod()->symbols(\'INVALID\')->collect();
} catch (MarketstackException $e) {
    echo "Error: {$e->getMessage()}";
}
```

## Testing

Run the tests:

```bash
composer test
```

Run tests with a coverage report:

```bash
composer test -- --coverage
```

## Requirements

- **PHP**: 8.1+
- **Laravel**: 10.x or 11.x
- **Marketstack API Key**: [Free or paid plan](https://marketstack.com/)

## Frequently Asked Questions

### Can I use this package without Laravel?

Yes! While optimized for Laravel, you can use the `MarketstackClient` class directly in any PHP 8.1+ project:

```php
$client = new \Tigusigalpa\Marketstack\MarketstackClient(\'your-api-key\');
$data = $client->eod()->symbols(\'AAPL\')->collect();
```

### How do I handle API rate limits?

The package throws a `MarketstackException` when rate limits are exceeded. You can implement retry logic or caching:

```php
use Illuminate\Support\Facades\Cache;

try {
    $data = Marketstack::eod()->symbols(\'AAPL\')->collect();
    Cache::put(\'aapl_price\', $data, now()->addMinutes(15));
} catch (MarketstackException $e) {
    $data = Cache::get(\'aapl_price\'); // Use cached data
}
```

## License

This package is open-source software licensed under the [MIT license](LICENSE).

## Support & Community

*   **GitHub Issues**: [Report a bug or request a feature](https://github.com/tigusigalpa/marketstack-php/issues)
*   **GitHub Discussions**: [Ask a question or share an idea](https://github.com/tigusigalpa/marketstack-php/discussions)

If you discover a security vulnerability, please send an email to [sovletig@gmail.com](mailto:sovletig@gmail.com).
