<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\OIDCProvidersResponse;

class OIDCProvidersResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $registrations = [
            'provider_1' => [
                'provider_id' => 'provider_1',
                'name' => 'Google OIDC',
                'client_id' => 'client_123',
                'issuer' => 'https://accounts.google.com',
            ],
            'provider_2' => [
                'provider_id' => 'provider_2',
                'name' => 'Microsoft OIDC',
                'client_id' => 'client_456',
                'issuer' => 'https://login.microsoftonline.com',
            ],
        ];

        $response = new OIDCProvidersResponse(
            'test_request_id',
            200,
            $registrations
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals($registrations, $response->registrations);
    }

    public function testConstructorWithEmptyRegistrations(): void
    {
        $response = new OIDCProvidersResponse(
            'test_request_id',
            200,
            []
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals([], $response->registrations);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'registrations' => [
                'provider_1' => [
                    'provider_id' => 'provider_1',
                    'name' => 'Google OIDC',
                    'client_id' => 'client_123',
                    'issuer' => 'https://accounts.google.com',
                ],
            ],
        ];

        $response = OIDCProvidersResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals($data['registrations'], $response->registrations);
    }

    public function testFromArrayWithMissingRegistrations(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
        ];

        $response = OIDCProvidersResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals([], $response->registrations);
    }

    public function testFromArrayWithEmptyRegistrations(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'registrations' => [],
        ];

        $response = OIDCProvidersResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals([], $response->registrations);
    }

    public function testToArray(): void
    {
        $registrations = [
            'provider_1' => [
                'provider_id' => 'provider_1',
                'name' => 'Google OIDC',
                'client_id' => 'client_123',
                'issuer' => 'https://accounts.google.com',
            ],
            'provider_2' => [
                'provider_id' => 'provider_2',
                'name' => 'Microsoft OIDC',
                'client_id' => 'client_456',
                'issuer' => 'https://login.microsoftonline.com',
            ],
        ];

        $response = new OIDCProvidersResponse(
            'test_request_id',
            200,
            $registrations
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'registrations' => $registrations,
        ], $array);
    }

    public function testToArrayWithEmptyRegistrations(): void
    {
        $response = new OIDCProvidersResponse(
            'test_request_id',
            200,
            []
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'registrations' => [],
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'registrations' => [
                'provider_1' => [
                    'provider_id' => 'provider_1',
                    'name' => 'Google OIDC',
                    'client_id' => 'client_123',
                    'issuer' => 'https://accounts.google.com',
                ],
                'provider_2' => [
                    'provider_id' => 'provider_2',
                    'name' => 'Microsoft OIDC',
                    'client_id' => 'client_456',
                    'issuer' => 'https://login.microsoftonline.com',
                ],
            ],
        ];

        $response = OIDCProvidersResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }

    public function testRoundTripConversionWithEmptyRegistrations(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'registrations' => [],
        ];

        $response = OIDCProvidersResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }

    public function testRoundTripConversionWithMissingRegistrations(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
        ];

        $response = OIDCProvidersResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        // The converted data will have an empty registrations array
        $expectedData = $originalData;
        $expectedData['registrations'] = [];

        $this->assertEquals($expectedData, $convertedData);
    }
}
