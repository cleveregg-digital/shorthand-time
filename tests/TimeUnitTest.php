<?php

declare(strict_types=1);

namespace CleverEggDigital\ShorthandTime\Tests;

use CleverEggDigital\ShorthandTime\TimeUnit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TimeUnit::class)]
final class TimeUnitTest extends TestCase
{
    // =========================================================================
    // Self-conversions (unit->in(same unit) = 1)
    // =========================================================================

    #[Test]
    #[DataProvider('allUnitsProvider')]
    public function selfConversionReturnsOne(TimeUnit $unit): void
    {
        $this->assertSame(1, $unit->in($unit));
    }

    /**
     * @return array<string, array{TimeUnit}>
     */
    public static function allUnitsProvider(): array
    {
        return [
            'nanosecond' => [TimeUnit::NANOSECOND],
            'microsecond' => [TimeUnit::MICROSECOND],
            'millisecond' => [TimeUnit::MILLISECOND],
            'second' => [TimeUnit::SECOND],
            'minute' => [TimeUnit::MINUTE],
            'hour' => [TimeUnit::HOUR],
            'day' => [TimeUnit::DAY],
            'week' => [TimeUnit::WEEK],
            'month' => [TimeUnit::MONTH],
            'year' => [TimeUnit::YEAR],
            'decade' => [TimeUnit::DECADE],
            'century' => [TimeUnit::CENTURY],
        ];
    }

    // =========================================================================
    // Nanosecond and Microsecond conversions
    // =========================================================================

    #[Test]
    public function microsecondInNanosecondsReturnsThousand(): void
    {
        $this->assertSame(1000, TimeUnit::MICROSECOND->in(TimeUnit::NANOSECOND));
    }

    #[Test]
    public function millisecondInMicrosecondsReturnsThousand(): void
    {
        $this->assertSame(1000, TimeUnit::MILLISECOND->in(TimeUnit::MICROSECOND));
    }

    #[Test]
    public function millisecondInNanosecondsReturnsMillion(): void
    {
        $this->assertSame(1_000_000, TimeUnit::MILLISECOND->in(TimeUnit::NANOSECOND));
    }

    #[Test]
    public function secondInNanosecondsReturnsBillion(): void
    {
        $this->assertSame(1_000_000_000, TimeUnit::SECOND->in(TimeUnit::NANOSECOND));
    }

    #[Test]
    public function secondInMicrosecondsReturnsMillion(): void
    {
        $this->assertSame(1_000_000, TimeUnit::SECOND->in(TimeUnit::MICROSECOND));
    }

    #[Test]
    public function nanosecondInMicrosecondsReturnsFloat(): void
    {
        $this->assertSame(0.001, TimeUnit::NANOSECOND->in(TimeUnit::MICROSECOND));
    }

    #[Test]
    public function nanosecondInMillisecondsReturnsFloat(): void
    {
        $this->assertSame(0.000001, TimeUnit::NANOSECOND->in(TimeUnit::MILLISECOND));
    }

    #[Test]
    public function microsecondInMillisecondsReturnsFloat(): void
    {
        $this->assertSame(0.001, TimeUnit::MICROSECOND->in(TimeUnit::MILLISECOND));
    }

    // =========================================================================
    // Conversion to smaller units (integer results)
    // =========================================================================

    #[Test]
    public function secondInMillisecondsReturnsThousand(): void
    {
        $this->assertSame(1000, TimeUnit::SECOND->in(TimeUnit::MILLISECOND));
    }

    #[Test]
    public function minuteInSecondsReturnsSixty(): void
    {
        $this->assertSame(60, TimeUnit::MINUTE->in(TimeUnit::SECOND));
    }

    #[Test]
    public function hourInMinutesReturnsSixty(): void
    {
        $this->assertSame(60, TimeUnit::HOUR->in(TimeUnit::MINUTE));
    }

    #[Test]
    public function dayInHoursReturnsTwentyFour(): void
    {
        $this->assertSame(24, TimeUnit::DAY->in(TimeUnit::HOUR));
    }

    #[Test]
    public function weekInDaysReturnsSeven(): void
    {
        $this->assertSame(7, TimeUnit::WEEK->in(TimeUnit::DAY));
    }

    #[Test]
    public function monthInDaysReturnsThirty(): void
    {
        $this->assertSame(30, TimeUnit::MONTH->in(TimeUnit::DAY));
    }

    #[Test]
    public function yearInDaysReturns365(): void
    {
        $this->assertSame(365, TimeUnit::YEAR->in(TimeUnit::DAY));
    }

    #[Test]
    public function yearInSecondsReturnsCorrectValue(): void
    {
        $this->assertSame(31_536_000, TimeUnit::YEAR->in(TimeUnit::SECOND));
    }

    #[Test]
    public function yearInMillisecondsReturnsCorrectValue(): void
    {
        $this->assertSame(31_536_000_000, TimeUnit::YEAR->in(TimeUnit::MILLISECOND));
    }

    #[Test]
    public function yearInMinutesReturnsCorrectValue(): void
    {
        $this->assertSame(525_600, TimeUnit::YEAR->in(TimeUnit::MINUTE));
    }

    #[Test]
    public function yearInHoursReturnsCorrectValue(): void
    {
        $this->assertSame(8760, TimeUnit::YEAR->in(TimeUnit::HOUR));
    }

    #[Test]
    public function weekInHoursReturnsCorrectValue(): void
    {
        $this->assertSame(168, TimeUnit::WEEK->in(TimeUnit::HOUR));
    }

    #[Test]
    public function monthInHoursReturnsCorrectValue(): void
    {
        $this->assertSame(720, TimeUnit::MONTH->in(TimeUnit::HOUR));
    }

    #[Test]
    public function dayInSecondsReturnsCorrectValue(): void
    {
        $this->assertSame(86_400, TimeUnit::DAY->in(TimeUnit::SECOND));
    }

    #[Test]
    public function dayInMillisecondsReturnsCorrectValue(): void
    {
        $this->assertSame(86_400_000, TimeUnit::DAY->in(TimeUnit::MILLISECOND));
    }

    // =========================================================================
    // Decade and Century conversions
    // =========================================================================

    #[Test]
    public function decadeInYearsReturnsTen(): void
    {
        $this->assertSame(10, TimeUnit::DECADE->in(TimeUnit::YEAR));
    }

    #[Test]
    public function centuryInYearsReturnsHundred(): void
    {
        $this->assertSame(100, TimeUnit::CENTURY->in(TimeUnit::YEAR));
    }

    #[Test]
    public function centuryInDecadesReturnsTen(): void
    {
        $this->assertSame(10, TimeUnit::CENTURY->in(TimeUnit::DECADE));
    }

    #[Test]
    public function decadeInDaysReturns3650(): void
    {
        $this->assertSame(3650, TimeUnit::DECADE->in(TimeUnit::DAY));
    }

    #[Test]
    public function centuryInDaysReturns36500(): void
    {
        $this->assertSame(36500, TimeUnit::CENTURY->in(TimeUnit::DAY));
    }

    #[Test]
    public function centuryInSecondsReturnsCorrectValue(): void
    {
        $this->assertSame(3_153_600_000, TimeUnit::CENTURY->in(TimeUnit::SECOND));
    }

    #[Test]
    public function yearInDecadesReturnsFloat(): void
    {
        $this->assertSame(0.1, TimeUnit::YEAR->in(TimeUnit::DECADE));
    }

    #[Test]
    public function yearInCenturiesReturnsFloat(): void
    {
        $this->assertSame(0.01, TimeUnit::YEAR->in(TimeUnit::CENTURY));
    }

    #[Test]
    public function decadeInCenturiesReturnsFloat(): void
    {
        $this->assertSame(0.1, TimeUnit::DECADE->in(TimeUnit::CENTURY));
    }

    // =========================================================================
    // Conversion to larger units (float results)
    // =========================================================================

    #[Test]
    public function millisecondInSecondsReturnsFloat(): void
    {
        $this->assertSame(0.001, TimeUnit::MILLISECOND->in(TimeUnit::SECOND));
    }

    #[Test]
    public function secondInMinutesReturnsFloat(): void
    {
        $this->assertEqualsWithDelta(1 / 60, TimeUnit::SECOND->in(TimeUnit::MINUTE), 1e-10);
    }

    #[Test]
    public function minuteInHoursReturnsFloat(): void
    {
        $this->assertEqualsWithDelta(1 / 60, TimeUnit::MINUTE->in(TimeUnit::HOUR), 1e-10);
    }

    #[Test]
    public function hourInDaysReturnsFloat(): void
    {
        $this->assertEqualsWithDelta(1 / 24, TimeUnit::HOUR->in(TimeUnit::DAY), 1e-10);
    }

    #[Test]
    public function dayInWeeksReturnsFloat(): void
    {
        $this->assertEqualsWithDelta(1 / 7, TimeUnit::DAY->in(TimeUnit::WEEK), 1e-10);
    }

    #[Test]
    public function dayInMonthsReturnsFloat(): void
    {
        $this->assertEqualsWithDelta(1 / 30, TimeUnit::DAY->in(TimeUnit::MONTH), 1e-10);
    }

    #[Test]
    public function dayInYearsReturnsFloat(): void
    {
        $this->assertEqualsWithDelta(1 / 365, TimeUnit::DAY->in(TimeUnit::YEAR), 1e-10);
    }

    #[Test]
    public function secondInYearsReturnsFloat(): void
    {
        $this->assertEqualsWithDelta(1 / 31_536_000, TimeUnit::SECOND->in(TimeUnit::YEAR), 1e-15);
    }

    // =========================================================================
    // Special cross-unit conversions
    // =========================================================================

    #[Test]
    public function yearInWeeksReturnsCorrectValue(): void
    {
        // 365 days / 7 days per week = 52.142857...
        $this->assertEqualsWithDelta(365 / 7, TimeUnit::YEAR->in(TimeUnit::WEEK), 1e-10);
    }

    #[Test]
    public function yearInMonthsReturnsCorrectValue(): void
    {
        // 365 days / 30 days per month = 12.166...
        $this->assertEqualsWithDelta(365 / 30, TimeUnit::YEAR->in(TimeUnit::MONTH), 1e-10);
    }

    #[Test]
    public function monthInWeeksReturnsCorrectValue(): void
    {
        // 30 days / 7 days per week = 4.285714...
        $this->assertEqualsWithDelta(30 / 7, TimeUnit::MONTH->in(TimeUnit::WEEK), 1e-10);
    }

    #[Test]
    public function weekInMonthsReturnsCorrectValue(): void
    {
        // 7 days / 30 days per month = 0.233...
        $this->assertEqualsWithDelta(7 / 30, TimeUnit::WEEK->in(TimeUnit::MONTH), 1e-10);
    }

    #[Test]
    public function weekInYearsReturnsCorrectValue(): void
    {
        // 7 days / 365 days per year
        $this->assertEqualsWithDelta(7 / 365, TimeUnit::WEEK->in(TimeUnit::YEAR), 1e-10);
    }

    #[Test]
    public function monthInYearsReturnsCorrectValue(): void
    {
        // 30 days / 365 days per year
        $this->assertEqualsWithDelta(30 / 365, TimeUnit::MONTH->in(TimeUnit::YEAR), 1e-10);
    }

    // =========================================================================
    // Inverse conversion verification
    // =========================================================================

    #[Test]
    #[DataProvider('unitPairsProvider')]
    public function inverseConversionsAreReciprocals(TimeUnit $a, TimeUnit $b): void
    {
        if ($a === $b) {
            $this->assertSame(1, $a->in($b));
            return;
        }

        $aToB = $a->in($b);
        $bToA = $b->in($a);

        // a->in(b) * b->in(a) should equal 1
        $this->assertEqualsWithDelta(1.0, $aToB * $bToA, 1e-10);
    }

    /**
     * @return array<string, array{TimeUnit, TimeUnit}>
     */
    public static function unitPairsProvider(): array
    {
        $units = TimeUnit::cases();
        $pairs = [];

        foreach ($units as $a) {
            foreach ($units as $b) {
                $pairs["{$a->value}_to_{$b->value}"] = [$a, $b];
            }
        }

        return $pairs;
    }

    // =========================================================================
    // Convert method tests
    // =========================================================================

    #[Test]
    public function convertTwoHoursToMinutes(): void
    {
        $this->assertSame(120, TimeUnit::HOUR->convert(2, TimeUnit::MINUTE));
    }

    #[Test]
    public function convertThreeDaysToHours(): void
    {
        $this->assertSame(72, TimeUnit::DAY->convert(3, TimeUnit::HOUR));
    }

    #[Test]
    public function convertOneWeekToSeconds(): void
    {
        $this->assertSame(604_800, TimeUnit::WEEK->convert(1, TimeUnit::SECOND));
    }

    #[Test]
    public function convertMinutesToHoursReturnsFloat(): void
    {
        $this->assertSame(0.5, TimeUnit::MINUTE->convert(30, TimeUnit::HOUR));
    }

    #[Test]
    public function convertSecondsToMinutesReturnsIntWhenWhole(): void
    {
        $this->assertSame(2, TimeUnit::SECOND->convert(120, TimeUnit::MINUTE));
    }

    #[Test]
    public function convertWithFloatInputValue(): void
    {
        $this->assertSame(90, TimeUnit::HOUR->convert(1.5, TimeUnit::MINUTE));
    }

    #[Test]
    public function convertToSameUnitReturnsSameValue(): void
    {
        $this->assertSame(42, TimeUnit::DAY->convert(42, TimeUnit::DAY));
    }

    #[Test]
    public function convertZeroReturnsZero(): void
    {
        $this->assertSame(0, TimeUnit::YEAR->convert(0, TimeUnit::MILLISECOND));
    }

    #[Test]
    public function convertNanosecondsToMicroseconds(): void
    {
        $this->assertSame(5, TimeUnit::NANOSECOND->convert(5000, TimeUnit::MICROSECOND));
    }

    #[Test]
    public function convertDecadesToYears(): void
    {
        $this->assertSame(50, TimeUnit::DECADE->convert(5, TimeUnit::YEAR));
    }

    #[Test]
    public function convertCenturiesToDecades(): void
    {
        $this->assertSame(20, TimeUnit::CENTURY->convert(2, TimeUnit::DECADE));
    }

    // =========================================================================
    // Label method tests
    // =========================================================================

    #[Test]
    #[DataProvider('labelProvider')]
    public function labelReturnsSingularForm(TimeUnit $unit, string $expected): void
    {
        $this->assertSame($expected, $unit->label());
    }

    #[Test]
    #[DataProvider('labelProvider')]
    public function labelReturnsPluralForm(TimeUnit $unit, string $singular): void
    {
        $this->assertSame($singular . 's', $unit->label(true));
    }

    /**
     * @return array<string, array{TimeUnit, string}>
     */
    public static function labelProvider(): array
    {
        return [
            'nanosecond' => [TimeUnit::NANOSECOND, 'nanosecond'],
            'microsecond' => [TimeUnit::MICROSECOND, 'microsecond'],
            'millisecond' => [TimeUnit::MILLISECOND, 'millisecond'],
            'second' => [TimeUnit::SECOND, 'second'],
            'minute' => [TimeUnit::MINUTE, 'minute'],
            'hour' => [TimeUnit::HOUR, 'hour'],
            'day' => [TimeUnit::DAY, 'day'],
            'week' => [TimeUnit::WEEK, 'week'],
            'month' => [TimeUnit::MONTH, 'month'],
            'year' => [TimeUnit::YEAR, 'year'],
            'decade' => [TimeUnit::DECADE, 'decade'],
            'century' => [TimeUnit::CENTURY, 'century'],
        ];
    }

    // =========================================================================
    // Static helper method tests
    // =========================================================================

    #[Test]
    public function casesReturnsAllTwelveUnits(): void
    {
        $all = TimeUnit::cases();

        $this->assertCount(12, $all);
        $this->assertContains(TimeUnit::NANOSECOND, $all);
        $this->assertContains(TimeUnit::MICROSECOND, $all);
        $this->assertContains(TimeUnit::MILLISECOND, $all);
        $this->assertContains(TimeUnit::SECOND, $all);
        $this->assertContains(TimeUnit::MINUTE, $all);
        $this->assertContains(TimeUnit::HOUR, $all);
        $this->assertContains(TimeUnit::DAY, $all);
        $this->assertContains(TimeUnit::WEEK, $all);
        $this->assertContains(TimeUnit::MONTH, $all);
        $this->assertContains(TimeUnit::YEAR, $all);
        $this->assertContains(TimeUnit::DECADE, $all);
        $this->assertContains(TimeUnit::CENTURY, $all);
    }

    #[Test]
    public function conversionMatrixHasAllUnits(): void
    {
        $matrix = TimeUnit::conversionMatrix();

        $this->assertCount(12, $matrix);
        $this->assertArrayHasKey('nanosecond', $matrix);
        $this->assertArrayHasKey('microsecond', $matrix);
        $this->assertArrayHasKey('millisecond', $matrix);
        $this->assertArrayHasKey('second', $matrix);
        $this->assertArrayHasKey('minute', $matrix);
        $this->assertArrayHasKey('hour', $matrix);
        $this->assertArrayHasKey('day', $matrix);
        $this->assertArrayHasKey('week', $matrix);
        $this->assertArrayHasKey('month', $matrix);
        $this->assertArrayHasKey('year', $matrix);
        $this->assertArrayHasKey('decade', $matrix);
        $this->assertArrayHasKey('century', $matrix);
    }

    #[Test]
    public function conversionMatrixHasAllConversionsPerUnit(): void
    {
        $matrix = TimeUnit::conversionMatrix();

        foreach ($matrix as $fromUnit => $conversions) {
            $this->assertCount(12, $conversions, "Unit {$fromUnit} should have 12 conversions");
        }
    }

    #[Test]
    public function conversionMatrixDiagonalIsOnes(): void
    {
        $matrix = TimeUnit::conversionMatrix();

        foreach (TimeUnit::cases() as $unit) {
            $this->assertSame(1, $matrix[$unit->value][$unit->value]);
        }
    }

    #[Test]
    public function conversionMatrixContainsCorrectValues(): void
    {
        $matrix = TimeUnit::conversionMatrix();

        $this->assertSame(1000, $matrix['microsecond']['nanosecond']);
        $this->assertSame(1000, $matrix['millisecond']['microsecond']);
        $this->assertSame(1000, $matrix['second']['millisecond']);
        $this->assertSame(60, $matrix['minute']['second']);
        $this->assertSame(60, $matrix['hour']['minute']);
        $this->assertSame(24, $matrix['day']['hour']);
        $this->assertSame(7, $matrix['week']['day']);
        $this->assertSame(365, $matrix['year']['day']);
        $this->assertSame(10, $matrix['decade']['year']);
        $this->assertSame(100, $matrix['century']['year']);
    }

    // =========================================================================
    // Real-world usage scenarios
    // =========================================================================

    #[Test]
    public function convertingTwoYearsToSeconds(): void
    {
        $years = 2;
        $seconds = $years * TimeUnit::YEAR->in(TimeUnit::SECOND);

        $this->assertSame(63_072_000, $seconds);
    }

    #[Test]
    public function convertingSecondsBackToYears(): void
    {
        $seconds = 63_072_000;
        $years = $seconds * TimeUnit::SECOND->in(TimeUnit::YEAR);

        $this->assertEqualsWithDelta(2.0, $years, 1e-10);
    }

    #[Test]
    public function roundTripConversionMaintainsPrecision(): void
    {
        $originalHours = 100;

        // Convert hours to nanoseconds and back
        $nanoseconds = $originalHours * TimeUnit::HOUR->in(TimeUnit::NANOSECOND);
        $hoursBack = $nanoseconds * TimeUnit::NANOSECOND->in(TimeUnit::HOUR);

        $this->assertEqualsWithDelta($originalHours, $hoursBack, 1e-10);
    }

    #[Test]
    public function calculateTimeoutInMilliseconds(): void
    {
        // Simulating: timeout of 5 minutes in milliseconds
        $timeoutMinutes = 5;
        $timeoutMs = $timeoutMinutes * TimeUnit::MINUTE->in(TimeUnit::MILLISECOND);

        $this->assertSame(300_000, $timeoutMs);
    }

    #[Test]
    public function calculateCacheTtlInSeconds(): void
    {
        // Simulating: cache TTL of 1 week in seconds
        $ttlSeconds = TimeUnit::WEEK->in(TimeUnit::SECOND);

        $this->assertSame(604_800, $ttlSeconds);
    }

    #[Test]
    public function calculatePerformanceTimingInMicroseconds(): void
    {
        // Simulating: 500ms timeout in microseconds for high-precision timing
        $microseconds = 500 * TimeUnit::MILLISECOND->in(TimeUnit::MICROSECOND);

        $this->assertSame(500_000, $microseconds);
    }

    #[Test]
    public function calculateHistoricalPeriodInDays(): void
    {
        // Simulating: 2 centuries in days
        $days = 2 * TimeUnit::CENTURY->in(TimeUnit::DAY);

        $this->assertSame(73_000, $days);
    }

    // =========================================================================
    // Enum value tests
    // =========================================================================

    #[Test]
    public function enumValuesAreCorrect(): void
    {
        $this->assertSame('nanosecond', TimeUnit::NANOSECOND->value);
        $this->assertSame('microsecond', TimeUnit::MICROSECOND->value);
        $this->assertSame('millisecond', TimeUnit::MILLISECOND->value);
        $this->assertSame('second', TimeUnit::SECOND->value);
        $this->assertSame('minute', TimeUnit::MINUTE->value);
        $this->assertSame('hour', TimeUnit::HOUR->value);
        $this->assertSame('day', TimeUnit::DAY->value);
        $this->assertSame('week', TimeUnit::WEEK->value);
        $this->assertSame('month', TimeUnit::MONTH->value);
        $this->assertSame('year', TimeUnit::YEAR->value);
        $this->assertSame('decade', TimeUnit::DECADE->value);
        $this->assertSame('century', TimeUnit::CENTURY->value);
    }

    #[Test]
    public function canCreateFromString(): void
    {
        $this->assertSame(TimeUnit::DAY, TimeUnit::from('day'));
        $this->assertSame(TimeUnit::HOUR, TimeUnit::from('hour'));
        $this->assertSame(TimeUnit::NANOSECOND, TimeUnit::from('nanosecond'));
        $this->assertSame(TimeUnit::CENTURY, TimeUnit::from('century'));
    }

    #[Test]
    public function tryFromReturnsNullForInvalidValue(): void
    {
        /** @var string $invalidValue */
        $invalidValue = ['invalid'][0];
        $result = TimeUnit::tryFrom($invalidValue);

        $this->assertNull($result);
    }

    // =========================================================================
    // Edge cases
    // =========================================================================

    #[Test]
    public function largeConversionCenturyToNanoseconds(): void
    {
        $result = TimeUnit::CENTURY->in(TimeUnit::NANOSECOND);

        // 100 years * 365 days * 24 hours * 60 min * 60 sec * 1e9 ns
        $this->assertSame(3_153_600_000_000_000_000, $result);
    }

    #[Test]
    public function smallConversionNanosecondToCentury(): void
    {
        $result = TimeUnit::NANOSECOND->in(TimeUnit::CENTURY);

        // Should be a very small float
        $expected = 1 / 3_153_600_000_000_000_000;
        $this->assertEqualsWithDelta($expected, $result, 1e-30);
    }

    #[Test]
    public function convertLargeNumberOfNanoseconds(): void
    {
        // 1 trillion nanoseconds = 1000 seconds
        $seconds = TimeUnit::NANOSECOND->convert(1_000_000_000_000, TimeUnit::SECOND);

        $this->assertEqualsWithDelta(1000, $seconds, 1e-10);
    }

    #[Test]
    public function convertFractionalMicroseconds(): void
    {
        // 1.5 microseconds in nanoseconds
        $nanoseconds = TimeUnit::MICROSECOND->convert(1.5, TimeUnit::NANOSECOND);

        $this->assertSame(1500, $nanoseconds);
    }

    #[Test]
    public function conversionChainMaintainsAccuracy(): void
    {
        // Convert 1 century through multiple units and back
        $original = 1;

        $inYears = TimeUnit::CENTURY->convert($original, TimeUnit::YEAR);
        $inDays = TimeUnit::YEAR->convert($inYears, TimeUnit::DAY);
        $inHours = TimeUnit::DAY->convert($inDays, TimeUnit::HOUR);
        $inMinutes = TimeUnit::HOUR->convert($inHours, TimeUnit::MINUTE);
        $inSeconds = TimeUnit::MINUTE->convert($inMinutes, TimeUnit::SECOND);
        $backToCenturies = TimeUnit::SECOND->convert($inSeconds, TimeUnit::CENTURY);

        $this->assertEqualsWithDelta($original, $backToCenturies, 1e-10);
    }
}
