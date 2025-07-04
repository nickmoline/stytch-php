<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Stytch\B2B\Members;
use Stytch\Objects\Response\MemberResponse;
use Stytch\Objects\Response\MembersResponse;
use Stytch\Objects\Response\ConnectedAppsResponse;
use Stytch\Objects\Response\OIDCProvidersResponse;
use Stytch\Shared\Client;

class MembersTest extends TestCase
{
    /**
     * @param callable $assertion
     * @param array<string, mixed> $response
     */
    private function getMockClient(callable $assertion, array $response = []): Client
    {
        $mock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['post', 'get', 'put', 'delete'])
            ->getMock();
        $mock->method($this->anything())
            ->willReturnCallback(function (...$args) use ($assertion, $response) {
                $assertion(...$args);
                return $response;
            });
        return $mock;
    }

    /**
     * @return array<string, mixed>
     */
    private function memberResponseArr(): array
    {
        return [
            'request_id' => 'req',
            'status_code' => 200,
            'member_id' => 'mid',
            'member' => [
                'member_id' => 'mid',
                'email_address' => 'a@b.com',
                'name' => 'Test',
                'trusted_metadata' => [],
                'untrusted_metadata' => [],
                'status' => 'active',
                'mfa_phone_number' => null,
                'mfa_enrolled' => false,
                'roles' => [],
                'external_id' => null,
                'is_breakglass' => false,
                'default_mfa_method' => null,
                'emails' => [],
                'phone_numbers' => [],
                'totps' => [],
                'passwords' => [],
                'oauth_providers' => [],
                'connected_apps' => [],
                'created_at' => 'now',
                'updated_at' => 'now',
            ],
            'organization' => [
                'organization_id' => 'oid',
                'organization_name' => 'Org',
                'organization_logo_url' => '',
                'organization_slug' => '',
                'sso_jit_provisioning' => '',
                'sso_jit_provisioning_allowed_connections' => [],
                'sso_active_connections' => [],
                'email_allowed_domains' => [],
                'email_jit_provisioning' => '',
                'email_invites' => '',
                'auth_methods' => '',
                'allowed_auth_methods' => [],
                'mfa_policy' => '',
                'rbac_email_implicit_role_assignments' => [],
                'mfa_methods' => '',
                'allowed_mfa_methods' => [],
                'oauth_tenant_jit_provisioning' => '',
                'claimed_email_domains' => [],
                'first_party_connected_apps_allowed_type' => '',
                'allowed_first_party_connected_apps' => [],
                'third_party_connected_apps_allowed_type' => '',
                'allowed_third_party_connected_apps' => [],
                'trusted_metadata' => [],
                'created_at' => 'now',
                'updated_at' => 'now',
                'sso_default_connection_id' => null,
                'scim_active_connection' => null,
                'allowed_oauth_tenants' => null,
            ],
        ];
    }

    public function testCreate(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members', $url);
        }, $this->memberResponseArr());
        $api = new Members($client);
        $resp = $api->create([]);
    }

    public function testGet(): void
    {
        $client = $this->getMockClient(function ($url, $data = null) {
            $this->assertEquals('/v1/b2b/organizations/members', $url);
        }, $this->memberResponseArr());
        $api = new Members($client);
        $resp = $api->get([]);
    }

    public function testUpdate(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members', $url);
        }, $this->memberResponseArr());
        $api = new Members($client);
        $resp = $api->update([]);
    }

    public function testDelete(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members', $url);
        }, ['deleted' => true]);
        $api = new Members($client);
        $api->delete([]);
    }

    public function testSearch(): void
    {
        $expected = [
            'request_id' => 'req',
            'status_code' => 200,
            'members' => [],
            'results_metadata' => [],
            'organizations' => [],
        ];
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/search', $url);
        }, $expected);
        $api = new Members($client);
        $resp = $api->search([]);
    }

    public function testReactivate(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/reactivate', $url);
        }, $this->memberResponseArr());
        $api = new Members($client);
        $resp = $api->reactivate([]);
    }

    public function testDeleteMFAPhoneNumber(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/mfa_phone_number', $url);
        }, $this->memberResponseArr());
        $api = new Members($client);
        $resp = $api->deleteMFAPhoneNumber([]);
    }

    public function testDeleteTOTP(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/totp', $url);
        }, $this->memberResponseArr());
        $api = new Members($client);
        $resp = $api->deleteTOTP([]);
    }

    public function testDeletePassword(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/passwords', $url);
        }, $this->memberResponseArr());
        $api = new Members($client);
        $resp = $api->deletePassword([]);
    }

    public function testDangerouslyGet(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/dangerously_get', $url);
        }, $this->memberResponseArr());
        $api = new Members($client);
        $resp = $api->dangerouslyGet([]);
    }

    public function testOidcProviders(): void
    {
        $expected = [
            'request_id' => 'req',
            'status_code' => 200,
            'registrations' => [],
        ];
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/oidc_providers', $url);
        }, $expected);
        $api = new Members($client);
        $resp = $api->oidcProviders([]);
    }

    public function testUnlinkRetiredEmail(): void
    {
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/unlink_retired_email', $url);
        }, $this->memberResponseArr());
        $api = new Members($client);
        $resp = $api->unlinkRetiredEmail([]);
    }

    public function testGetConnectedApps(): void
    {
        $expected = [
            'request_id' => 'req',
            'status_code' => 200,
            'connected_apps' => [],
        ];
        $client = $this->getMockClient(function ($url, $data) {
            $this->assertEquals('/v1/b2b/organizations/members/connected_apps', $url);
        }, $expected);
        $api = new Members($client);
        $resp = $api->getConnectedApps([]);
    }
}
