<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\Sessions;
use Stytch\Objects\Response\SessionResponse;
use Stytch\Shared\Client;

class SessionsTest extends TestCase
{
    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/sessions/authenticate', ['session_token' => 'token123'])
            ->willReturn([
                'request_id' => 'req123',
                'status_code' => 200,
                'session_token' => 'session123',
                'session_jwt' => 'jwt123',
                'member_id' => 'mem123',
                'organization_id' => 'org123',
                'member' => [
                    'organization_id' => 'org123',
                    'member_id' => 'mem123',
                    'email_address' => 'user@example.com',
                    'status' => 'active',
                    'name' => 'Test User',
                    'sso_registrations' => [],
                    'is_breakglass' => false,
                    'member_password_id' => 'pwd123',
                    'oauth_registrations' => [],
                    'email_address_verified' => true,
                    'mfa_phone_number_verified' => false,
                    'is_admin' => false,
                    'totp_registration_id' => '',
                    'retired_email_addresses' => [],
                    'is_locked' => false,
                    'mfa_enrolled' => false,
                    'mfa_phone_number' => '',
                    'default_mfa_method' => '',
                    'roles' => [],
                    'trusted_metadata' => [],
                    'untrusted_metadata' => [],
                    'created_at' => '2023-01-01T00:00:00Z',
                    'updated_at' => '2023-01-01T00:00:00Z',
                ],
                'organization' => [
                    'organization_id' => 'org123',
                    'organization_name' => 'Acme Co',
                    'organization_logo_url' => '',
                    'organization_slug' => 'acme-co',
                    'sso_jit_provisioning' => 'ALL_ALLOWED',
                    'sso_jit_provisioning_allowed_connections' => [],
                    'sso_active_connections' => [],
                    'email_allowed_domains' => [],
                    'email_jit_provisioning' => 'ALL_ALLOWED',
                    'email_invites' => 'ALL_ALLOWED',
                    'auth_methods' => 'ALL_ALLOWED',
                    'allowed_auth_methods' => [],
                    'mfa_policy' => 'OPTIONAL',
                    'rbac_email_implicit_role_assignments' => [],
                    'mfa_methods' => 'ALL_ALLOWED',
                    'allowed_mfa_methods' => [],
                    'oauth_tenant_jit_provisioning' => 'ALL_ALLOWED',
                    'claimed_email_domains' => [],
                    'first_party_connected_apps_allowed_type' => 'ALL_ALLOWED',
                    'allowed_first_party_connected_apps' => [],
                    'third_party_connected_apps_allowed_type' => 'ALL_ALLOWED',
                    'allowed_third_party_connected_apps' => [],
                ],
                'member_session' => [
                    'member_session_id' => 'sess123',
                    'member_id' => 'mem123',
                    'organization_id' => 'org123',
                    'started_at' => '2023-01-01T00:00:00Z',
                    'last_accessed_at' => '2023-01-01T00:00:00Z',
                    'expires_at' => '2023-01-02T00:00:00Z',
                    'attributes' => [],
                    'custom_claims' => [],
                    'authentication_factors' => [],
                    'reauthentication_required' => false,
                    'roles' => [],
                    'scopes' => [],
                ],
            ]);

        $sessions = new Sessions($mock);
        $sessions->authenticate(['session_token' => 'token123']);
    }

    public function testGetCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/b2b/sessions/session123')
            ->willReturn(['session' => []]);

        $sessions = new Sessions($mock);
        $result = $sessions->get('session123');
        $this->assertSame(['session' => []], $result);
    }

    public function testRevokeCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/b2b/sessions/session123')
            ->willReturn(['revoked' => true]);

        $sessions = new Sessions($mock);
        $result = $sessions->revoke('session123');
        $this->assertSame(['revoked' => true], $result);
    }

    public function testExchangeCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/sessions/exchange', ['session_token' => 'token123'])
            ->willReturn(['exchanged' => true]);

        $sessions = new Sessions($mock);
        $result = $sessions->exchange(['session_token' => 'token123']);
        $this->assertSame(['exchanged' => true], $result);
    }

    public function testGetJwksCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('getProjectId')
            ->willReturn('project123');
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/b2b/sessions/jwks/project123')
            ->willReturn(['keys' => []]);

        $sessions = new Sessions($mock);
        $result = $sessions->getJWKS();
        $this->assertSame(['keys' => []], $result);
    }
}
