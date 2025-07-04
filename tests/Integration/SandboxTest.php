<?php

namespace Stytch\Tests\Integration;

use Stytch\Stytch;
use Stytch\Shared\Errors\StytchRequestException;

class SandboxTest extends BaseIntegration
{
    public function testMagicLinksAuthenticateWithValidCredentials(): void
    {
        if (!$this->shouldRunIntegrationTests()) {
            $this->markTestSkipped('Integration tests not enabled. Set RUN_INTEGRATION_TESTS=true to run.');
        }

        $client = $this->validCredentialsStytch();

        $result = $client->b2c()->magicLinks->authenticate([
            'token' => 'DOYoip3rvIMMW5lgItikFK-Ak1CfMsgjuiCyI7uuU94=',
        ]);

        $this->assertEquals(200, $result['status_code']);
        $this->assertEquals('user-test-e3795c81-f849-4167-bfda-e4a6e9c280fd', $result['user_id']);
    }

    public function testMagicLinksAuthenticateWithInvalidToken(): void
    {
        $client = $this->invalidCredentialsStytch();

        $this->expectException(StytchRequestException::class);

        $client->b2c()->magicLinks->authenticate([
            'token' => 'invalid-token',
        ]);
    }

    public function testMagicLinksAuthenticateNotAuthorized(): void
    {
        if (!$this->shouldRunIntegrationTests()) {
            $this->markTestSkipped('Integration tests not enabled. Set RUN_INTEGRATION_TESTS=true to run.');
        }

        $client = $this->validCredentialsStytch();

        $this->expectException(StytchRequestException::class);

        $client->b2c()->magicLinks->authenticate([
            'token' => '3pzjQpgksDlGKWEwUq2Up--hCHC_0oamfLHyfspKDFU=',
        ]);
    }

    public function testMagicLinksAuthenticateNotFound(): void
    {
        if (!$this->shouldRunIntegrationTests()) {
            $this->markTestSkipped('Integration tests not enabled. Set RUN_INTEGRATION_TESTS=true to run.');
        }

        $client = $this->validCredentialsStytch();

        $this->expectException(StytchRequestException::class);

        $client->b2c()->magicLinks->authenticate([
            'token' => 'CprTtwhnRNiMBiUS2jSLcWYrfuO2POeBNdo5HhW6qTM=',
        ]);
    }

    /**
     * @todo Enable this test after ensuring the redirect URLs are registered in the Stytch dashboard.
     */
    public function testMagicLinksEmailLoginOrCreate(): void
    {
        $this->markTestSkipped('TODO: Enable after registering redirect URLs in Stytch dashboard.');
    }

    /**
     * @todo Enable this test after ensuring the invite redirect URLs are registered in the Stytch dashboard.
     */
    public function testMagicLinksEmailInvite(): void
    {
        $this->markTestSkipped('TODO: Enable after registering invite redirect URLs in Stytch dashboard.');
    }

    public function testMagicLinksEmailRevokeInvite(): void
    {
        if (!$this->shouldRunIntegrationTests()) {
            $this->markTestSkipped('Integration tests not enabled. Set RUN_INTEGRATION_TESTS=true to run.');
        }

        $client = $this->validCredentialsStytch();

        $result = $client->b2c()->magicLinks->email->revokeInvite([
            'email' => 'sandbox@stytch.com',
        ]);

        $this->assertEquals(200, $result['status_code']);
    }

    public function testSessionsAuthenticate(): void
    {
        if (!$this->shouldRunIntegrationTests()) {
            $this->markTestSkipped('Integration tests not enabled. Set RUN_INTEGRATION_TESTS=true to run.');
        }

        $client = $this->validCredentialsStytch();

        $result = $client->b2c()->sessions->authenticate([
            'session_token' => 'WJtR5BCy38Szd5AfoDpf0iqFKEt4EE5JhjlWUY7l3FtY',
        ]);

        $this->assertEquals(200, $result['status_code']);
        $this->assertEquals('WJtR5BCy38Szd5AfoDpf0iqFKEt4EE5JhjlWUY7l3FtY', $result['session_token']);
        $this->assertEquals('user-test-e3795c81-f849-4167-bfda-e4a6e9c280fd', $result['session']['user_id']);
    }

    public function testSessionsAuthenticateNotFound(): void
    {
        if (!$this->shouldRunIntegrationTests()) {
            $this->markTestSkipped('Integration tests not enabled. Set RUN_INTEGRATION_TESTS=true to run.');
        }

        $client = $this->validCredentialsStytch();

        $this->expectException(StytchRequestException::class);

        $client->b2c()->sessions->authenticate([
            'session_token' => '59cnLELtq5cFVS6uYK9f-pAWzBkhqZl8AvLhbhOvKNWw',
        ]);
    }

    public function testSessionsAuthenticateWithInvalidToken(): void
    {
        $client = $this->invalidCredentialsStytch();

        $this->expectException(StytchRequestException::class);

        $client->b2c()->sessions->authenticate([
            'session_token' => 'invalid-token',
        ]);
    }
}
