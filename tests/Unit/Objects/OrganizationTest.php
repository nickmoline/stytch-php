<?php

namespace Stytch\Tests\Unit\Objects;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Stytch\Objects\Organization;
use Stytch\Objects\ActiveSSOConnection;
use Stytch\Objects\ActiveSCIMConnection;
use Stytch\Objects\EmailImplicitRoleAssignment;

class OrganizationTest extends TestCase
{
    public function testOrganizationConstructor(): void
    {
        $createdAt = Carbon::parse('2023-01-01T12:00:00Z');
        $updatedAt = Carbon::parse('2023-01-01T13:00:00Z');

        // Use fromArray to avoid autoloading issues with nested classes
        $data = [
            'organization_id' => 'org_123',
            'organization_name' => 'Test Organization',
            'organization_logo_url' => 'https://example.com/logo.png',
            'organization_slug' => 'test-org',
            'sso_jit_provisioning' => 'all_allowed',
            'sso_jit_provisioning_allowed_connections' => ['saml', 'oidc'],
            'sso_active_connections' => [
                [
                    'connection_id' => 'sso_123',
                    'display_name' => 'SSO Connection',
                    'identity_provider' => 'okta'
                ]
            ],
            'email_allowed_domains' => ['example.com', 'test.com'],
            'email_jit_provisioning' => 'all_allowed',
            'email_invites' => 'all_allowed',
            'auth_methods' => 'all_allowed',
            'allowed_auth_methods' => ['password', 'magic_link'],
            'mfa_policy' => 'all_allowed',
            'rbac_email_implicit_role_assignments' => [
                [
                    'domain' => 'example.com',
                    'role_id' => 'role_123'
                ]
            ],
            'mfa_methods' => 'all_allowed',
            'allowed_mfa_methods' => ['totp', 'sms'],
            'oauth_tenant_jit_provisioning' => 'all_allowed',
            'claimed_email_domains' => ['example.com'],
            'first_party_connected_apps_allowed_type' => 'all_allowed',
            'allowed_first_party_connected_apps' => ['app_123'],
            'third_party_connected_apps_allowed_type' => 'all_allowed',
            'allowed_third_party_connected_apps' => ['app_456'],
            'trusted_metadata' => ['trusted' => 'data'],
            'created_at' => '2023-01-01T12:00:00Z',
            'updated_at' => '2023-01-01T13:00:00Z',
            'sso_default_connection_id' => 'sso_123',
            'scim_active_connection' => [
                'connection_id' => 'scim_123',
                'display_name' => 'SCIM Connection',
                'bearer_token_last_four' => '1234',
                'bearer_token_expires_at' => '2023-12-31T23:59:59Z'
            ],
            'allowed_oauth_tenants' => ['google', 'microsoft']
        ];

        $organization = Organization::fromArray($data);

        $this->assertEquals('org_123', $organization->organization_id);
        $this->assertEquals('Test Organization', $organization->organization_name);
        $this->assertEquals('https://example.com/logo.png', $organization->organization_logo_url);
        $this->assertEquals('test-org', $organization->organization_slug);
        $this->assertEquals('all_allowed', $organization->sso_jit_provisioning);
        $this->assertEquals(['saml', 'oidc'], $organization->sso_jit_provisioning_allowed_connections);
        $this->assertCount(1, $organization->sso_active_connections);
        $this->assertEquals(['example.com', 'test.com'], $organization->email_allowed_domains);
        $this->assertEquals('all_allowed', $organization->email_jit_provisioning);
        $this->assertEquals('all_allowed', $organization->email_invites);
        $this->assertEquals('all_allowed', $organization->auth_methods);
        $this->assertEquals(['password', 'magic_link'], $organization->allowed_auth_methods);
        $this->assertEquals('all_allowed', $organization->mfa_policy);
        $this->assertCount(1, $organization->rbac_email_implicit_role_assignments);
        $this->assertEquals('all_allowed', $organization->mfa_methods);
        $this->assertEquals(['totp', 'sms'], $organization->allowed_mfa_methods);
        $this->assertEquals('all_allowed', $organization->oauth_tenant_jit_provisioning);
        $this->assertEquals(['example.com'], $organization->claimed_email_domains);
        $this->assertEquals('all_allowed', $organization->first_party_connected_apps_allowed_type);
        $this->assertEquals(['app_123'], $organization->allowed_first_party_connected_apps);
        $this->assertEquals('all_allowed', $organization->third_party_connected_apps_allowed_type);
        $this->assertEquals(['app_456'], $organization->allowed_third_party_connected_apps);
        $this->assertEquals(['trusted' => 'data'], $organization->trusted_metadata);
        $this->assertInstanceOf(Carbon::class, $organization->created_at);
        $this->assertInstanceOf(Carbon::class, $organization->updated_at);
        $this->assertEquals('sso_123', $organization->sso_default_connection_id);
        $this->assertInstanceOf(ActiveSCIMConnection::class, $organization->scim_active_connection);
        $this->assertEquals(['google', 'microsoft'], $organization->allowed_oauth_tenants);
    }

    public function testOrganizationFromArray(): void
    {
        $data = [
            'organization_id' => 'org_123',
            'organization_name' => 'Test Organization',
            'organization_logo_url' => 'https://example.com/logo.png',
            'organization_slug' => 'test-org',
            'sso_jit_provisioning' => 'all_allowed',
            'sso_jit_provisioning_allowed_connections' => ['saml', 'oidc'],
            'sso_active_connections' => [
                [
                    'connection_id' => 'sso_123',
                    'display_name' => 'SSO Connection',
                    'identity_provider' => 'okta'
                ]
            ],
            'email_allowed_domains' => ['example.com', 'test.com'],
            'email_jit_provisioning' => 'all_allowed',
            'email_invites' => 'all_allowed',
            'auth_methods' => 'all_allowed',
            'allowed_auth_methods' => ['password', 'magic_link'],
            'mfa_policy' => 'all_allowed',
            'rbac_email_implicit_role_assignments' => [
                [
                    'domain' => 'example.com',
                    'role_id' => 'role_123'
                ]
            ],
            'mfa_methods' => 'all_allowed',
            'allowed_mfa_methods' => ['totp', 'sms'],
            'oauth_tenant_jit_provisioning' => 'all_allowed',
            'claimed_email_domains' => ['example.com'],
            'first_party_connected_apps_allowed_type' => 'all_allowed',
            'allowed_first_party_connected_apps' => ['app_123'],
            'third_party_connected_apps_allowed_type' => 'all_allowed',
            'allowed_third_party_connected_apps' => ['app_456'],
            'trusted_metadata' => ['trusted' => 'data'],
            'created_at' => '2023-01-01T12:00:00Z',
            'updated_at' => '2023-01-01T13:00:00Z',
            'sso_default_connection_id' => 'sso_123',
            'scim_active_connection' => [
                'connection_id' => 'scim_123',
                'display_name' => 'SCIM Connection',
                'bearer_token_last_four' => '1234',
                'bearer_token_expires_at' => '2023-12-31T23:59:59Z'
            ],
            'allowed_oauth_tenants' => ['google', 'microsoft']
        ];

        $organization = Organization::fromArray($data);

        $this->assertEquals('org_123', $organization->organization_id);
        $this->assertEquals('Test Organization', $organization->organization_name);
        $this->assertEquals('https://example.com/logo.png', $organization->organization_logo_url);
        $this->assertEquals('test-org', $organization->organization_slug);
        $this->assertEquals('all_allowed', $organization->sso_jit_provisioning);
        $this->assertEquals(['saml', 'oidc'], $organization->sso_jit_provisioning_allowed_connections);
        $this->assertCount(1, $organization->sso_active_connections);
        $this->assertEquals(['example.com', 'test.com'], $organization->email_allowed_domains);
        $this->assertEquals('all_allowed', $organization->email_jit_provisioning);
        $this->assertEquals('all_allowed', $organization->email_invites);
        $this->assertEquals('all_allowed', $organization->auth_methods);
        $this->assertEquals(['password', 'magic_link'], $organization->allowed_auth_methods);
        $this->assertEquals('all_allowed', $organization->mfa_policy);
        $this->assertCount(1, $organization->rbac_email_implicit_role_assignments);
        $this->assertEquals('all_allowed', $organization->mfa_methods);
        $this->assertEquals(['totp', 'sms'], $organization->allowed_mfa_methods);
        $this->assertEquals('all_allowed', $organization->oauth_tenant_jit_provisioning);
        $this->assertEquals(['example.com'], $organization->claimed_email_domains);
        $this->assertEquals('all_allowed', $organization->first_party_connected_apps_allowed_type);
        $this->assertEquals(['app_123'], $organization->allowed_first_party_connected_apps);
        $this->assertEquals('all_allowed', $organization->third_party_connected_apps_allowed_type);
        $this->assertEquals(['app_456'], $organization->allowed_third_party_connected_apps);
        $this->assertEquals(['trusted' => 'data'], $organization->trusted_metadata);
        $this->assertInstanceOf(Carbon::class, $organization->created_at);
        $this->assertInstanceOf(Carbon::class, $organization->updated_at);
        $this->assertEquals('sso_123', $organization->sso_default_connection_id);
        $this->assertInstanceOf(ActiveSCIMConnection::class, $organization->scim_active_connection);
        $this->assertEquals(['google', 'microsoft'], $organization->allowed_oauth_tenants);
    }

    public function testOrganizationToArray(): void
    {
        $createdAt = Carbon::parse('2023-01-01T12:00:00Z');
        $updatedAt = Carbon::parse('2023-01-01T13:00:00Z');
        $scimConnection = new \Stytch\Objects\ActiveSCIMConnection(
            'scim_123',
            'SCIM Connection',
            '1234',
            Carbon::parse('2023-12-31T23:59:59Z')
        );

        $organization = new Organization(
            'org_123',
            'Test Organization',
            'https://example.com/logo.png',
            'test-org',
            'all_allowed',
            ['saml', 'oidc'],
            [new \Stytch\Objects\ActiveSSOConnection('sso_123', 'SSO Connection', 'okta')],
            ['example.com', 'test.com'],
            'all_allowed',
            'all_allowed',
            'all_allowed',
            ['password', 'magic_link'],
            'all_allowed',
            [new \Stytch\Objects\EmailImplicitRoleAssignment('example.com', 'role_123')],
            'all_allowed',
            ['totp', 'sms'],
            'all_allowed',
            ['example.com'],
            'all_allowed',
            ['app_123'],
            'all_allowed',
            ['app_456'],
            ['trusted' => 'data'],
            $createdAt,
            $updatedAt,
            'sso_123',
            $scimConnection,
            ['google', 'microsoft']
        );

        $array = $organization->toArray();

        $this->assertEquals('org_123', $array['organization_id']);
        $this->assertEquals('Test Organization', $array['organization_name']);
        $this->assertEquals('https://example.com/logo.png', $array['organization_logo_url']);
        $this->assertEquals('test-org', $array['organization_slug']);
        $this->assertEquals('all_allowed', $array['sso_jit_provisioning']);
        $this->assertEquals(['saml', 'oidc'], $array['sso_jit_provisioning_allowed_connections']);
        $this->assertCount(1, $array['sso_active_connections']);
        $this->assertEquals(['example.com', 'test.com'], $array['email_allowed_domains']);
        $this->assertEquals('all_allowed', $array['email_jit_provisioning']);
        $this->assertEquals('all_allowed', $array['email_invites']);
        $this->assertEquals('all_allowed', $array['auth_methods']);
        $this->assertEquals(['password', 'magic_link'], $array['allowed_auth_methods']);
        $this->assertEquals('all_allowed', $array['mfa_policy']);
        $this->assertCount(1, $array['rbac_email_implicit_role_assignments']);
        $this->assertEquals('all_allowed', $array['mfa_methods']);
        $this->assertEquals(['totp', 'sms'], $array['allowed_mfa_methods']);
        $this->assertEquals('all_allowed', $array['oauth_tenant_jit_provisioning']);
        $this->assertEquals(['example.com'], $array['claimed_email_domains']);
        $this->assertEquals('all_allowed', $array['first_party_connected_apps_allowed_type']);
        $this->assertEquals(['app_123'], $array['allowed_first_party_connected_apps']);
        $this->assertEquals('all_allowed', $array['third_party_connected_apps_allowed_type']);
        $this->assertEquals(['app_456'], $array['allowed_third_party_connected_apps']);
        $this->assertEquals(['trusted' => 'data'], $array['trusted_metadata']);
        $this->assertEquals('2023-01-01T12:00:00.000000Z', $array['created_at']);
        $this->assertEquals('2023-01-01T13:00:00.000000Z', $array['updated_at']);
        $this->assertEquals('sso_123', $array['sso_default_connection_id']);
        $this->assertEquals($scimConnection->toArray(), $array['scim_active_connection']);
        $this->assertEquals(['google', 'microsoft'], $array['allowed_oauth_tenants']);
    }

    public function testActiveSSOConnectionConstructor(): void
    {
        $connection = new ActiveSSOConnection(
            'sso_123',
            'SSO Connection',
            'okta'
        );

        $this->assertEquals('sso_123', $connection->connection_id);
        $this->assertEquals('SSO Connection', $connection->display_name);
        $this->assertEquals('okta', $connection->identity_provider);
    }

    public function testActiveSSOConnectionFromArray(): void
    {
        $data = [
            'connection_id' => 'sso_123',
            'display_name' => 'SSO Connection',
            'identity_provider' => 'okta'
        ];

        $connection = ActiveSSOConnection::fromArray($data);

        $this->assertEquals('sso_123', $connection->connection_id);
        $this->assertEquals('SSO Connection', $connection->display_name);
        $this->assertEquals('okta', $connection->identity_provider);
    }

    public function testActiveSSOConnectionToArray(): void
    {
        $connection = new ActiveSSOConnection(
            'sso_123',
            'SSO Connection',
            'okta'
        );

        $array = $connection->toArray();

        $this->assertEquals('sso_123', $array['connection_id']);
        $this->assertEquals('SSO Connection', $array['display_name']);
        $this->assertEquals('okta', $array['identity_provider']);
    }

    public function testActiveSCIMConnectionConstructor(): void
    {
        $expiresAt = Carbon::parse('2023-12-31T23:59:59Z');
        $connection = new ActiveSCIMConnection(
            'scim_123',
            'SCIM Connection',
            '1234',
            $expiresAt
        );

        $this->assertEquals('scim_123', $connection->connection_id);
        $this->assertEquals('SCIM Connection', $connection->display_name);
        $this->assertEquals('1234', $connection->bearer_token_last_four);
        $this->assertSame($expiresAt, $connection->bearer_token_expires_at);
    }

    public function testActiveSCIMConnectionFromArray(): void
    {
        $data = [
            'connection_id' => 'scim_123',
            'display_name' => 'SCIM Connection',
            'bearer_token_last_four' => '1234',
            'bearer_token_expires_at' => '2023-12-31T23:59:59Z'
        ];

        $connection = ActiveSCIMConnection::fromArray($data);

        $this->assertEquals('scim_123', $connection->connection_id);
        $this->assertEquals('SCIM Connection', $connection->display_name);
        $this->assertEquals('1234', $connection->bearer_token_last_four);
        $this->assertInstanceOf(Carbon::class, $connection->bearer_token_expires_at);
    }

    public function testActiveSCIMConnectionToArray(): void
    {
        $expiresAt = Carbon::parse('2023-12-31T23:59:59Z');
        $connection = new ActiveSCIMConnection(
            'scim_123',
            'SCIM Connection',
            '1234',
            $expiresAt
        );

        $array = $connection->toArray();

        $this->assertEquals('scim_123', $array['connection_id']);
        $this->assertEquals('SCIM Connection', $array['display_name']);
        $this->assertEquals('1234', $array['bearer_token_last_four']);
        $this->assertEquals('2023-12-31T23:59:59.000000Z', $array['bearer_token_expires_at']);
    }

    public function testEmailImplicitRoleAssignmentConstructor(): void
    {
        $role = new EmailImplicitRoleAssignment(
            'example.com',
            'role_123'
        );

        $this->assertEquals('example.com', $role->domain);
        $this->assertEquals('role_123', $role->role_id);
    }

    public function testEmailImplicitRoleAssignmentFromArray(): void
    {
        $data = [
            'domain' => 'example.com',
            'role_id' => 'role_123'
        ];

        $role = EmailImplicitRoleAssignment::fromArray($data);

        $this->assertEquals('example.com', $role->domain);
        $this->assertEquals('role_123', $role->role_id);
    }

    public function testEmailImplicitRoleAssignmentToArray(): void
    {
        $role = new EmailImplicitRoleAssignment(
            'example.com',
            'role_123'
        );

        $array = $role->toArray();

        $this->assertEquals('example.com', $array['domain']);
        $this->assertEquals('role_123', $array['role_id']);
    }
}
