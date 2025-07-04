<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\M2MClient;

class M2MClientTest extends TestCase
{
    public function testConstructor(): void
    {
        $scopes = ['read:users', 'write:users'];
        $trustedMetadata = ['org_id' => 'org_123'];

        $client = new M2MClient(
            'client_123',
            'Test Client',
            'A test client for testing',
            'active',
            $scopes,
            'abcd',
            $trustedMetadata,
            'efgh',
            'secret_123',
            'next_secret_456'
        );

        $this->assertEquals('client_123', $client->client_id);
        $this->assertEquals('Test Client', $client->client_name);
        $this->assertEquals('A test client for testing', $client->client_description);
        $this->assertEquals('active', $client->status);
        $this->assertEquals($scopes, $client->scopes);
        $this->assertEquals('abcd', $client->client_secret_last_four);
        $this->assertEquals($trustedMetadata, $client->trusted_metadata);
        $this->assertEquals('efgh', $client->next_client_secret_last_four);
        $this->assertEquals('secret_123', $client->client_secret);
        $this->assertEquals('next_secret_456', $client->next_client_secret);
    }

    public function testConstructorWithNullValues(): void
    {
        $client = new M2MClient(
            'client_123',
            'Test Client',
            'A test client for testing',
            'active',
            ['read:users'],
            'abcd'
        );

        $this->assertEquals('client_123', $client->client_id);
        $this->assertEquals('Test Client', $client->client_name);
        $this->assertEquals('A test client for testing', $client->client_description);
        $this->assertEquals('active', $client->status);
        $this->assertEquals(['read:users'], $client->scopes);
        $this->assertEquals('abcd', $client->client_secret_last_four);
        $this->assertNull($client->trusted_metadata);
        $this->assertNull($client->next_client_secret_last_four);
        $this->assertNull($client->client_secret);
        $this->assertNull($client->next_client_secret);
    }

    public function testFromArray(): void
    {
        $data = [
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
        ];

        $client = M2MClient::fromArray($data);

        $this->assertEquals('client_456', $client->client_id);
        $this->assertEquals('Another Client', $client->client_name);
        $this->assertEquals('Another test client', $client->client_description);
        $this->assertEquals('inactive', $client->status);
        $this->assertEquals(['read:users'], $client->scopes);
        $this->assertEquals('efgh', $client->client_secret_last_four);
        $this->assertEquals(['org_id' => 'org_456'], $client->trusted_metadata);
        $this->assertEquals('ijkl', $client->next_client_secret_last_four);
        $this->assertEquals('secret_789', $client->client_secret);
        $this->assertEquals('next_secret_012', $client->next_client_secret);
    }

    public function testFromArrayWithMissingOptionalFields(): void
    {
        $data = [
            'client_id' => 'client_456',
            'client_name' => 'Another Client',
            'client_description' => 'Another test client',
            'status' => 'inactive',
            'scopes' => ['read:users'],
            'client_secret_last_four' => 'efgh',
        ];

        $client = M2MClient::fromArray($data);

        $this->assertEquals('client_456', $client->client_id);
        $this->assertEquals('Another Client', $client->client_name);
        $this->assertEquals('Another test client', $client->client_description);
        $this->assertEquals('inactive', $client->status);
        $this->assertEquals(['read:users'], $client->scopes);
        $this->assertEquals('efgh', $client->client_secret_last_four);
        $this->assertNull($client->trusted_metadata);
        $this->assertNull($client->next_client_secret_last_four);
        $this->assertNull($client->client_secret);
        $this->assertNull($client->next_client_secret);
    }

    public function testToArray(): void
    {
        $scopes = ['read:users', 'write:users'];
        $trustedMetadata = ['org_id' => 'org_123'];

        $client = new M2MClient(
            'client_123',
            'Test Client',
            'A test client for testing',
            'active',
            $scopes,
            'abcd',
            $trustedMetadata,
            'efgh',
            'secret_123',
            'next_secret_456'
        );

        $array = $client->toArray();

        $this->assertEquals([
            'client_id' => 'client_123',
            'client_name' => 'Test Client',
            'client_description' => 'A test client for testing',
            'status' => 'active',
            'scopes' => $scopes,
            'client_secret_last_four' => 'abcd',
            'trusted_metadata' => $trustedMetadata,
            'next_client_secret_last_four' => 'efgh',
            'client_secret' => 'secret_123',
            'next_client_secret' => 'next_secret_456',
        ], $array);
    }

    public function testToArrayWithNullValues(): void
    {
        $client = new M2MClient(
            'client_123',
            'Test Client',
            'A test client for testing',
            'active',
            ['read:users'],
            'abcd'
        );

        $array = $client->toArray();

        $this->assertEquals([
            'client_id' => 'client_123',
            'client_name' => 'Test Client',
            'client_description' => 'A test client for testing',
            'status' => 'active',
            'scopes' => ['read:users'],
            'client_secret_last_four' => 'abcd',
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
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
        ];

        $client = M2MClient::fromArray($originalData);
        $convertedData = $client->toArray();

        $this->assertEquals($originalData, $convertedData);
    }

    public function testRoundTripConversionWithMissingOptionalFields(): void
    {
        $originalData = [
            'client_id' => 'client_456',
            'client_name' => 'Another Client',
            'client_description' => 'Another test client',
            'status' => 'inactive',
            'scopes' => ['read:users'],
            'client_secret_last_four' => 'efgh',
        ];

        $client = M2MClient::fromArray($originalData);
        $convertedData = $client->toArray();

        $this->assertEquals($originalData, $convertedData);
    }
}
