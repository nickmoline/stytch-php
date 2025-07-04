<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\PasswordStrengthResponse;

class PasswordStrengthResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $response = new PasswordStrengthResponse(
            'test_request_id',
            200,
            true,
            85,
            false,
            'strong',
            true
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertTrue($response->valid_password);
        $this->assertEquals(85, $response->score);
        $this->assertFalse($response->breached_password);
        $this->assertEquals('strong', $response->strength_policy);
        $this->assertTrue($response->breach_detection_on_create);
    }

    public function testConstructorWithWeakPassword(): void
    {
        $response = new PasswordStrengthResponse(
            'test_request_id',
            200,
            false,
            25,
            true,
            'weak',
            false
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertFalse($response->valid_password);
        $this->assertEquals(25, $response->score);
        $this->assertTrue($response->breached_password);
        $this->assertEquals('weak', $response->strength_policy);
        $this->assertFalse($response->breach_detection_on_create);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'valid_password' => true,
            'score' => 90,
            'breached_password' => false,
            'strength_policy' => 'very_strong',
            'breach_detection_on_create' => true,
        ];

        $response = PasswordStrengthResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertTrue($response->valid_password);
        $this->assertEquals(90, $response->score);
        $this->assertFalse($response->breached_password);
        $this->assertEquals('very_strong', $response->strength_policy);
        $this->assertTrue($response->breach_detection_on_create);
    }

    public function testFromArrayWithDefaultBreachDetection(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'valid_password' => false,
            'score' => 10,
            'breached_password' => true,
            'strength_policy' => 'very_weak',
        ];

        $response = PasswordStrengthResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertFalse($response->valid_password);
        $this->assertEquals(10, $response->score);
        $this->assertTrue($response->breached_password);
        $this->assertEquals('very_weak', $response->strength_policy);
        $this->assertFalse($response->breach_detection_on_create);
    }

    public function testToArray(): void
    {
        $response = new PasswordStrengthResponse(
            'test_request_id',
            200,
            true,
            85,
            false,
            'strong',
            true
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'valid_password' => true,
            'score' => 85,
            'breached_password' => false,
            'strength_policy' => 'strong',
            'breach_detection_on_create' => true,
        ], $array);
    }

    public function testToArrayWithWeakPassword(): void
    {
        $response = new PasswordStrengthResponse(
            'test_request_id',
            200,
            false,
            15,
            true,
            'very_weak',
            false
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'valid_password' => false,
            'score' => 15,
            'breached_password' => true,
            'strength_policy' => 'very_weak',
            'breach_detection_on_create' => false,
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'valid_password' => true,
            'score' => 75,
            'breached_password' => false,
            'strength_policy' => 'medium',
            'breach_detection_on_create' => true,
        ];

        $response = PasswordStrengthResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }

    public function testRoundTripConversionWithWeakPassword(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'valid_password' => false,
            'score' => 5,
            'breached_password' => true,
            'strength_policy' => 'very_weak',
        ];

        $response = PasswordStrengthResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        // The toArray method always includes breach_detection_on_create, so we need to check it separately
        $expectedData = $originalData;
        $expectedData['breach_detection_on_create'] = false;

        $this->assertEquals($expectedData, $convertedData);
    }

    public function testEdgeCases(): void
    {
        // Test with minimum score
        $response = new PasswordStrengthResponse(
            'test_request_id',
            200,
            false,
            0,
            true,
            'very_weak',
            false
        );

        $this->assertEquals(0, $response->score);
        $this->assertFalse($response->valid_password);
        $this->assertTrue($response->breached_password);

        // Test with maximum score
        $response = new PasswordStrengthResponse(
            'test_request_id',
            200,
            true,
            100,
            false,
            'very_strong',
            true
        );

        $this->assertEquals(100, $response->score);
        $this->assertTrue($response->valid_password);
        $this->assertFalse($response->breached_password);
    }
}
