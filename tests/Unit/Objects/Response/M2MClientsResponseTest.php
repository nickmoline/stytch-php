<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\M2MClient;
use Stytch\Objects\Response\M2MClientsResponse;

class M2MClientsResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $m2mClients = [
            new M2MClient(
                'client_123',
                'Test Client 1',
                'A test client for testing',
                'active',
                ['read:users'],
                'abcd'
            ),
            new M2MClient(
                'client_456',
                'Test Client 2',
                'Another test client',
                'inactive',
                ['write:users'],
                'efgh'
            ),
        ];

        $resultsMetadata = [
            'total' => 2,
            'page' => 1,
            'per_page' => 10,
        ];

        $response = new M2MClientsResponse('test_request_id', 200, $m2mClients, $resultsMetadata);

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals($m2mClients, $response->m2m_clients);
        $this->assertEquals($resultsMetadata, $response->results_metadata);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'm2m_clients' => [
                [
                    'client_id' => 'client_123',
                    'client_name' => 'Test Client 1',
                    'client_description' => 'A test client for testing',
                    'status' => 'active',
                    'scopes' => ['read:users'],
                    'client_secret_last_four' => 'abcd',
                ],
                [
                    'client_id' => 'client_456',
                    'client_name' => 'Test Client 2',
                    'client_description' => 'Another test client',
                    'status' => 'inactive',
                    'scopes' => ['write:users'],
                    'client_secret_last_four' => 'efgh',
                ],
            ],
            'results_metadata' => [
                'total' => 2,
                'page' => 1,
                'per_page' => 10,
            ],
        ];

        $response = M2MClientsResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertCount(2, $response->m2m_clients);
        $this->assertInstanceOf(M2MClient::class, $response->m2m_clients[0]);
        $this->assertInstanceOf(M2MClient::class, $response->m2m_clients[1]);
        $this->assertEquals('client_123', $response->m2m_clients[0]->client_id);
        $this->assertEquals('client_456', $response->m2m_clients[1]->client_id);
        $this->assertEquals([
            'total' => 2,
            'page' => 1,
            'per_page' => 10,
        ], $response->results_metadata);
    }

    public function testFromArrayWithMissingFields(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
        ];

        $response = M2MClientsResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals([], $response->m2m_clients);
        $this->assertEquals([], $response->results_metadata);
    }

    public function testToArray(): void
    {
        $m2mClients = [
            new M2MClient(
                'client_123',
                'Test Client 1',
                'A test client for testing',
                'active',
                ['read:users'],
                'abcd'
            ),
            new M2MClient(
                'client_456',
                'Test Client 2',
                'Another test client',
                'inactive',
                ['write:users'],
                'efgh'
            ),
        ];

        $resultsMetadata = [
            'total' => 2,
            'page' => 1,
            'per_page' => 10,
        ];

        $response = new M2MClientsResponse('test_request_id', 200, $m2mClients, $resultsMetadata);
        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'm2m_clients' => [
                $m2mClients[0]->toArray(),
                $m2mClients[1]->toArray(),
            ],
            'results_metadata' => $resultsMetadata,
        ], $array);
    }

    public function testToArrayWithEmptyArrays(): void
    {
        $response = new M2MClientsResponse('test_request_id', 200, [], []);
        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'm2m_clients' => [],
            'results_metadata' => [],
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'm2m_clients' => [
                [
                    'client_id' => 'client_123',
                    'client_name' => 'Test Client 1',
                    'client_description' => 'A test client for testing',
                    'status' => 'active',
                    'scopes' => ['read:users'],
                    'client_secret_last_four' => 'abcd',
                ],
                [
                    'client_id' => 'client_456',
                    'client_name' => 'Test Client 2',
                    'client_description' => 'Another test client',
                    'status' => 'inactive',
                    'scopes' => ['write:users'],
                    'client_secret_last_four' => 'efgh',
                ],
            ],
            'results_metadata' => [
                'total' => 2,
                'page' => 1,
                'per_page' => 10,
            ],
        ];

        $response = M2MClientsResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }

    public function testRoundTripConversionWithEmptyArrays(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'm2m_clients' => [],
            'results_metadata' => [],
        ];

        $response = M2MClientsResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }
}
