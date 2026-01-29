# Shorthand Time

A simple PHP package for time unit conversions with an intuitive enum-based API.

[![CI](https://github.com/cleveregg-digital/shorthand-time/actions/workflows/ci.yml/badge.svg)](https://github.com/cleveregg-digital/shorthand-time/actions/workflows/ci.yml)

## Requirements

- PHP 8.2 or higher

## Installation

Install via Composer:

```bash
composer require cleveregg-digital/shorthand-time
```

## Usage

### Basic Conversions

Use the `TimeUnit` enum to convert between any time units:

```php
use CleverEggDigital\ShorthandTime\TimeUnit;

// Get conversion factors
TimeUnit::YEAR->in(TimeUnit::SECOND);     // 31536000
TimeUnit::SECOND->in(TimeUnit::YEAR);     // 3.1709791983765E-8
TimeUnit::YEAR->in(TimeUnit::YEAR);       // 1

// Multiply to convert values
$seconds = 2 * TimeUnit::YEAR->in(TimeUnit::SECOND);  // 63072000
$years = 63072000 * TimeUnit::SECOND->in(TimeUnit::YEAR);  // 2.0
```

### Converting Values Directly

Use the `convert()` method for cleaner syntax:

```php
TimeUnit::HOUR->convert(2, TimeUnit::MINUTE);      // 120
TimeUnit::WEEK->convert(1, TimeUnit::SECOND);      // 604800
TimeUnit::MINUTE->convert(30, TimeUnit::HOUR);     // 0.5
TimeUnit::DECADE->convert(5, TimeUnit::YEAR);      // 50
```

### Available Time Units

The following units are available, from smallest to largest:

| Unit | Description |
|------|-------------|
| `NANOSECOND` | 1 nanosecond |
| `MICROSECOND` | 1,000 nanoseconds |
| `MILLISECOND` | 1,000 microseconds |
| `SECOND` | 1,000 milliseconds |
| `MINUTE` | 60 seconds |
| `HOUR` | 60 minutes |
| `DAY` | 24 hours |
| `WEEK` | 7 days |
| `MONTH` | 30 days |
| `YEAR` | 365 days |
| `DECADE` | 10 years |
| `CENTURY` | 100 years |

### Real-World Examples

```php
// Cache TTL: 1 week in seconds
$ttl = TimeUnit::WEEK->in(TimeUnit::SECOND);  // 604800

// Timeout: 5 minutes in milliseconds
$timeout = 5 * TimeUnit::MINUTE->in(TimeUnit::MILLISECOND);  // 300000

// Performance timing: 500ms in microseconds
$threshold = 500 * TimeUnit::MILLISECOND->in(TimeUnit::MICROSECOND);  // 500000

// Session lifetime: 2 hours in seconds
$lifetime = TimeUnit::HOUR->convert(2, TimeUnit::SECOND);  // 7200
```

### Helper Methods

```php
// Get human-readable labels
TimeUnit::DAY->label();        // "day"
TimeUnit::DAY->label(true);    // "days"

// Get all available units
TimeUnit::cases();  // Array of all TimeUnit cases

// Get the complete conversion matrix (useful for debugging)
TimeUnit::conversionMatrix();  // 12x12 array of all conversion factors
```

### Creating from Strings

```php
$unit = TimeUnit::from('day');       // TimeUnit::DAY
$unit = TimeUnit::tryFrom('invalid'); // null
```

## Testing

Run the test suite:

```bash
composer test
```

Run tests with coverage (requires pcov or xdebug):

```bash
composer test:coverage
```

Run static analysis:

```bash
composer analyse
```

Run mutation testing:

```bash
composer infection
```

Run all CI checks:

```bash
composer ci
```

## Bug Reports

Found a bug? Please open an issue on GitHub:

[https://github.com/cleveregg-digital/shorthand-time/issues](https://github.com/cleveregg-digital/shorthand-time/issues)

When reporting a bug, please include:

1. PHP version (`php -v`)
2. Package version (`composer show cleveregg-digital/shorthand-time`)
3. Minimal code example that reproduces the issue
4. Expected vs actual behaviour

## Contributing

Contributions are welcome! Please follow these guidelines:

### Pull Request Protocol

1. **Fork the repository** and create your branch from `main`
2. **Write tests** for any new functionality or bug fixes
3. **Ensure all checks pass** before submitting:
   - `composer test` - All tests must pass
   - `composer analyse` - PHPStan level 9 with no errors
   - `composer test:coverage` - 100% code coverage required
   - `composer infection` - 100% mutation score required
4. **Follow existing code style** - The codebase uses strict types and PSR-12
5. **Write clear commit messages** describing the change
6. **Update documentation** if adding new features

### CI Requirements

All pull requests must pass the following automated checks:

| Check | Requirement |
|-------|-------------|
| **Tests** | All tests passing on PHP 8.2, 8.3, 8.4 |
| **PHPStan** | Level 9 with no errors |
| **Coverage** | 100% line coverage |
| **Mutation Testing** | 100% mutation score |

PRs that do not meet these requirements will not be merged.

### Development Setup

```bash
# Clone your fork
git clone https://github.com/YOUR_USERNAME/shorthand-time.git
cd shorthand-time

# Install dependencies
composer install

# Run checks before committing
composer ci
```

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).
