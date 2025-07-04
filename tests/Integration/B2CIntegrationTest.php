<?php

namespace Stytch\Tests\Integration;

use Stytch\Stytch;
use Stytch\Shared\Errors\StytchRequestException;

class B2CIntegrationTest extends BaseIntegration
{
    private Stytch $stytch;

    protected function setUp(): void
    {
        parent::setUp();

        // Use test credentials - these should be invalid but won't cause network errors
        $this->stytch = $this->invalidCredentialsStytch();
    }

    public function testUsersCreateWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2c()->users->create([
            'email' => 'test@example.com',
            'name' => [
                'first_name' => 'Test',
                'last_name' => 'User',
            ],
        ]);
    }

    public function testUsersGetWithInvalidUserId(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2c()->users->get('invalid-user-id');
    }

    public function testMagicLinksEmailWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2c()->magicLinks->email->loginOrCreate([
            'email' => 'test@example.com',
        ]);
    }

    public function testOTPsSmsWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2c()->otps->sms->send([
            'phone_number' => '+1234567890',
        ]);
    }

    public function testPasswordsCreateWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2c()->passwords->create([
            'email' => 'test@example.com',
            'password' => 'testpassword123',
        ]);
    }

    public function testSessionsGetWithInvalidSessionId(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2c()->sessions->get(['session_id' => 'invalid-session-id']);
    }

    public function testOAuthStartWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2c()->oauth->start([
            'provider_type' => 'google',
            'login_redirect_url' => 'https://example.com/callback',
        ]);
    }

    public function testWebAuthnRegisterStartWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2c()->webauthn->registerStart([
            'user_id' => 'invalid-user-id',
        ]);
    }

    public function testCryptoWalletsAuthenticateWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2c()->cryptoWallets->authenticate([
            'wallet_type' => 'ethereum',
            'wallet_address' => '0x1234567890123456789012345678901234567890',
            'signature' => 'invalid-signature',
            'signature_type' => 'personal_sign',
        ]);
    }

    public function testProjectGetWithInvalidCredentials(): void
    {
        $this->expectException(StytchRequestException::class);

        $this->stytch->b2c()->project->get();
    }

    public function testProjectGetWithRealCredentials(): void
    {
        if (!$this->shouldRunIntegrationTests()) {
            $this->markTestSkipped('Integration tests not enabled. Set RUN_INTEGRATION_TESTS=true to run.');
        }

        $stytch = $this->validCredentialsStytch();

        // Try to get project info - this might fail if the project doesn't support this endpoint
        try {
            $response = $stytch->b2c()->project->get();
            $this->assertArrayHasKey('status_code', $response);
            $this->assertEquals(200, $response['status_code']);
        } catch (\Exception $e) {
            // If the endpoint is not supported, that's also acceptable for this test
            $this->assertStringContainsString('not supported', $e->getMessage());
        }
    }

    public function testUsersCreateWithRealCredentials(): void
    {
        if (!$this->shouldRunIntegrationTests()) {
            $this->markTestSkipped('Integration tests not enabled. Set RUN_INTEGRATION_TESTS=true to run.');
        }

        $stytch = $this->validCredentialsStytch();

        // Try to create a user - this might fail if the project is B2B only
        try {
            $response = $stytch->b2c()->users->create([
                'email' => 'test-' . time() . '@example.com',
                'name' => [
                    'first_name' => 'Test',
                    'last_name' => 'User',
                ],
            ]);

            $this->assertArrayHasKey('status_code', $response);
            $this->assertEquals(200, $response['status_code']);
            $this->assertArrayHasKey('user_id', $response);
        } catch (\Exception $e) {
            // If the endpoint is only for consumer projects, that's also acceptable
            $this->assertStringContainsString('consumer projects', $e->getMessage());
        }
    }

    /**
     * @todo Enable this test after ensuring the redirect URLs are registered in the Stytch dashboard.
     */
    public function testMagicLinksEmailLoginOrCreateWithRealCredentials(): void
    {
        $this->markTestSkipped('TODO: Enable after registering redirect URLs in Stytch dashboard.');
    }
}
