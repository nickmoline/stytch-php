<?php

namespace Stytch\Tests\B2C;

use PHPUnit\Framework\TestCase;
use Stytch\B2C\M2M;
use Stytch\Objects\Response\M2MTokenResponse;
use Stytch\Objects\Response\M2MAuthenticateTokenResponse;
use Stytch\Shared\Client;

class M2MTest extends TestCase
{
    private M2M $m2m;
    /** @var Client|\PHPUnit\Framework\MockObject\MockObject */
    private $mockClient;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(Client::class);
        $this->m2m = new M2M($this->mockClient);
    }

    public function testAuthenticate(): void
    {
        $expectedData = [
            'access_token' => 'test-jwt-token',
        ];

        $mockResponse = [
            'client_id' => 'm2m-client-test-00000000-0000-4000-8000-000000000000',
            'custom_claims' => ['custom key' => 'custom value'],
            'scopes' => ['read:users', 'read:books', 'write:penguins'],
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/m2m/authenticate', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->m2m->authenticate($expectedData);

        $this->assertEquals($mockResponse, $result);
    }

    public function testAuthenticateWithRequiredScopes(): void
    {
        $expectedData = [
            'access_token' => 'test-jwt-token',
            'required_scopes' => ['write:penguins'],
        ];

        $mockResponse = [
            'client_id' => 'm2m-client-test-00000000-0000-4000-8000-000000000000',
            'custom_claims' => ['custom key' => 'custom value'],
            'scopes' => ['read:users', 'read:books', 'write:penguins'],
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/m2m/authenticate', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->m2m->authenticate($expectedData);

        $this->assertEquals($mockResponse, $result);
    }

    public function testAuthenticateWithMaxTokenAge(): void
    {
        $expectedData = [
            'access_token' => 'test-jwt-token',
            'max_token_age_seconds' => 100,
        ];

        $mockResponse = [
            'client_id' => 'm2m-client-test-00000000-0000-4000-8000-000000000000',
            'custom_claims' => ['custom key' => 'custom value'],
            'scopes' => ['read:users', 'read:books', 'write:penguins'],
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/m2m/authenticate', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->m2m->authenticate($expectedData);

        $this->assertEquals($mockResponse, $result);
    }

    public function testAuthenticateWithClaims(): void
    {
        $expectedData = [
            'access_token' => 'test-jwt-token',
        ];

        $mockResponse = [
            'client_id' => 'm2m-client-test-00000000-0000-4000-8000-000000000000',
            'custom_claims' => ['custom key' => 'custom value'],
            'scopes' => ['read:users', 'read:books', 'write:penguins'],
        ];

        $this->mockClient
            ->expects($this->once())
            ->method('post')
            ->with('/v1/m2m/authenticate_with_claims', $expectedData)
            ->willReturn($mockResponse);

        $result = $this->m2m->authenticateWithClaims($expectedData);

        $this->assertEquals($mockResponse, $result);
    }

    /**
     * @param callable $assertion
     * @param array<string, mixed> $response
     */
    private function getMockClient(callable $assertion, array $response = []): Client
    {
        $mock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['post'])
            ->getMock();
        $mock->method('post')
            ->willReturnCallback(function (...$args) use ($assertion, $response) {
                $assertion(...$args);
                return $response;
            });
        return $mock;
    }

    public function testToken(): void
    {
        $expected = [
            'request_id' => 'req',
            'status_code' => 200,
            'access_token' => 'token',
            'token_type' => 'bearer',
            'expires_in' => 3600,
        ];
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/m2m/token', $url);
        }, $expected);
        $api = new M2M($client);
        $resp = $api->token([]);
        $this->assertEquals('token', $resp->access_token);
    }

    public function testAuthenticateToken(): void
    {
        $expected = [
            'request_id' => 'req',
            'status_code' => 200,
            'client_id' => 'id',
            'scopes' => ['a'],
            'custom_claims' => ['foo' => 'bar'],
        ];
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/m2m/authenticate_token', $url);
        }, $expected);
        $api = new M2M($client);
        $resp = $api->authenticateToken([]);
        $this->assertEquals('id', $resp->client_id);
        $this->assertEquals(['foo' => 'bar'], $resp->custom_claims);
    }
}
