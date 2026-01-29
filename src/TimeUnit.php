<?php

declare(strict_types=1);

namespace CleverEggDigital\ShorthandTime;

/**
 * Time unit enum with full conversion matrix support.
 *
 * Usage:
 *   TimeUnit::YEAR->in(TimeUnit::SECOND)  // Returns 31536000 (seconds in a year)
 *   TimeUnit::SECOND->in(TimeUnit::YEAR)  // Returns ~3.17e-8 (years in a second)
 *   TimeUnit::YEAR->in(TimeUnit::YEAR)    // Returns 1
 *
 * Multiply your value by the conversion factor:
 *   $seconds = 2 * TimeUnit::YEAR->in(TimeUnit::SECOND);  // 2 years in seconds
 *   $years = 63072000 * TimeUnit::SECOND->in(TimeUnit::YEAR);  // seconds to years
 */
enum TimeUnit: string
{
    case NANOSECOND = 'nanosecond';
    case MICROSECOND = 'microsecond';
    case MILLISECOND = 'millisecond';
    case SECOND = 'second';
    case MINUTE = 'minute';
    case HOUR = 'hour';
    case DAY = 'day';
    case WEEK = 'week';
    case MONTH = 'month';
    case YEAR = 'year';
    case DECADE = 'decade';
    case CENTURY = 'century';

    /**
     * Get the base value in nanoseconds for this unit.
     * Uses standard conversions:
     * - Month = 30 days
     * - Year = 365 days
     */
    private function toNanoseconds(): int
    {
        return match ($this) {
            self::NANOSECOND => 1,
            self::MICROSECOND => 1_000,
            self::MILLISECOND => 1_000_000,
            self::SECOND => 1_000_000_000,
            self::MINUTE => 60 * 1_000_000_000,
            self::HOUR => 3_600 * 1_000_000_000,
            self::DAY => 86_400 * 1_000_000_000,
            self::WEEK => 604_800 * 1_000_000_000,
            self::MONTH => 2_592_000 * 1_000_000_000,
            self::YEAR => 31_536_000 * 1_000_000_000,
            self::DECADE => 315_360_000 * 1_000_000_000,
            self::CENTURY => 3_153_600_000 * 1_000_000_000,
        };
    }

    /**
     * Convert this unit to another unit.
     * Returns how many of the target unit equal one of this unit.
     *
     * Example: TimeUnit::YEAR->in(TimeUnit::DAY) returns 365
     * Because 1 year = 365 days
     *
     * @param TimeUnit $target The unit to convert to
     * @return int|float The conversion factor (int when exact, float otherwise)
     */
    public function in(TimeUnit $target): int|float
    {
        if ($this === $target) {
            return 1;
        }

        $thisNs = $this->toNanoseconds();
        $targetNs = $target->toNanoseconds();

        // PHP returns int for exact division, float otherwise
        return $thisNs / $targetNs;
    }

    /**
     * Convert a value from this unit to another unit.
     *
     * Example: TimeUnit::HOUR->convert(2, TimeUnit::MINUTE) returns 120
     * Because 2 hours = 120 minutes
     *
     * @param int|float $value The value to convert
     * @param TimeUnit $target The unit to convert to
     * @return int|float The converted value
     */
    public function convert(int|float $value, TimeUnit $target): int|float
    {
        $result = $value * $this->in($target);

        // Return int if the result is a whole number
        if (is_float($result) && floor($result) === $result && $result <= PHP_INT_MAX && $result >= PHP_INT_MIN) {
            return (int) $result;
        }

        return $result;
    }

    /**
     * Get a human-readable label for this unit.
     *
     * @param bool $plural Whether to return the plural form
     * @return string The label
     */
    public function label(bool $plural = false): string
    {
        return match ($this) {
            self::NANOSECOND => $plural ? 'nanoseconds' : 'nanosecond',
            self::MICROSECOND => $plural ? 'microseconds' : 'microsecond',
            self::MILLISECOND => $plural ? 'milliseconds' : 'millisecond',
            self::SECOND => $plural ? 'seconds' : 'second',
            self::MINUTE => $plural ? 'minutes' : 'minute',
            self::HOUR => $plural ? 'hours' : 'hour',
            self::DAY => $plural ? 'days' : 'day',
            self::WEEK => $plural ? 'weeks' : 'week',
            self::MONTH => $plural ? 'months' : 'month',
            self::YEAR => $plural ? 'years' : 'year',
            self::DECADE => $plural ? 'decades' : 'decade',
            self::CENTURY => $plural ? 'centuries' : 'century',
        };
    }

    /**
     * Get the complete conversion matrix as an associative array.
     * Useful for debugging or generating documentation.
     *
     * @return array<string, array<string, int|float>>
     */
    public static function conversionMatrix(): array
    {
        $matrix = [];

        foreach (self::cases() as $from) {
            $matrix[$from->value] = [];
            foreach (self::cases() as $to) {
                $matrix[$from->value][$to->value] = $from->in($to);
            }
        }

        return $matrix;
    }
}
