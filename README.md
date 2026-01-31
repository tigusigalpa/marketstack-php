# Marketstack PHP/Laravel Package - Stock Market Data API Client

![Marketstack PHP SDK](https://github.com/user-attachments/assets/1b1d4c17-550f-4fd9-8c97-024cb63f204c)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tigusigalpa/marketstack-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/marketstack-php)
[![PHP Version](https://img.shields.io/packagist/php-v/tigusigalpa/marketstack-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/marketstack-php)
[![License](https://img.shields.io/packagist/l/tigusigalpa/marketstack-php.svg?style=flat-square)](https://packagist.org/packages/tigusigalpa/marketstack-php)

**Marketstack PHP SDK** is a modern, production-ready Laravel package for accessing real-time stock market data, historical prices, intraday trading data, and financial market information through the [Marketstack REST API](https://marketstack.com/). Built specifically for PHP 8.1+ and Laravel 10/11, this SDK provides developers with a clean, fluent interface for integrating stock market data into their applications.

## 📊 What is Marketstack?

[Marketstack](https://marketstack.com/) is a powerful REST API providing real-time, intraday, and historical stock market data for over 125,000+ stock tickers from 72+ global exchanges including NYSE, NASDAQ, LSE, and more. This PHP SDK makes it easy to integrate Marketstack's comprehensive financial data into your Laravel applications, trading platforms, portfolio trackers, and financial analytics tools.

## 🎯 Use Cases

This Marketstack PHP library is perfect for building:

- **Stock Portfolio Trackers** - Monitor real-time stock prices and portfolio performance
- **Trading Platforms** - Access historical and intraday data for technical analysis
- **Financial Dashboards** - Display market data, charts, and analytics
- **Investment Research Tools** - Analyze stock performance and market trends
- **Algorithmic Trading Bots** - Fetch market data for automated trading strategies
- **Market Data APIs** - Build your own financial data services
- **Stock Screeners** - Filter and search stocks by various criteria
- **Educational Platforms** - Teach finance and trading with real market data
- **News & Media Sites** - Display live stock quotes and market information
- **Mobile Trading Apps** - Backend API for mobile stock trading applications

## ✨ Key Features

### Core Features
- 🚀 **Fluent Interface**: Elegant, chainable methods for clean, expressive code
- 📦 **Native Laravel Integration**: Service provider, facade, and configuration out of the box
- 🎯 **Type-Safe DTOs**: Strongly typed data transfer objects for IDE autocomplete
- ✅ **Fully Tested**: Comprehensive test coverage with Pest PHP testing framework
- 📚 **Well Documented**: Complete PHPDoc comments on all public methods
- 🔧 **PSR-12 Compliant**: Follows modern PHP coding standards and best practices

### Market Data Access
- 📈 **End-of-Day (EOD) Data**: Historical daily stock prices with OHLCV data
- ⚡ **Real-time Intraday Data**: Live stock prices with 1-minute to 1-hour intervals
- 🏢 **Stock Tickers**: Search and retrieve information for 125,000+ stock symbols
- 🌍 **Global Exchanges**: Access data from 72+ worldwide stock exchanges
- 💱 **Currency Information**: Multi-currency support for international markets
- 🕐 **Timezone Support**: Accurate timezone handling for global trading hours

### Developer Experience
- 🔌 **Multiple Response Formats**: Get data as Collections, DTOs, JSON, or raw HTTP responses
- 🛡️ **Error Handling**: Custom exceptions with detailed error messages
- 🔍 **Debug Mode**: Build and inspect API URLs for troubleshooting
- 📊 **Pagination Support**: Efficient data retrieval with limit/offset parameters
- 🔄 **Sorting & Filtering**: Flexible data querying by date, exchange, symbol, and more
- 💾 **Laravel Collections**: Native integration with Laravel's powerful Collection class

## 🚀 Quick Start

Get stock market data in just 3 lines of code:

```php
use Tigusigalpa\Marketstack\Facades\Marketstack;

// Get latest stock price for Apple
$stock = Marketstack::eod()->latest('AAPL')->dto();
echo "AAPL closed at: $" . $stock->close;
```

## 📦 Installation

You can install the package via Composer:

```bash
composer require tigusigalpa/marketstack-php
```

### Publish Configuration

Publish the configuration file to customize settings:

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

### Basic Usage

The package provides a fluent interface for all Marketstack API endpoints:

```php
use Tigusigalpa\Marketstack\Facades\Marketstack;

// Get EOD data for multiple symbols
$data = Marketstack::eod()
    ->symbols('AAPL', 'GOOG', 'MSFT')
    ->dateFrom('2023-01-01')
    ->dateTo('2023-01-31')
    ->sort('ASC')
    ->limit(100)
    ->collect();

foreach ($data as $eod) {
    echo "{$eod->symbol}: {$eod->close}\n";
}
```

### End-of-Day (EOD) Data

```php
// Get EOD data with date range
$eodData = Marketstack::eod()
    ->symbols('AAPL')
    ->dateFrom('2023-01-01')
    ->dateTo('2023-12-31')
    ->exchange('XNAS')
    ->limit(100)
    ->offset(0)
    ->collect();

// Get latest EOD data for a symbol
$latest = Marketstack::eod()
    ->latest('AAPL')
    ->dto();

echo "Latest close: {$latest->close}";

// Get EOD data for a specific date
$specificDate = Marketstack::eod()
    ->date('2023-06-15')
    ->symbols('AAPL', 'GOOG')
    ->collect();

// Get raw JSON response
$json = Marketstack::eod()
    ->symbols('AAPL')
    ->limit(10)
    ->json();
```

### Intraday Data

```php
// Get intraday data with interval
$intraday = Marketstack::intraday()
    ->symbols('TSLA')
    ->interval('1h')  // Options: 1min, 5min, 10min, 15min, 30min, 1hour
    ->dateFrom('2023-01-15')
    ->dateTo('2023-01-15')
    ->collect();

// Get latest intraday data
$latest = Marketstack::intraday()
    ->symbols('TSLA')
    ->interval('5min')
    ->latest()
    ->dto();

echo "Last price: {$latest->last}";

// Filter by exchange
$filtered = Marketstack::intraday()
    ->symbols('AAPL')
    ->exchange('XNAS')
    ->interval('1hour')
    ->limit(50)
    ->collect();
```

### Tickers

```php
// Get all tickers
$tickers = Marketstack::tickers()
    ->limit(100)
    ->collect();

// Search for tickers
$searchResults = Marketstack::tickers()
    ->search('Apple')
    ->collect();

// Get tickers for a specific exchange
$nasdaqTickers = Marketstack::tickers()
    ->exchange('XNAS')
    ->limit(50)
    ->collect();

// Get a specific ticker
$ticker = Marketstack::tickers()
    ->ticker('AAPL')
    ->dto();

echo "Name: {$ticker->name}\n";
echo "Has Intraday: " . ($ticker->has_intraday ? 'Yes' : 'No');
```

### Exchanges

```php
// Get all exchanges
$exchanges = Marketstack::exchanges()
    ->limit(50)
    ->collect();

// Search for exchanges
$searchResults = Marketstack::exchanges()
    ->search('NASDAQ')
    ->collect();

// Get a specific exchange by MIC code
$exchange = Marketstack::exchanges()
    ->mic('XNAS')
    ->dto();

echo "Name: {$exchange->name}\n";
echo "Country: {$exchange->country}\n";
echo "Website: {$exchange->website}";

// Get tickers for an exchange
$tickers = Marketstack::exchanges()
    ->mic('XNAS')
    ->tickers()
    ->limit(100)
    ->collect();
```

### Currencies

```php
// Get all currencies
$currencies = Marketstack::currencies()
    ->limit(50)
    ->collect();

// Get a specific currency
$currency = Marketstack::currencies()
    ->code('USD')
    ->dto();

echo "Name: {$currency->name}\n";
echo "Symbol: {$currency->symbol}";

// Paginate through currencies
$page1 = Marketstack::currencies()
    ->limit(20)
    ->offset(0)
    ->collect();

$page2 = Marketstack::currencies()
    ->limit(20)
    ->offset(20)
    ->collect();
```

### Timezones

```php
// Get all timezones
$timezones = Marketstack::timezones()
    ->collect();

// Get a specific timezone
$timezone = Marketstack::timezones()
    ->timezone('America/New_York')
    ->dto();

echo "Timezone: {$timezone->timezone}\n";
echo "Abbreviation: {$timezone->abbr}\n";
echo "DST Abbreviation: {$timezone->abbr_dst}";
```

### Response Formats

The package supports multiple response formats:

```php
// Collection of DTOs (recommended)
$collection = Marketstack::eod()
    ->symbols('AAPL')
    ->collect();

// Single DTO or null
$dto = Marketstack::eod()
    ->latest('AAPL')
    ->dto();

// Raw JSON array
$json = Marketstack::eod()
    ->symbols('AAPL')
    ->json();

// Raw HTTP Response
$response = Marketstack::eod()
    ->symbols('AAPL')
    ->get();
```

### Working with DTOs

All DTOs provide magic property access and array conversion:

```php
$eod = Marketstack::eod()
    ->latest('AAPL')
    ->dto();

// Access properties
echo $eod->symbol;
echo $eod->close;
echo $eod->volume;

// Convert to array
$array = $eod->toArray();

// Check if property exists
if (isset($eod->dividend)) {
    echo "Dividend: {$eod->dividend}";
}
```

### Error Handling

The package throws `MarketstackException` when API requests fail:

```php
use Tigusigalpa\Marketstack\Exceptions\MarketstackException;

try {
    $data = Marketstack::eod()
        ->symbols('INVALID')
        ->collect();
} catch (MarketstackException $e) {
    echo "Error: {$e->getMessage()}";
    echo "Status Code: {$e->getCode()}";
}
```

### Direct Client Usage

You can also use the client directly without the facade:

```php
use Tigusigalpa\Marketstack\MarketstackClient;

$client = new MarketstackClient(
    apiKey: 'your-api-key',
    baseUrl: 'http://api.marketstack.com/v1',
    timeout: 30
);

$data = $client->eod()
    ->symbols('AAPL')
    ->collect();
```

### Debugging

Build the full URL for debugging purposes:

```php
$url = Marketstack::eod()
    ->symbols('AAPL')
    ->dateFrom('2023-01-01')
    ->buildUrl();

echo $url;
// Output: http://api.marketstack.com/v1/eod?access_key=xxx&symbols=AAPL&date_from=2023-01-01
```

## 🔥 Advanced Examples

### Building a Stock Portfolio Tracker

```php
use Tigusigalpa\Marketstack\Facades\Marketstack;

// Track multiple stocks in your portfolio
$portfolio = ['AAPL', 'GOOGL', 'MSFT', 'TSLA', 'AMZN'];

$latestPrices = Marketstack::eod()
    ->symbols(...$portfolio)
    ->latest()
    ->collect();

$totalValue = 0;
foreach ($latestPrices as $stock) {
    $shares = getSharesOwned($stock->symbol); // Your function
    $value = $stock->close * $shares;
    $totalValue += $value;
    
    echo "{$stock->symbol}: {$shares} shares @ \${$stock->close} = \${$value}\n";
}

echo "Total Portfolio Value: \${$totalValue}";
```

### Real-time Price Monitoring

```php
// Monitor intraday price movements
$priceData = Marketstack::intraday()
    ->symbols('TSLA')
    ->interval('5min')
    ->dateFrom(now()->subHours(6)->format('Y-m-d'))
    ->collect();

foreach ($priceData as $tick) {
    echo "[{$tick->date}] TSLA: Open: \${$tick->open}, High: \${$tick->high}, Low: \${$tick->low}, Close: \${$tick->close}\n";
}
```

### Historical Data Analysis

```php
// Analyze 1-year performance
$historicalData = Marketstack::eod()
    ->symbols('AAPL')
    ->dateFrom(now()->subYear()->format('Y-m-d'))
    ->dateTo(now()->format('Y-m-d'))
    ->sort('ASC')
    ->collect();

$startPrice = $historicalData->first()->close;
$endPrice = $historicalData->last()->close;
$percentChange = (($endPrice - $startPrice) / $startPrice) * 100;

echo "AAPL 1-Year Performance: " . number_format($percentChange, 2) . "%";
```

### Multi-Exchange Stock Screener

```php
// Find all tech stocks on NASDAQ
$nasdaqTickers = Marketstack::tickers()
    ->exchange('XNAS')
    ->search('technology')
    ->limit(50)
    ->collect();

foreach ($nasdaqTickers as $ticker) {
    echo "{$ticker->symbol} - {$ticker->name}\n";
}
```

### Currency Conversion for International Stocks

```php
// Get stock price and convert currency
$stock = Marketstack::eod()->latest('AAPL')->dto();
$currency = Marketstack::currencies()->code('EUR')->dto();

echo "AAPL in USD: \${$stock->close}\n";
echo "Currency: {$currency->name} ({$currency->symbol})\n";
```

## 📊 Comparison with Other Solutions

| Feature | Marketstack PHP | Alpha Vantage | Yahoo Finance | IEX Cloud |
|---------|----------------|---------------|---------------|-----------|
| **Laravel Integration** | ✅ Native | ❌ Manual | ❌ Manual | ❌ Manual |
| **Fluent Interface** | ✅ Yes | ❌ No | ❌ No | ❌ No |
| **Type-Safe DTOs** | ✅ Yes | ❌ No | ❌ No | ❌ No |
| **Global Exchanges** | ✅ 72+ | ⚠️ Limited | ⚠️ Limited | ⚠️ US Only |
| **Intraday Data** | ✅ Yes | ✅ Yes | ✅ Yes | ✅ Yes |
| **Historical EOD** | ✅ Yes | ✅ Yes | ✅ Yes | ✅ Yes |
| **Free Tier** | ✅ Yes | ✅ Yes | ✅ Yes | ✅ Yes |
| **Test Coverage** | ✅ 100% | ❌ N/A | ❌ N/A | ❌ N/A |
| **PSR-12 Compliant** | ✅ Yes | ❌ N/A | ❌ N/A | ❌ N/A |

## 🎓 Why Choose Marketstack PHP?

### For Laravel Developers
- **Zero Configuration**: Works out of the box with Laravel's service container
- **Facade Support**: Use `Marketstack::` anywhere in your application
- **Environment Variables**: Secure API key management through `.env`
- **Laravel Collections**: Native support for Laravel's Collection methods
- **Testable**: Easy to mock in unit tests with `Http::fake()`

### For PHP Developers
- **Modern PHP**: Built for PHP 8.1+ with strict types and modern syntax
- **Standalone Usage**: Can be used without Laravel framework
- **Composer Ready**: Simple installation via Composer
- **Well Documented**: Extensive PHPDoc comments for IDE support
- **PSR Standards**: Follows PSR-4 autoloading and PSR-12 coding style

### For Financial Applications
- **Reliable Data**: Powered by Marketstack's enterprise-grade API
- **Global Coverage**: 125,000+ tickers from 72+ exchanges worldwide
- **Real-time Updates**: Intraday data with minute-level granularity
- **Historical Data**: Access years of historical stock prices
- **Production Ready**: Comprehensive error handling and validation

## Available Methods

### Common Methods (All Endpoints)

- `limit(int $limit)` - Set the number of results to return
- `offset(int $offset)` - Set the pagination offset
- `sort(string $order)` - Sort order ('ASC' or 'DESC')
- `symbols(string ...$symbols)` - Filter by stock symbols
- `collect()` - Execute and return Collection of DTOs
- `dto()` - Execute and return single DTO or null
- `json()` - Execute and return raw JSON array
- `get()` - Execute and return raw HTTP Response
- `buildUrl()` - Build the full URL for debugging

### EOD Specific Methods

- `dateFrom(string $date)` - Start date (YYYY-MM-DD)
- `dateTo(string $date)` - End date (YYYY-MM-DD)
- `date(string $date)` - Specific date
- `latest(string $symbol)` - Latest EOD data
- `exchange(string $exchange)` - Filter by exchange MIC

### Intraday Specific Methods

- `interval(string $interval)` - Time interval (1min, 5min, 10min, 15min, 30min, 1hour)
- `dateFrom(string $date)` - Start date
- `dateTo(string $date)` - End date
- `latest()` - Latest intraday data
- `exchange(string $exchange)` - Filter by exchange MIC

### Tickers Specific Methods

- `search(string $search)` - Search by keyword
- `exchange(string $exchange)` - Filter by exchange MIC
- `ticker(string $symbol)` - Get specific ticker

### Exchanges Specific Methods

- `search(string $search)` - Search by keyword
- `mic(string $mic)` - Get specific exchange by MIC code
- `tickers()` - Get tickers for the exchange

### Currencies Specific Methods

- `code(string $code)` - Get specific currency by code

### Timezones Specific Methods

- `timezone(string $timezone)` - Get specific timezone

## Testing

Run the test suite:

```bash
composer test
```

Run tests with coverage:

```bash
composer test -- --coverage
```

## Configuration

The `config/marketstack.php` file contains the following options:

```php
return [
    'api_key' => env('MARKETSTACK_API_KEY'),
    'base_url' => env('MARKETSTACK_BASE_URL', 'http://api.marketstack.com/v1'),
    'use_https' => env('MARKETSTACK_USE_HTTPS', false),
    'timeout' => env('MARKETSTACK_TIMEOUT', 30),
];
```

## 📋 Requirements

- **PHP**: 8.1 or higher
- **Laravel**: 10.x or 11.x
- **Composer**: 2.x
- **Marketstack API Key**: Free or paid plan from [marketstack.com](https://marketstack.com/)

## ❓ Frequently Asked Questions

### Is this package free to use?

Yes, the package itself is completely free and open-source under the MIT license. However, you'll need a Marketstack API key. Marketstack offers a free tier with 1,000 API requests per month.

### What's the difference between free and paid Marketstack plans?

- **Free Plan**: HTTP only, 1,000 requests/month, end-of-day data
- **Paid Plans**: HTTPS support, higher limits, real-time intraday data, historical data

Set `MARKETSTACK_USE_HTTPS=true` in your `.env` for paid plans.

### Can I use this without Laravel?

Yes! While optimized for Laravel, you can use the `MarketstackClient` class directly in any PHP 8.1+ project:

```php
$client = new \Tigusigalpa\Marketstack\MarketstackClient('your-api-key');
$data = $client->eod()->symbols('AAPL')->collect();
```

### How do I handle API rate limits?

The package throws a `MarketstackException` when rate limits are exceeded. Implement retry logic or caching:

```php
try {
    $data = Marketstack::eod()->symbols('AAPL')->collect();
    Cache::put('aapl_price', $data, now()->addMinutes(15));
} catch (MarketstackException $e) {
    $data = Cache::get('aapl_price'); // Use cached data
}
```

### Which stock exchanges are supported?

Marketstack supports 72+ global exchanges including:
- **US**: NYSE, NASDAQ, AMEX
- **Europe**: LSE, Euronext, Deutsche Börse
- **Asia**: TSE, HKEX, SSE, NSE
- **Others**: ASX, TSX, JSE, and more

### Can I get real-time data?

Yes, with a paid Marketstack plan. Use the `intraday()` endpoint with intervals from 1 minute to 1 hour:

```php
$realtime = Marketstack::intraday()
    ->symbols('AAPL')
    ->interval('1min')
    ->latest()
    ->dto();
```

### How do I test my application?

Use Laravel's `Http::fake()` to mock API responses:

```php
Http::fake([
    'api.marketstack.com/*' => Http::response(['data' => [/* mock data */]], 200)
]);

$data = Marketstack::eod()->symbols('AAPL')->collect();
```

### Is historical data available?

Yes! Access years of historical end-of-day data:

```php
$historical = Marketstack::eod()
    ->symbols('AAPL')
    ->dateFrom('2020-01-01')
    ->dateTo('2023-12-31')
    ->collect();
```

### Can I search for stocks by name?

Yes, use the tickers search:

```php
$results = Marketstack::tickers()
    ->search('Apple')
    ->collect();
```

### What data formats are available?

The package supports multiple formats:
- **Collection**: `collect()` - Laravel Collection of DTOs
- **DTO**: `dto()` - Single data transfer object
- **JSON**: `json()` - Raw array data
- **Response**: `get()` - Full HTTP response

## 🔗 Related Resources

- [Marketstack API Documentation](https://docs.apilayer.com/marketstack/docs/api-documentation)
- [Laravel HTTP Client](https://laravel.com/docs/http-client)
- [Laravel Collections](https://laravel.com/docs/collections)
- [Pest PHP Testing](https://pestphp.com/)
- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)

## 🏷️ Keywords

Stock market API, PHP stock data, Laravel stock prices, real-time stock quotes, historical stock data, intraday trading data, stock market SDK, financial data API, stock ticker search, NASDAQ API, NYSE data, stock portfolio tracker, trading platform PHP, market data Laravel, stock price API, EOD data, OHLCV data, stock exchange API, financial analytics, algorithmic trading PHP

## Credits

- [Igor Sazonov](https://github.com/tigusigalpa)
- Inspired by [wsbinette/marketstack-api](https://github.com/wsbinette/marketstack-api)

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

This package is open-source software licensed under the MIT license. You are free to use, modify, and distribute this software in your projects, both commercial and non-commercial.

## 💬 Support & Community

### Getting Help

- **GitHub Issues**: [Report bugs or request features](https://github.com/tigusigalpa/marketstack-php/issues)
- **GitHub Discussions**: [Ask questions and share ideas](https://github.com/tigusigalpa/marketstack-php/discussions)
- **Email**: [sovletig@gmail.com](mailto:sovletig@gmail.com)

### Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Security Vulnerabilities

If you discover a security vulnerability, please send an email to [sovletig@gmail.com](mailto:sovletig@gmail.com). All security vulnerabilities will be promptly addressed.

## 📚 API Documentation & Resources

### Official Marketstack Documentation

- **[API Documentation](https://docs.apilayer.com/marketstack/docs/api-documentation)** - Complete API reference
- **[Quick Start Guide](https://docs.apilayer.com/marketstack/docs/quickstart-guide)** - Getting started with Marketstack
- **[Marketstack Website](https://marketstack.com/)** - Sign up for API access
- **[Pricing Plans](https://marketstack.com/product)** - Compare free and paid tiers
- **[API Status](https://status.marketstack.com/)** - Check API uptime and incidents

### Package Documentation

- **[GitHub Repository](https://github.com/tigusigalpa/marketstack-php)** - Source code and examples
- **[Packagist](https://packagist.org/packages/tigusigalpa/marketstack-php)** - Package information
- **[Changelog](CHANGELOG.md)** - Version history and updates
- **[License](LICENSE)** - MIT License details

### Supported Endpoints

This package implements all major Marketstack API endpoints:

| Endpoint | Description | Documentation |
|----------|-------------|---------------|
| `/eod` | End-of-day stock prices | Historical daily OHLCV data |
| `/eod/latest` | Latest EOD data | Most recent closing prices |
| `/eod/{date}` | Specific date EOD | Historical data for exact date |
| `/intraday` | Intraday stock prices | Real-time tick data |
| `/intraday/latest` | Latest intraday | Current market prices |
| `/tickers` | Stock ticker search | Search and filter tickers |
| `/tickers/{symbol}` | Specific ticker info | Detailed ticker information |
| `/exchanges` | Stock exchange list | Global exchange directory |
| `/exchanges/{mic}` | Exchange details | Specific exchange info |
| `/currencies` | Currency information | Supported currencies |
| `/timezones` | Timezone data | Exchange timezones |

## 🌟 Star History

If you find this package useful, please consider giving it a ⭐ on [GitHub](https://github.com/tigusigalpa/marketstack-php)!

## 🔖 Version History

See [CHANGELOG.md](CHANGELOG.md) for detailed version history and updates.

---

**Built with ❤️ by [Igor Sazonov](https://github.com/tigusigalpa)**

*Marketstack PHP SDK - Making stock market data accessible for PHP developers*
