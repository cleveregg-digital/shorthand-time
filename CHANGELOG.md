# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2026-01-29

### Added
- Initial release
- `TimeUnit` enum with 12 time units: nanosecond, microsecond, millisecond, second, minute, hour, day, week, month, year, decade, century
- `in()` method for conversion factors between any two units
- `convert()` method for converting values between units
- `label()` method for human-readable unit names (singular/plural)
- `conversionMatrix()` static method for debugging/documentation
- Full test coverage with PHPUnit
- PHPStan level 9 compliance
- 100% mutation testing score with Infection

[Unreleased]: https://github.com/cleveregg-digital/shorthand-time/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/cleveregg-digital/shorthand-time/releases/tag/v1.0.0
