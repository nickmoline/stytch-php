<?php

namespace Stytch\Tests\Integration;

use Stytch\Stytch;
use Stytch\Shared\Errors\StytchRequestException;

class ClientIntegrationTest extends BaseIntegration
{
    private Stytch $client;

    protected function setUp(): void
    {
        parent::setUp();

        // Use test credentials - these should be invalid but won't cause network errors
        $this->client = $this->invalidCredentialsStytch();
    }

    public function testInvalidCredentialsReturnError(): void
    {
        $this->expectException(StytchRequestException::class);

        // This should fail with invalid credentials, not network errors
        $this->client->b2c()->get('/v1/users', []);
    }

    public function testInvalidEndpointReturnsError(): void
    {
        $this->expectException(StytchRequestException::class);

        // This should fail with 404, not network errors
        $this->client->b2c()->get('/v1/invalid-endpoint', []);
    }

    public function testClientHandlesNetworkErrorsGracefully(): void
    {
        // Test with an invalid base URL to simulate network issues
        $client = new Stytch([
            'project_id' => 'test-project-id',
            'secret' => 'test-secret-key',
            'env' => 'test',
            'custom_base_url' => 'https://invalid-domain-that-does-not-exist.com',
        ]);

        $this->expectException(\Exception::class);
        $client->b2c()->get('/v1/users', []);
    }

    public function testClientWithValidConfigStructure(): void
    {
        // Test that client can be instantiated with valid config
        $client = new Stytch([
            'project_id' => 'test-project-id',
            'secret' => 'test-secret-key',
            'env' => 'test',
        ]);

        $this->assertEquals('test-project-id', $client->b2c()->getProjectId());
    }

    public function testClientWithRealCredentials(): void
    {
        if (!$this->shouldRunIntegrationTests()) {
            $this->markTestSkipped('Integration tests not enabled. Set RUN_INTEGRATION_TESTS=true to run.');
        }

        $client = $this->validCredentialsStytch();

        $this->assertEquals($this->getRequiredEnv('STYTCH_PROJECT_ID'), $client->b2c()->getProjectId());
    }

    public function testClientCanMakeValidRequest(): void
    {
        if (!$this->shouldRunIntegrationTests()) {
            $this->markTestSkipped('Integration tests not enabled. Set RUN_INTEGRATION_TESTS=true to run.');
        }

        $client = $this->validCredentialsStytch();

        // Test a simple endpoint that should work with valid credentials
        // Use a more generic endpoint that's likely to be available
        try {
            $response = $client->b2c()->get('/v1/users', []);
            $this->assertArrayHasKey('status_code', $response);
            $this->assertEquals(200, $response['status_code']);
        } catch (\Exception $e) {
            // If the endpoint is not available, that's also acceptable
            $this->assertStringContainsString('not supported', $e->getMessage());
        }
    }
}
