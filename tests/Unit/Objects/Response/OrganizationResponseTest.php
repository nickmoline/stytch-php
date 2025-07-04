<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\OrganizationResponse;
use Stytch\Objects\Organization;

class OrganizationResponseTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private function getOrganizationArray(): array
    {
        return [
            'organization_id' => 'org_123',
            'organization_name' => 'Test Org',
            'organization_slug' => 'test-org',
            'organization_logo_url' => 'https://example.com/logo.png',
            'trusted_metadata' => ['foo' => 'bar'],
            'untrusted_metadata' => ['baz' => 'qux'],
            'sso_default_connection_id' => 'sso_123',
            'sso_jit_provisioning' => 'ENABLED',
            'email_allowed_domains' => ['example.com'],
            'email_jit_provisioning' => 'ENABLED',
            'email_invites' => 'ENABLED',
            'auth_methods' => 'sso,password',
            'allowed_auth_methods' => ['sso', 'password'],
            'mfa_policy' => 'REQUIRED_FOR_ALL',
            'mfa_methods' => 'totp,sms',
            'oauth_tenant_jit_provisioning' => 'ENABLED',
            'first_party_connected_apps_allowed_type' => 'ALL',
            'third_party_connected_apps_allowed_type' => 'ALL',
            'created_at' => '2023-01-01T00:00:00Z',
            'updated_at' => '2023-01-02T00:00:00Z',
        ];
    }

    public function testConstructor(): void
    {
        $organization = Organization::fromArray($this->getOrganizationArray());
        $response = new OrganizationResponse('req_1', 200, $organization);

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertInstanceOf(Organization::class, $response->organization);
        $this->assertEquals('org_123', $response->organization->organization_id);
        $this->assertEquals('Test Org', $response->organization->organization_name);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'organization' => $this->getOrganizationArray(),
        ];
        $response = OrganizationResponse::fromArray($data);

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertInstanceOf(Organization::class, $response->organization);
        $this->assertEquals('org_123', $response->organization->organization_id);
        $this->assertEquals('Test Org', $response->organization->organization_name);
    }

    public function testToArray(): void
    {
        $organization = Organization::fromArray($this->getOrganizationArray());
        $response = new OrganizationResponse('req_1', 200, $organization);
        $array = $response->toArray();

        $this->assertEquals('req_1', $array['request_id']);
        $this->assertEquals(200, $array['status_code']);
        $this->assertEquals($organization->toArray(), $array['organization']);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'organization' => $this->getOrganizationArray(),
        ];

        $response = OrganizationResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData['request_id'], $convertedData['request_id']);
        $this->assertEquals($originalData['status_code'], $convertedData['status_code']);

        // Compare organization fields
        foreach ($originalData['organization'] as $field => $value) {
            if (!array_key_exists($field, $convertedData['organization'])) {
                continue;
            }
            if ($field === 'created_at') {
                $this->assertStringContainsString('2023-01-01', $convertedData['organization'][$field]);
            } elseif ($field === 'updated_at') {
                $this->assertStringContainsString('2023-01-02', $convertedData['organization'][$field]);
            } else {
                $this->assertEquals($value, $convertedData['organization'][$field]);
            }
        }
    }
}
