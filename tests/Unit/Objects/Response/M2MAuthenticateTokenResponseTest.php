<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\M2MAuthenticateTokenResponse;

class M2MAuthenticateTokenResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $scopes = ['read:users', 'write:users'];
        $customClaims = ['org_id' => 'org_123', 'role' => 'admin'];

        $response = new M2MAuthenticateTokenResponse(
            'test_request_id',
            200,
            'client_123',
            $scopes,
            $customClaims
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('client_123', $response->client_id);
        $this->assertEquals($scopes, $response->scopes);
        $this->assertEquals($customClaims, $response->custom_claims);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'client_id' => 'client_456',
            'scopes' => ['read:users', 'write:users'],
            'custom_claims' => ['org_id' => 'org_123', 'role' => 'admin'],
        ];

        $response = M2MAuthenticateTokenResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('client_456', $response->client_id);
        $this->assertEquals(['read:users', 'write:users'], $response->scopes);
        $this->assertEquals(['org_id' => 'org_123', 'role' => 'admin'], $response->custom_claims);
    }

    public function testFromArrayWithEmptyArrays(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'client_id' => 'client_456',
            'scopes' => [],
            'custom_claims' => [],
        ];

        $response = M2MAuthenticateTokenResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('client_456', $response->client_id);
        $this->assertEquals([], $response->scopes);
        $this->assertEquals([], $response->custom_claims);
    }

    public function testToArray(): void
    {
        $scopes = ['read:users', 'write:users'];
        $customClaims = ['org_id' => 'org_123', 'role' => 'admin'];

        $response = new M2MAuthenticateTokenResponse(
            'test_request_id',
            200,
            'client_123',
            $scopes,
            $customClaims
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'client_id' => 'client_123',
            'scopes' => $scopes,
            'custom_claims' => $customClaims,
        ], $array);
    }

    public function testToArrayWithEmptyArrays(): void
    {
        $response = new M2MAuthenticateTokenResponse(
            'test_request_id',
            200,
            'client_123',
            [],
            []
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'client_id' => 'client_123',
            'scopes' => [],
            'custom_claims' => [],
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'client_id' => 'client_456',
            'scopes' => ['read:users', 'write:users'],
            'custom_claims' => ['org_id' => 'org_123', 'role' => 'admin'],
        ];

        $response = M2MAuthenticateTokenResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }

    public function testRoundTripConversionWithEmptyArrays(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'client_id' => 'client_456',
            'scopes' => [],
            'custom_claims' => [],
        ];

        $response = M2MAuthenticateTokenResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }
}
