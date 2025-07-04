<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\M2MTokenResponse;

class M2MTokenResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $response = new M2MTokenResponse(
            'test_request_id',
            200,
            'access_token_123',
            'Bearer',
            3600
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('access_token_123', $response->access_token);
        $this->assertEquals('Bearer', $response->token_type);
        $this->assertEquals(3600, $response->expires_in);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'access_token' => 'access_token_456',
            'token_type' => 'Bearer',
            'expires_in' => 7200,
        ];

        $response = M2MTokenResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('access_token_456', $response->access_token);
        $this->assertEquals('Bearer', $response->token_type);
        $this->assertEquals(7200, $response->expires_in);
    }

    public function testToArray(): void
    {
        $response = new M2MTokenResponse(
            'test_request_id',
            200,
            'access_token_123',
            'Bearer',
            3600
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'access_token' => 'access_token_123',
            'token_type' => 'Bearer',
            'expires_in' => 3600,
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'access_token' => 'access_token_456',
            'token_type' => 'Bearer',
            'expires_in' => 7200,
        ];

        $response = M2MTokenResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }

    public function testWithDifferentTokenType(): void
    {
        $response = new M2MTokenResponse(
            'test_request_id',
            200,
            'access_token_123',
            'Basic',
            1800
        );

        $this->assertEquals('Basic', $response->token_type);
        $this->assertEquals(1800, $response->expires_in);
    }

    public function testToArrayWithDifferentValues(): void
    {
        $response = new M2MTokenResponse(
            'test_request_id',
            201,
            'access_token_789',
            'Basic',
            1800
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 201,
            'access_token' => 'access_token_789',
            'token_type' => 'Basic',
            'expires_in' => 1800,
        ], $array);
    }
}
