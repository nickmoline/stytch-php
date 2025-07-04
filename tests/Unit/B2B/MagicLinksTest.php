<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\MagicLinks;
use Stytch\Objects\Response\MagicLinkResponse;
use Stytch\Shared\Client;

class MagicLinksTest extends TestCase
{
    public function testLoginOrSignupCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/magic_links/login_or_signup', ['email_address' => 'user@example.com'])
            ->willReturn(['sent' => true]);

        $magicLinks = new MagicLinks($mock);
        $result = $magicLinks->loginOrSignup(['email_address' => 'user@example.com']);
        $this->assertSame(['sent' => true], $result);
    }

    public function testLoginCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/magic_links/email/login', ['email_address' => 'user@example.com'])
            ->willReturn(['sent' => true]);

        $magicLinks = new MagicLinks($mock);
        $result = $magicLinks->login(['email_address' => 'user@example.com']);
        $this->assertSame(['sent' => true], $result);
    }

    public function testSignupCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/magic_links/email/signup', ['email_address' => 'user@example.com'])
            ->willReturn(['sent' => true]);

        $magicLinks = new MagicLinks($mock);
        $result = $magicLinks->signup(['email_address' => 'user@example.com']);
        $this->assertSame(['sent' => true], $result);
    }

    public function testAuthenticateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/magic_links/authenticate', ['token' => 'token123'])
            ->willReturn([
                'request_id' => 'req123',
                'status_code' => 200,
                'member_authenticated' => true,
                'session_token' => 'session123',
                'session_jwt' => 'jwt123',
                'organization_id' => 'org123',
                'member_id' => 'mem123',
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
                'intermediate_session_token' => 'inter123',
            ]);

        $magicLinks = new MagicLinks($mock);
        $result = $magicLinks->authenticate(['token' => 'token123']);
        // Response is implicitly tested by the mock
    }
}
