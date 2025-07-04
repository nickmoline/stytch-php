<?php

namespace Stytch\Tests\Unit\Objects\Traits;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Stytch\Objects\Traits\HasCarbonDates;

class HasCarbonDatesTest extends TestCase
{
    use HasCarbonDates;

    public function testParseDateWithValidDate(): void
    {
        $date = self::parseDate('2023-01-01T12:00:00Z');

        $this->assertInstanceOf(Carbon::class, $date);
        $this->assertEquals('2023-01-01T12:00:00.000000Z', $date->toISOString());
    }

    public function testParseDateWithNull(): void
    {
        $date = self::parseDate(null);

        $this->assertNull($date);
    }

    public function testParseDateWithEmptyString(): void
    {
        $date = self::parseDate('');

        $this->assertInstanceOf(Carbon::class, $date);
        $this->assertEquals(Carbon::now()->toDateString(), $date->toDateString());
    }

    public function testParseDatesWithValidDates(): void
    {
        $dates = [
            'created_at' => '2023-01-01T12:00:00Z',
            'updated_at' => '2023-01-02T13:00:00Z',
            'deleted_at' => null
        ];

        $parsed = self::parseDates($dates);

        $this->assertIsArray($parsed);
        $this->assertCount(3, $parsed);
        $this->assertInstanceOf(Carbon::class, $parsed['created_at']);
        $this->assertInstanceOf(Carbon::class, $parsed['updated_at']);
        $this->assertNull($parsed['deleted_at']);
        $this->assertEquals('2023-01-01T12:00:00.000000Z', $parsed['created_at']->toISOString());
        $this->assertEquals('2023-01-02T13:00:00.000000Z', $parsed['updated_at']->toISOString());
    }

    public function testParseDatesWithEmptyArray(): void
    {
        $parsed = self::parseDates([]);

        $this->assertIsArray($parsed);
        $this->assertCount(0, $parsed);
    }

    public function testToDateStringWithValidCarbon(): void
    {
        $carbon = Carbon::parse('2023-01-01T12:00:00Z');
        $dateString = self::toDateString($carbon);

        $this->assertEquals('2023-01-01T12:00:00.000000Z', $dateString);
    }

    public function testToDateStringWithNull(): void
    {
        $dateString = self::toDateString(null);

        $this->assertNull($dateString);
    }

    public function testToDateStringsWithValidCarbons(): void
    {
        $dates = [
            'created_at' => Carbon::parse('2023-01-01T12:00:00Z'),
            'updated_at' => Carbon::parse('2023-01-02T13:00:00Z'),
            'deleted_at' => null
        ];

        $strings = self::toDateStrings($dates);

        $this->assertIsArray($strings);
        $this->assertCount(3, $strings);
        $this->assertEquals('2023-01-01T12:00:00.000000Z', $strings['created_at']);
        $this->assertEquals('2023-01-02T13:00:00.000000Z', $strings['updated_at']);
        $this->assertNull($strings['deleted_at']);
    }

    public function testToDateStringsWithEmptyArray(): void
    {
        $strings = self::toDateStrings([]);

        $this->assertIsArray($strings);
        $this->assertCount(0, $strings);
    }

    public function testRoundTripDateConversion(): void
    {
        $originalDate = '2023-01-01T12:00:00Z';

        // Parse to Carbon
        $carbon = self::parseDate($originalDate);
        $this->assertInstanceOf(Carbon::class, $carbon);

        // Convert back to string
        $dateString = self::toDateString($carbon);
        $this->assertEquals('2023-01-01T12:00:00.000000Z', $dateString);

        // Parse again to verify consistency
        $carbon2 = self::parseDate($dateString);
        $this->assertInstanceOf(Carbon::class, $carbon2);
        $this->assertEquals($carbon->toISOString(), $carbon2->toISOString());
    }

    public function testRoundTripDatesConversion(): void
    {
        $originalDates = [
            'created_at' => '2023-01-01T12:00:00Z',
            'updated_at' => '2023-01-02T13:00:00Z',
            'deleted_at' => null
        ];

        // Parse to Carbons
        $carbons = self::parseDates($originalDates);
        $this->assertIsArray($carbons);
        $this->assertInstanceOf(Carbon::class, $carbons['created_at']);
        $this->assertInstanceOf(Carbon::class, $carbons['updated_at']);
        $this->assertNull($carbons['deleted_at']);

        // Convert back to strings
        $strings = self::toDateStrings($carbons);
        $this->assertIsArray($strings);
        $this->assertEquals('2023-01-01T12:00:00.000000Z', $strings['created_at']);
        $this->assertEquals('2023-01-02T13:00:00.000000Z', $strings['updated_at']);
        $this->assertNull($strings['deleted_at']);

        // Parse again to verify consistency
        $carbons2 = self::parseDates($strings);
        $this->assertIsArray($carbons2);
        $this->assertInstanceOf(Carbon::class, $carbons2['created_at']);
        $this->assertInstanceOf(Carbon::class, $carbons2['updated_at']);
        $this->assertNull($carbons2['deleted_at']);
        $this->assertEquals($carbons['created_at']->toISOString(), $carbons2['created_at']->toISOString());
        $this->assertEquals($carbons['updated_at']->toISOString(), $carbons2['updated_at']->toISOString());
    }
}
