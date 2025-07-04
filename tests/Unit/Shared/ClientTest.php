<?php

namespace Stytch\Tests\Shared;

use PHPUnit\Framework\TestCase;
use Stytch\Shared\Client;

class ClientTest extends TestCase
{
    public function testConfigIsNotAnObject(): void
    {
        $this->expectException(\TypeError::class);
        /** @var mixed $invalidConfig */
        $invalidConfig = 0;
        new Client($invalidConfig);
    }

    public function testMissingProjectId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing "project_id" in config');
        new Client([
            'project_id' => '',
            'secret' => 'secret-test-11111111-1111-4111-8111-111111111111',
        ]);
    }

    public function testMissingSecret(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing "secret" in config');
        new Client([
            'project_id' => 'project-test-00000000-0000-4000-8000-000000000000',
            'secret' => '',
        ]);
    }

    public function testCustomBaseUrlIsUsed(): void
    {
        $client = new Client([
            'project_id' => 'project-test-00000000-0000-4000-8000-000000000000',
            'secret' => 'secret-test-11111111-1111-4111-8111-111111111111',
            'custom_base_url' => 'https://cname.customer.com/',
        ]);

        $this->assertEquals('https://cname.customer.com/', $client->getBaseURL());
    }

    public function testRequiresHttpsScheme(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('custom_base_url must use HTTPS scheme');
        new Client([
            'project_id' => 'project-test-00000000-0000-4000-8000-000000000000',
            'secret' => 'secret-test-123',
            'custom_base_url' => 'cname.customer.com',
        ]);
    }

    public function testTestEnvironmentDetection(): void
    {
        $client = new Client([
            'project_id' => 'project-test-00000000-0000-4000-8000-000000000000',
            'secret' => 'secret-test-11111111-1111-4111-8111-111111111111',
        ]);

        $this->assertEquals('https://test.stytch.com/', $client->getBaseURL());
    }

    public function testLiveEnvironmentDetection(): void
    {
        $client = new Client([
            'project_id' => 'project-live-00000000-0000-4000-8000-000000000000',
            'secret' => 'secret-live-11111111-1111-4111-8111-111111111111',
        ]);

        $this->assertEquals('https://api.stytch.com/', $client->getBaseURL());
    }

    public function testCustomTimeout(): void
    {
        $client = new Client([
            'project_id' => 'project-test-00000000-0000-4000-8000-000000000000',
            'secret' => 'secret-test-11111111-1111-4111-8111-111111111111',
            'timeout' => 300,
        ]);

        $this->assertEquals('project-test-00000000-0000-4000-8000-000000000000', $client->getProjectId());
        $this->assertEquals('https://test.stytch.com/', $client->getBaseURL());
    }

    public function testBaseUrlTrailingSlashHandling(): void
    {
        $client = new Client([
            'project_id' => 'project-test-00000000-0000-4000-8000-000000000000',
            'secret' => 'secret-test-11111111-1111-4111-8111-111111111111',
            'custom_base_url' => 'https://cname.customer.com',
        ]);

        $this->assertEquals('https://cname.customer.com/', $client->getBaseURL());
    }

    public function testBaseUrlMultipleTrailingSlashesHandling(): void
    {
        $client = new Client([
            'project_id' => 'project-test-00000000-0000-4000-8000-000000000000',
            'secret' => 'secret-test-11111111-1111-4111-8111-111111111111',
            'custom_base_url' => 'https://cname.customer.com///',
        ]);

        $this->assertEquals('https://cname.customer.com/', $client->getBaseURL());
    }
}
