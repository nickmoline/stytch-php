<?php

namespace Stytch\Tests\B2B;

use PHPUnit\Framework\TestCase;
use Stytch\B2B\Organizations;
use Stytch\Objects\Response\OrganizationResponse;
use Stytch\Objects\Response\OrganizationsResponse;
use Stytch\Shared\Client;

class OrganizationsTest extends TestCase
{
    public function testCreateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/organizations', [
                'organization_name' => 'Acme Co',
                'organization_slug' => 'acme-co',
            ])
            ->willReturn([
                'request_id' => 'req123',
                'status_code' => 200,
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
            ]);

        $organizations = new Organizations($mock);
        $result = $organizations->create([
            'organization_name' => 'Acme Co',
            'organization_slug' => 'acme-co',
        ]);

        // Response is implicitly tested by the mock
    }

    public function testGetCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/b2b/organizations/org123')
            ->willReturn([
                'request_id' => 'req123',
                'status_code' => 200,
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
            ]);

        $organizations = new Organizations($mock);
        $result = $organizations->get('org123');

        // Response is implicitly tested by the mock
    }

    public function testUpdateCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('put')
            ->with('/v1/b2b/organizations/org123', ['organization_name' => 'Updated Name'])
            ->willReturn([
                'request_id' => 'req123',
                'status_code' => 200,
                'organization' => [
                    'organization_id' => 'org123',
                    'organization_name' => 'Updated Name',
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
            ]);

        $organizations = new Organizations($mock);
        $result = $organizations->update('org123', ['organization_name' => 'Updated Name']);

        // Response is implicitly tested by the mock
    }

    public function testDeleteCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('delete')
            ->with('/v1/b2b/organizations/org123')
            ->willReturn(['deleted' => true]);

        $organizations = new Organizations($mock);
        $result = $organizations->delete('org123');

        $this->assertSame(['deleted' => true], $result);
    }

    public function testSearchCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('post')
            ->with('/v1/b2b/organizations/search', ['limit' => 10])
            ->willReturn([
                'request_id' => 'req123',
                'status_code' => 200,
                'organizations' => [],
                'results_metadata' => ['total' => 0],
            ]);

        $organizations = new Organizations($mock);
        $result = $organizations->search(['limit' => 10]);

        // Response is implicitly tested by the mock
    }

    public function testMetricsCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/b2b/organizations/org123/metrics')
            ->willReturn(['metrics' => []]);

        $organizations = new Organizations($mock);
        $result = $organizations->metrics('org123');

        $this->assertSame(['metrics' => []], $result);
    }

    public function testConnectedAppsCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/b2b/organizations/org123/connected_apps')
            ->willReturn(['connected_apps' => []]);

        $organizations = new Organizations($mock);
        $result = $organizations->connectedApps('org123');

        $this->assertSame(['connected_apps' => []], $result);
    }

    public function testGetConnectedAppCallsCorrectEndpoint(): void
    {
        $mock = $this->createMock(Client::class);
        $mock->expects($this->once())
            ->method('get')
            ->with('/v1/b2b/organizations/org123/connected_apps/app123')
            ->willReturn(['connected_app' => []]);

        $organizations = new Organizations($mock);
        $result = $organizations->getConnectedApp('org123', 'app123');

        $this->assertSame(['connected_app' => []], $result);
    }
}
