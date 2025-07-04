<?php

namespace Stytch\Tests\Shared;

use PHPUnit\Framework\TestCase;
use Stytch\Shared\Client;
use Stytch\Shared\Errors\NoProjectIdException;
use Stytch\Shared\Errors\NoSecretException;
use Stytch\Shared\Errors\InvalidBaseUrlException;

class ClientConfigTest extends TestCase
{
    public function testThrowsNoProjectIdException(): void
    {
        $this->expectException(NoProjectIdException::class);
        $this->expectExceptionMessage('Missing "project_id" in config');

        new Client([
            'secret' => 'test-secret',
        ]);
    }

    public function testThrowsNoSecretException(): void
    {
        $this->expectException(NoSecretException::class);
        $this->expectExceptionMessage('Missing "secret" in config');

        new Client([
            'project_id' => 'project-test-123',
        ]);
    }

    public function testThrowsInvalidBaseUrlException(): void
    {
        $this->expectException(InvalidBaseUrlException::class);
        $this->expectExceptionMessage('custom_base_url must use HTTPS scheme');

        new Client([
            'project_id' => 'project-test-123',
            'secret' => 'test-secret',
            'custom_base_url' => 'http://insecure-url.com',
        ]);
    }

    public function testAcceptsValidConfig(): void
    {
        $client = new Client([
            'project_id' => 'project-test-123',
            'secret' => 'test-secret',
        ]);

        $this->assertEquals('project-test-123', $client->getProjectId());
    }

    public function testAcceptsValidConfigWithCustomBaseUrl(): void
    {
        $client = new Client([
            'project_id' => 'project-test-123',
            'secret' => 'test-secret',
            'custom_base_url' => 'https://custom-api.example.com',
        ]);

        $this->assertEquals('https://custom-api.example.com/', $client->getBaseURL());
    }
}
