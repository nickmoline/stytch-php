<?php

namespace Stytch\Tests\Integration;

use Stytch\Stytch;
use Stytch\Shared\Errors\StytchRequestException;

class B2BIntegrationTest extends BaseIntegration
{
    private Stytch $stytch;

    protected function setUp(): void
    {
        parent::setUp();

        // Use test credentials - these should be invalid but won't cause network errors
        $this->stytch = $this->invalidCredentialsStytch();
    }

    public function testOrganizationsCreateWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2b()->organizations->create([
            'organization_name' => 'Test Organization',
            'organization_slug' => 'test-org',
        ]);
    }

    public function testOrganizationsGetWithInvalidOrganizationId(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2b()->organizations->get('invalid-org-id');
    }

    public function testMagicLinksLoginWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2b()->magicLinks->login([
            'email' => 'test@example.com',
            'organization_id' => 'invalid-org-id',
        ]);
    }

    public function testOTPsSmsWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2b()->otps->sms->send([
            'phone_number' => '+1234567890',
            'organization_id' => 'invalid-org-id',
        ]);
    }

    public function testPasswordsAuthenticateWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2b()->passwords->authenticate([
            'email' => 'test@example.com',
            'password' => 'testpassword123',
            'organization_id' => 'invalid-org-id',
        ]);
    }

    public function testSessionsGetWithInvalidSessionId(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2b()->sessions->get('invalid-session-id');
    }

    public function testSessionsAuthenticateWithInvalidToken(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2b()->sessions->authenticate([
            'session_token' => 'invalid-token',
        ]);
    }

    public function testSessionsRevokeWithInvalidSessionId(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2b()->sessions->revoke('invalid-session-id');
    }

    public function testSessionsGetJWKSWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2b()->sessions->getJWKS();
    }

    public function testOrganizationsCreateWithRealCredentials(): void
    {
        if (!$this->shouldRunIntegrationTests()) {
            $this->markTestSkipped('Integration tests not enabled. Set RUN_INTEGRATION_TESTS=true to run.');
        }

        $stytch = $this->validCredentialsStytch();

        $response = $stytch->b2b()->organizations->create([
            'organization_name' => 'Test Org ' . time(),
            'organization_slug' => 'test-org-' . time() . '-' . uniqid(),
        ]);

        $this->assertEquals(200, $response->status_code);
        $this->assertNotEmpty($response->organization->organization_id);
    }

    public function testMagicLinksLoginWithRealCredentials(): void
    {
        $this->markTestSkipped('TODO: Enable after registering redirect URLs in Stytch dashboard.');
    }

    public function testSessionsGetJWKSWithRealCredentials(): void
    {
        if (!$this->shouldRunIntegrationTests()) {
            $this->markTestSkipped('Integration tests not enabled. Set RUN_INTEGRATION_TESTS=true to run.');
        }

        $stytch = $this->validCredentialsStytch();

        $response = $stytch->b2b()->sessions->getJWKS();

        $this->assertArrayHasKey('status_code', $response);
        $this->assertEquals(200, $response['status_code']);
    }
}
