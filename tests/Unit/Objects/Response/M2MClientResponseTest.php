<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\M2MClient;
use Stytch\Objects\Response\M2MClientResponse;

class M2MClientResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $m2mClient = new M2MClient(
            'client_123',
            'Test Client',
            'A test client for testing',
            'active',
            ['read:users'],
            'abcd'
        );

        $response = new M2MClientResponse('test_request_id', 200, $m2mClient);

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertSame($m2mClient, $response->m2m_client);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'm2m_client' => [
                'client_id' => 'client_456',
                'client_name' => 'Another Client',
                'client_description' => 'Another test client',
                'status' => 'inactive',
                'scopes' => ['read:users'],
                'client_secret_last_four' => 'efgh',
            ],
        ];

        $response = M2MClientResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertInstanceOf(M2MClient::class, $response->m2m_client);
        $this->assertEquals('client_456', $response->m2m_client->client_id);
        $this->assertEquals('Another Client', $response->m2m_client->client_name);
    }

    public function testToArray(): void
    {
        $m2mClient = new M2MClient(
            'client_123',
            'Test Client',
            'A test client for testing',
            'active',
            ['read:users'],
            'abcd'
        );

        $response = new M2MClientResponse('test_request_id', 200, $m2mClient);
        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'm2m_client' => $m2mClient->toArray(),
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'm2m_client' => [
                'client_id' => 'client_456',
                'client_name' => 'Another Client',
                'client_description' => 'Another test client',
                'status' => 'inactive',
                'scopes' => ['read:users'],
                'client_secret_last_four' => 'efgh',
                'trusted_metadata' => ['org_id' => 'org_456'],
                'next_client_secret_last_four' => 'ijkl',
                'client_secret' => 'secret_789',
                'next_client_secret' => 'next_secret_012',
            ],
        ];

        $response = M2MClientResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }
}
