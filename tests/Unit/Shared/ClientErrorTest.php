<?php

namespace Stytch\Tests\Shared;

use PHPUnit\Framework\TestCase;
use Stytch\Shared\Client;
use Stytch\Shared\Errors\StytchError;
use Stytch\Shared\Errors\RequestError;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Stytch\Shared\Errors\StytchRequestException;

class ClientErrorTest extends TestCase
{
    public function testThrowsTypeErrorOnInvalidConfig(): void
    {
        $this->expectException(\TypeError::class);
        /** @var mixed $invalidConfig */
        $invalidConfig = 'invalid_config';
        new Client($invalidConfig);
    }

    public function testThrowsInvalidArgumentExceptionOnMissingProjectId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing "project_id" in config');
        new Client(['secret' => 'test_secret']);
    }

    public function testThrowsInvalidArgumentExceptionOnMissingSecret(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing "secret" in config');
        new Client(['project_id' => 'test_project']);
    }

    public function testThrowsInvalidArgumentExceptionOnInvalidBaseUrl(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('custom_base_url must use HTTPS scheme');
        new Client([
            'project_id' => 'test_project',
            'secret' => 'test_secret',
            'custom_base_url' => 'http://example.com',
        ]);
    }

    public function testHandlesNetworkConnectionErrors(): void
    {
        $mockGuzzle = $this->createMock(GuzzleClient::class);
        $mockGuzzle->method('send')
            ->willThrowException(new ConnectException(
                'Connection failed',
                new Request('GET', 'https://api.stytch.com/v1/test'),
            ));

        $client = new Client([
            'project_id' => 'test_project',
            'secret' => 'test_secret',
        ]);

        $reflection = new \ReflectionClass($client);
        $guzzleProperty = $reflection->getProperty('httpClient');
        $guzzleProperty->setAccessible(true);
        $guzzleProperty->setValue($client, $mockGuzzle);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Connection failed');
        $client->get('/v1/test');
    }

    public function testHandlesHttpErrorResponses(): void
    {
        $mockGuzzle = $this->createMock(GuzzleClient::class);
        $mockGuzzle->method('send')
            ->willReturn(new Response(400, [], (string)json_encode([
                'error_type' => 'invalid_request',
                'error_message' => 'Invalid request data',
                'status_code' => 400,
                'request_id' => 'req_test',
                'error_url' => 'https://stytch.com/docs/errors/test',
            ])));

        $client = new Client([
            'project_id' => 'test_project',
            'secret' => 'test_secret',
        ]);

        $reflection = new \ReflectionClass($client);
        $guzzleProperty = $reflection->getProperty('httpClient');
        $guzzleProperty->setAccessible(true);
        $guzzleProperty->setValue($client, $mockGuzzle);

        $this->expectException(StytchRequestException::class);
        $client->get('/v1/test');
    }

    public function testHandlesServerErrorResponses(): void
    {
        $mockGuzzle = $this->createMock(GuzzleClient::class);
        $mockGuzzle->method('send')
            ->willReturn(new Response(500, [], (string)json_encode([
                'error_type' => 'server_error',
                'error_message' => 'Internal server error',
                'status_code' => 500,
                'request_id' => 'req_test',
                'error_url' => 'https://stytch.com/docs/errors/test',
            ])));

        $client = new Client([
            'project_id' => 'test_project',
            'secret' => 'test_secret',
        ]);

        $reflection = new \ReflectionClass($client);
        $guzzleProperty = $reflection->getProperty('httpClient');
        $guzzleProperty->setAccessible(true);
        $guzzleProperty->setValue($client, $mockGuzzle);

        $this->expectException(StytchRequestException::class);
        $client->get('/v1/test');
    }

    public function testHandlesInvalidJsonResponse(): void
    {
        $mockGuzzle = $this->createMock(GuzzleClient::class);
        $mockGuzzle->method('send')
            ->willReturn(new Response(200, [], 'invalid json'));

        $client = new Client([
            'project_id' => 'test_project',
            'secret' => 'test_secret',
        ]);

        $reflection = new \ReflectionClass($client);
        $guzzleProperty = $reflection->getProperty('httpClient');
        $guzzleProperty->setAccessible(true);
        $guzzleProperty->setValue($client, $mockGuzzle);

        $this->expectException(RequestError::class);
        $this->expectExceptionMessage('Unable to parse JSON response');
        $client->get('/v1/test');
    }

    public function testHandlesEmptyResponse(): void
    {
        $mockGuzzle = $this->createMock(GuzzleClient::class);
        $mockGuzzle->method('send')
            ->willReturn(new Response(200, [], ''));

        $client = new Client([
            'project_id' => 'test_project',
            'secret' => 'test_secret',
        ]);

        $reflection = new \ReflectionClass($client);
        $guzzleProperty = $reflection->getProperty('httpClient');
        $guzzleProperty->setAccessible(true);
        $guzzleProperty->setValue($client, $mockGuzzle);

        $this->expectException(RequestError::class);
        $this->expectExceptionMessage('Unable to parse JSON response');
        $client->get('/v1/test');
    }

    public function testHandlesTimeoutErrors(): void
    {
        $mockGuzzle = $this->createMock(GuzzleClient::class);
        $mockGuzzle->method('send')
            ->willThrowException(new RequestException(
                'Request timed out',
                new Request('GET', 'https://api.stytch.com/v1/test'),
                new Response(408),
            ));

        $client = new Client([
            'project_id' => 'test_project',
            'secret' => 'test_secret',
        ]);

        $reflection = new \ReflectionClass($client);
        $guzzleProperty = $reflection->getProperty('httpClient');
        $guzzleProperty->setAccessible(true);
        $guzzleProperty->setValue($client, $mockGuzzle);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Request timed out');
        $client->get('/v1/test');
    }

    public function testThrowsInvalidArgumentExceptionOnInvalidJsonData(): void
    {
        $client = new Client([
            'project_id' => 'test_project',
            'secret' => 'test_secret',
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid JSON data');
        $resource = fopen('php://temp', 'r');
        $client->post('/v1/test', ['invalid_data' => $resource]);
        if ($resource !== false) {
            fclose($resource);
        }
    }
}
