<?php

namespace Stytch\Objects\Traits;

use Carbon\Carbon;

trait HasCarbonDates
{
    /**
     * Parse a date string to Carbon instance, returning null if the date is not set
     */
    protected static function parseDate(?string $date): ?Carbon
    {
        return isset($date) ? Carbon::parse($date) : null;
    }

    /**
     * Parse multiple date strings to Carbon instances
     *
     * @param array<string, string|null> $dates Array of date strings
     * @return array<string, Carbon|null> Array of Carbon instances
     */
    protected static function parseDates(array $dates): array
    {
        $parsed = [];
        foreach ($dates as $key => $date) {
            $parsed[$key] = self::parseDate($date);
        }
        return $parsed;
    }

    /**
     * Convert a Carbon instance to ISO string, returning null if the date is not set
     */
    protected static function toDateString(?Carbon $date): ?string
    {
        return $date?->toISOString();
    }

    /**
     * Convert multiple Carbon instances to ISO strings
     *
     * @param array<string, Carbon|null> $dates Array of Carbon instances
     * @return array<string, string|null> Array of ISO date strings
     */
    protected static function toDateStrings(array $dates): array
    {
        $strings = [];
        foreach ($dates as $key => $date) {
            $strings[$key] = self::toDateString($date);
        }
        return $strings;
    }
}
