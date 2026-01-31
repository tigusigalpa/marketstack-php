# Changelog

All notable changes to `marketstack-php` will be documented in this file.

## [1.0.0] - 2026-01-31

### Added
- Initial release
- Support for End-of-Day (EOD) data endpoint
- Support for Intraday data endpoint
- Support for Tickers endpoint
- Support for Exchanges endpoint
- Support for Currencies endpoint
- Support for Timezones endpoint
- Fluent interface for building API requests
- Data Transfer Objects (DTOs) for type-safe responses
- Laravel service provider and facade
- Comprehensive test suite with Pest
- Full PHPDoc documentation
- PSR-12 compliant code
- Configuration file with environment variable support
- HTTP/HTTPS support (based on plan type)
- Error handling with custom exceptions
- Collection support for multiple results
- Pagination support (limit/offset)
- Sorting and filtering capabilities
- Debug URL building

### Features
- **Fluent API**: Chain methods for clean, expressive code
- **Type Safety**: Strongly typed DTOs for all responses
- **Laravel Integration**: Native support with service provider and facade
- **Flexible Responses**: Get data as Collection, DTO, JSON, or raw Response
- **Comprehensive Testing**: Full test coverage with mocked HTTP responses
- **Developer Friendly**: Detailed documentation and examples

### Endpoints Implemented
1. `/eod` - End-of-Day data with date ranges, symbols, and exchanges
2. `/intraday` - Intraday data with intervals and real-time updates
3. `/tickers` - Stock ticker information with search and filtering
4. `/exchanges` - Exchange information with MIC code lookup
5. `/currencies` - Currency data and codes
6. `/timezones` - Timezone information for exchanges

### Methods Available
- Common: `symbols()`, `limit()`, `offset()`, `sort()`, `collect()`, `dto()`, `json()`, `get()`
- EOD: `dateFrom()`, `dateTo()`, `date()`, `latest()`, `exchange()`
- Intraday: `interval()`, `dateFrom()`, `dateTo()`, `latest()`, `exchange()`
- Tickers: `search()`, `exchange()`, `ticker()`
- Exchanges: `search()`, `mic()`, `tickers()`
- Currencies: `code()`
- Timezones: `timezone()`

## [Unreleased]

### Planned
- Support for splits endpoint
- Support for dividends endpoint
- Caching layer for API responses
- Rate limiting handling
- Batch request support
- WebSocket support for real-time data (if available in API)
