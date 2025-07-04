<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\MagicLinkResponse;
use Stytch\Objects\Session;
use Stytch\Objects\Member;
use Stytch\Objects\Organization;

class MagicLinkResponseTest extends TestCase
{
    public function testConstructor(): void
    {
        $member = Member::fromArray([
            'member_id' => 'member_123',
            'organization_id' => 'org_123',
            'email_address' => 'test@example.com',
            'status' => 'active',
            'name' => 'Test Member',
            'sso_registrations' => [],
            'is_breakglass' => false,
            'member_password_id' => 'password_123',
            'oauth_registrations' => [],
            'email_address_verified' => true,
            'mfa_phone_number_verified' => false,
            'is_admin' => false,
            'totp_registration_id' => 'totp_123',
            'retired_email_addresses' => [],
            'is_locked' => false,
            'mfa_enrolled' => false,
            'mfa_phone_number' => '+1234567890',
            'default_mfa_method' => 'sms',
            'roles' => [],
        ]);

        $organization = Organization::fromArray([
            'organization_id' => 'org_123',
            'organization_name' => 'Test Org',
            'organization_logo_url' => 'https://example.com/logo.png',
            'organization_slug' => 'test-org',
            'sso_jit_provisioning' => 'RESTRICTED',
            'sso_jit_provisioning_allowed_connections' => [],
            'sso_active_connections' => [],
            'email_allowed_domains' => ['example.com'],
            'email_jit_provisioning' => 'RESTRICTED',
            'email_invites' => 'ENABLED',
            'auth_methods' => 'sso',
            'allowed_auth_methods' => ['sso'],
            'mfa_policy' => 'OPTIONAL',
            'rbac_email_implicit_role_assignments' => [],
            'mfa_methods' => 'sms',
            'allowed_mfa_methods' => ['sms'],
            'oauth_tenant_jit_provisioning' => 'RESTRICTED',
            'claimed_email_domains' => [],
            'first_party_connected_apps_allowed_type' => 'ALL',
            'allowed_first_party_connected_apps' => [],
            'third_party_connected_apps_allowed_type' => 'ALL',
            'allowed_third_party_connected_apps' => [],
        ]);

        $response = new MagicLinkResponse(
            'test_request_id',
            200,
            'member_123',
            'org_123',
            $member,
            $organization,
            'session_token_456',
            'session_jwt_789',
            'intermediate_session_token_012',
            true
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('member_123', $response->member_id);
        $this->assertEquals('org_123', $response->organization_id);
        $this->assertSame($member, $response->member);
        $this->assertSame($organization, $response->organization);
        $this->assertEquals('session_token_456', $response->session_token);
        $this->assertEquals('session_jwt_789', $response->session_jwt);
        $this->assertEquals('intermediate_session_token_012', $response->intermediate_session_token);
        $this->assertTrue($response->member_authenticated);
        $this->assertNull($response->member_session);
    }

    public function testConstructorWithMemberSession(): void
    {
        $member = Member::fromArray([
            'member_id' => 'member_123',
            'organization_id' => 'org_123',
            'email_address' => 'test@example.com',
            'status' => 'active',
            'name' => 'Test Member',
            'sso_registrations' => [],
            'is_breakglass' => false,
            'member_password_id' => 'password_123',
            'oauth_registrations' => [],
            'email_address_verified' => true,
            'mfa_phone_number_verified' => false,
            'is_admin' => false,
            'totp_registration_id' => 'totp_123',
            'retired_email_addresses' => [],
            'is_locked' => false,
            'mfa_enrolled' => false,
            'mfa_phone_number' => '+1234567890',
            'default_mfa_method' => 'sms',
            'roles' => [],
        ]);

        $organization = Organization::fromArray([
            'organization_id' => 'org_123',
            'organization_name' => 'Test Org',
            'organization_logo_url' => 'https://example.com/logo.png',
            'organization_slug' => 'test-org',
            'sso_jit_provisioning' => 'RESTRICTED',
            'sso_jit_provisioning_allowed_connections' => [],
            'sso_active_connections' => [],
            'email_allowed_domains' => ['example.com'],
            'email_jit_provisioning' => 'RESTRICTED',
            'email_invites' => 'ENABLED',
            'auth_methods' => 'sso',
            'allowed_auth_methods' => ['sso'],
            'mfa_policy' => 'OPTIONAL',
            'rbac_email_implicit_role_assignments' => [],
            'mfa_methods' => 'sms',
            'allowed_mfa_methods' => ['sms'],
            'oauth_tenant_jit_provisioning' => 'RESTRICTED',
            'claimed_email_domains' => [],
            'first_party_connected_apps_allowed_type' => 'ALL',
            'allowed_first_party_connected_apps' => [],
            'third_party_connected_apps_allowed_type' => 'ALL',
            'allowed_third_party_connected_apps' => [],
        ]);

        $memberSession = Session::fromArray([
            'member_session_id' => 'session_123',
            'member_id' => 'member_123',
            'started_at' => '2023-01-01T12:00:00Z',
            'last_accessed_at' => '2023-01-01T13:00:00Z',
            'expires_at' => '2023-01-02T12:00:00Z',
            'authentication_factors' => [],
            'organization_id' => 'org_123',
            'roles' => [],
        ]);

        $response = new MagicLinkResponse(
            'test_request_id',
            200,
            'member_123',
            'org_123',
            $member,
            $organization,
            'session_token_456',
            'session_jwt_789',
            'intermediate_session_token_012',
            true,
            $memberSession
        );

        $this->assertEquals('test_request_id', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('member_123', $response->member_id);
        $this->assertEquals('org_123', $response->organization_id);
        $this->assertSame($member, $response->member);
        $this->assertSame($organization, $response->organization);
        $this->assertEquals('session_token_456', $response->session_token);
        $this->assertEquals('session_jwt_789', $response->session_jwt);
        $this->assertEquals('intermediate_session_token_012', $response->intermediate_session_token);
        $this->assertTrue($response->member_authenticated);
        $this->assertSame($memberSession, $response->member_session);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'member_id' => 'member_456',
            'organization_id' => 'org_456',
            'member' => [
                'member_id' => 'member_456',
                'organization_id' => 'org_456',
                'email_address' => 'test2@example.com',
                'status' => 'active',
                'name' => 'Test Member 2',
                'sso_registrations' => [],
                'is_breakglass' => false,
                'member_password_id' => 'password_456',
                'oauth_registrations' => [],
                'email_address_verified' => true,
                'mfa_phone_number_verified' => false,
                'is_admin' => false,
                'totp_registration_id' => 'totp_456',
                'retired_email_addresses' => [],
                'is_locked' => false,
                'mfa_enrolled' => false,
                'mfa_phone_number' => '+1234567891',
                'default_mfa_method' => 'sms',
                'roles' => [],
            ],
            'organization' => [
                'organization_id' => 'org_456',
                'organization_name' => 'Test Org 2',
                'organization_logo_url' => 'https://example.com/logo2.png',
                'organization_slug' => 'test-org-2',
                'sso_jit_provisioning' => 'RESTRICTED',
                'sso_jit_provisioning_allowed_connections' => [],
                'sso_active_connections' => [],
                'email_allowed_domains' => ['example2.com'],
                'email_jit_provisioning' => 'RESTRICTED',
                'email_invites' => 'ENABLED',
                'auth_methods' => 'sso',
                'allowed_auth_methods' => ['sso'],
                'mfa_policy' => 'OPTIONAL',
                'rbac_email_implicit_role_assignments' => [],
                'mfa_methods' => 'sms',
                'allowed_mfa_methods' => ['sms'],
                'oauth_tenant_jit_provisioning' => 'RESTRICTED',
                'claimed_email_domains' => [],
                'first_party_connected_apps_allowed_type' => 'ALL',
                'allowed_first_party_connected_apps' => [],
                'third_party_connected_apps_allowed_type' => 'ALL',
                'allowed_third_party_connected_apps' => [],
            ],
            'session_token' => 'session_token_789',
            'session_jwt' => 'session_jwt_012',
            'intermediate_session_token' => 'intermediate_session_token_345',
            'member_authenticated' => false,
        ];

        $response = MagicLinkResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('member_456', $response->member_id);
        $this->assertEquals('org_456', $response->organization_id);
        $this->assertInstanceOf(Member::class, $response->member);
        $this->assertInstanceOf(Organization::class, $response->organization);
        $this->assertEquals('session_token_789', $response->session_token);
        $this->assertEquals('session_jwt_012', $response->session_jwt);
        $this->assertEquals('intermediate_session_token_345', $response->intermediate_session_token);
        $this->assertFalse($response->member_authenticated);
        $this->assertNull($response->member_session);
    }

    public function testFromArrayWithMemberSession(): void
    {
        $data = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'member_id' => 'member_456',
            'organization_id' => 'org_456',
            'member' => [
                'member_id' => 'member_456',
                'organization_id' => 'org_456',
                'email_address' => 'test2@example.com',
                'status' => 'active',
                'name' => 'Test Member 2',
                'sso_registrations' => [],
                'is_breakglass' => false,
                'member_password_id' => 'password_456',
                'oauth_registrations' => [],
                'email_address_verified' => true,
                'mfa_phone_number_verified' => false,
                'is_admin' => false,
                'totp_registration_id' => 'totp_456',
                'retired_email_addresses' => [],
                'is_locked' => false,
                'mfa_enrolled' => false,
                'mfa_phone_number' => '+1234567891',
                'default_mfa_method' => 'sms',
                'roles' => [],
            ],
            'organization' => [
                'organization_id' => 'org_456',
                'organization_name' => 'Test Org 2',
                'organization_logo_url' => 'https://example.com/logo2.png',
                'organization_slug' => 'test-org-2',
                'sso_jit_provisioning' => 'RESTRICTED',
                'sso_jit_provisioning_allowed_connections' => [],
                'sso_active_connections' => [],
                'email_allowed_domains' => ['example2.com'],
                'email_jit_provisioning' => 'RESTRICTED',
                'email_invites' => 'ENABLED',
                'auth_methods' => 'sso',
                'allowed_auth_methods' => ['sso'],
                'mfa_policy' => 'OPTIONAL',
                'rbac_email_implicit_role_assignments' => [],
                'mfa_methods' => 'sms',
                'allowed_mfa_methods' => ['sms'],
                'oauth_tenant_jit_provisioning' => 'RESTRICTED',
                'claimed_email_domains' => [],
                'first_party_connected_apps_allowed_type' => 'ALL',
                'allowed_first_party_connected_apps' => [],
                'third_party_connected_apps_allowed_type' => 'ALL',
                'allowed_third_party_connected_apps' => [],
            ],
            'session_token' => 'session_token_789',
            'session_jwt' => 'session_jwt_012',
            'intermediate_session_token' => 'intermediate_session_token_345',
            'member_authenticated' => true,
            'member_session' => [
                'member_session_id' => 'session_456',
                'member_id' => 'member_456',
                'started_at' => '2023-01-01T12:00:00Z',
                'last_accessed_at' => '2023-01-01T13:00:00Z',
                'expires_at' => '2023-01-02T12:00:00Z',
                'authentication_factors' => [],
                'organization_id' => 'org_456',
                'roles' => [],
            ],
        ];

        $response = MagicLinkResponse::fromArray($data);

        $this->assertEquals('abc123', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('member_456', $response->member_id);
        $this->assertEquals('org_456', $response->organization_id);
        $this->assertInstanceOf(Member::class, $response->member);
        $this->assertInstanceOf(Organization::class, $response->organization);
        $this->assertEquals('session_token_789', $response->session_token);
        $this->assertEquals('session_jwt_012', $response->session_jwt);
        $this->assertEquals('intermediate_session_token_345', $response->intermediate_session_token);
        $this->assertTrue($response->member_authenticated);
        $this->assertInstanceOf(Session::class, $response->member_session);
        $this->assertEquals('session_456', $response->member_session->member_session_id);
    }

    public function testToArray(): void
    {
        $member = Member::fromArray([
            'member_id' => 'member_123',
            'organization_id' => 'org_123',
            'email_address' => 'test@example.com',
            'status' => 'active',
            'name' => 'Test Member',
            'sso_registrations' => [],
            'is_breakglass' => false,
            'member_password_id' => 'password_123',
            'oauth_registrations' => [],
            'email_address_verified' => true,
            'mfa_phone_number_verified' => false,
            'is_admin' => false,
            'totp_registration_id' => 'totp_123',
            'retired_email_addresses' => [],
            'is_locked' => false,
            'mfa_enrolled' => false,
            'mfa_phone_number' => '+1234567890',
            'default_mfa_method' => 'sms',
            'roles' => [],
        ]);

        $organization = Organization::fromArray([
            'organization_id' => 'org_123',
            'organization_name' => 'Test Org',
            'organization_logo_url' => 'https://example.com/logo.png',
            'organization_slug' => 'test-org',
            'sso_jit_provisioning' => 'RESTRICTED',
            'sso_jit_provisioning_allowed_connections' => [],
            'sso_active_connections' => [],
            'email_allowed_domains' => ['example.com'],
            'email_jit_provisioning' => 'RESTRICTED',
            'email_invites' => 'ENABLED',
            'auth_methods' => 'sso',
            'allowed_auth_methods' => ['sso'],
            'mfa_policy' => 'OPTIONAL',
            'rbac_email_implicit_role_assignments' => [],
            'mfa_methods' => 'sms',
            'allowed_mfa_methods' => ['sms'],
            'oauth_tenant_jit_provisioning' => 'RESTRICTED',
            'claimed_email_domains' => [],
            'first_party_connected_apps_allowed_type' => 'ALL',
            'allowed_first_party_connected_apps' => [],
            'third_party_connected_apps_allowed_type' => 'ALL',
            'allowed_third_party_connected_apps' => [],
        ]);

        $response = new MagicLinkResponse(
            'test_request_id',
            200,
            'member_123',
            'org_123',
            $member,
            $organization,
            'session_token_456',
            'session_jwt_789',
            'intermediate_session_token_012',
            true
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'member_id' => 'member_123',
            'organization_id' => 'org_123',
            'member' => $member->toArray(),
            'organization' => $organization->toArray(),
            'session_token' => 'session_token_456',
            'session_jwt' => 'session_jwt_789',
            'intermediate_session_token' => 'intermediate_session_token_012',
            'member_authenticated' => true,
            'member_session' => null,
        ], $array);
    }

    public function testToArrayWithMemberSession(): void
    {
        $member = Member::fromArray([
            'member_id' => 'member_123',
            'organization_id' => 'org_123',
            'email_address' => 'test@example.com',
            'status' => 'active',
            'name' => 'Test Member',
            'sso_registrations' => [],
            'is_breakglass' => false,
            'member_password_id' => 'password_123',
            'oauth_registrations' => [],
            'email_address_verified' => true,
            'mfa_phone_number_verified' => false,
            'is_admin' => false,
            'totp_registration_id' => 'totp_123',
            'retired_email_addresses' => [],
            'is_locked' => false,
            'mfa_enrolled' => false,
            'mfa_phone_number' => '+1234567890',
            'default_mfa_method' => 'sms',
            'roles' => [],
        ]);

        $organization = Organization::fromArray([
            'organization_id' => 'org_123',
            'organization_name' => 'Test Org',
            'organization_logo_url' => 'https://example.com/logo.png',
            'organization_slug' => 'test-org',
            'sso_jit_provisioning' => 'RESTRICTED',
            'sso_jit_provisioning_allowed_connections' => [],
            'sso_active_connections' => [],
            'email_allowed_domains' => ['example.com'],
            'email_jit_provisioning' => 'RESTRICTED',
            'email_invites' => 'ENABLED',
            'auth_methods' => 'sso',
            'allowed_auth_methods' => ['sso'],
            'mfa_policy' => 'OPTIONAL',
            'rbac_email_implicit_role_assignments' => [],
            'mfa_methods' => 'sms',
            'allowed_mfa_methods' => ['sms'],
            'oauth_tenant_jit_provisioning' => 'RESTRICTED',
            'claimed_email_domains' => [],
            'first_party_connected_apps_allowed_type' => 'ALL',
            'allowed_first_party_connected_apps' => [],
            'third_party_connected_apps_allowed_type' => 'ALL',
            'allowed_third_party_connected_apps' => [],
        ]);

        $memberSession = Session::fromArray([
            'member_session_id' => 'session_123',
            'member_id' => 'member_123',
            'started_at' => '2023-01-01T12:00:00Z',
            'last_accessed_at' => '2023-01-01T13:00:00Z',
            'expires_at' => '2023-01-02T12:00:00Z',
            'authentication_factors' => [],
            'organization_id' => 'org_123',
            'roles' => [],
        ]);

        $response = new MagicLinkResponse(
            'test_request_id',
            200,
            'member_123',
            'org_123',
            $member,
            $organization,
            'session_token_456',
            'session_jwt_789',
            'intermediate_session_token_012',
            true,
            $memberSession
        );

        $array = $response->toArray();

        $this->assertEquals([
            'request_id' => 'test_request_id',
            'status_code' => 200,
            'member_id' => 'member_123',
            'organization_id' => 'org_123',
            'member' => $member->toArray(),
            'organization' => $organization->toArray(),
            'session_token' => 'session_token_456',
            'session_jwt' => 'session_jwt_789',
            'intermediate_session_token' => 'intermediate_session_token_012',
            'member_authenticated' => true,
            'member_session' => $memberSession->toArray(),
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'abc123',
            'status_code' => 200,
            'member_id' => 'member_456',
            'organization_id' => 'org_456',
            'member' => [
                'member_id' => 'member_456',
                'organization_id' => 'org_456',
                'email_address' => 'test2@example.com',
                'status' => 'active',
                'name' => 'Test Member 2',
                'sso_registrations' => [],
                'is_breakglass' => false,
                'member_password_id' => 'password_456',
                'oauth_registrations' => [],
                'email_address_verified' => true,
                'mfa_phone_number_verified' => false,
                'is_admin' => false,
                'totp_registration_id' => 'totp_456',
                'retired_email_addresses' => [],
                'is_locked' => false,
                'mfa_enrolled' => false,
                'mfa_phone_number' => '+1234567891',
                'default_mfa_method' => 'sms',
                'roles' => [],
            ],
            'organization' => [
                'organization_id' => 'org_456',
                'organization_name' => 'Test Org 2',
                'organization_logo_url' => 'https://example.com/logo2.png',
                'organization_slug' => 'test-org-2',
                'sso_jit_provisioning' => 'RESTRICTED',
                'sso_jit_provisioning_allowed_connections' => [],
                'sso_active_connections' => [],
                'email_allowed_domains' => ['example2.com'],
                'email_jit_provisioning' => 'RESTRICTED',
                'email_invites' => 'ENABLED',
                'auth_methods' => 'sso',
                'allowed_auth_methods' => ['sso'],
                'mfa_policy' => 'OPTIONAL',
                'rbac_email_implicit_role_assignments' => [],
                'mfa_methods' => 'sms',
                'allowed_mfa_methods' => ['sms'],
                'oauth_tenant_jit_provisioning' => 'RESTRICTED',
                'claimed_email_domains' => [],
                'first_party_connected_apps_allowed_type' => 'ALL',
                'allowed_first_party_connected_apps' => [],
                'third_party_connected_apps_allowed_type' => 'ALL',
                'allowed_third_party_connected_apps' => [],
            ],
            'session_token' => 'session_token_789',
            'session_jwt' => 'session_jwt_012',
            'intermediate_session_token' => 'intermediate_session_token_345',
            'member_authenticated' => false,
        ];

        $response = MagicLinkResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        // Compare only the fields present in the original data for member and organization
        foreach (['member', 'organization'] as $key) {
            foreach ($originalData[$key] as $field => $value) {
                $this->assertArrayHasKey($field, $convertedData[$key]);
                $this->assertEquals($value, $convertedData[$key][$field]);
            }
        }
        // Compare the rest of the fields
        foreach ($originalData as $key => $value) {
            if (!in_array($key, ['member', 'organization'])) {
                $this->assertEquals($value, $convertedData[$key]);
            }
        }
    }
}
