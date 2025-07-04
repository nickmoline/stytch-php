<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\OrganizationsResponse;
use Stytch\Objects\Organization;

class OrganizationsResponseTest extends TestCase
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
        $response = new OrganizationsResponse(
            'req_1',
            200,
            [$organization],
            ['total' => 1]
        );

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertCount(1, $response->organizations);
        $this->assertInstanceOf(Organization::class, $response->organizations[0]);
        $this->assertEquals(['total' => 1], $response->results_metadata);
    }

    public function testConstructorWithEmptyArrays(): void
    {
        $response = new OrganizationsResponse('req_1', 200, [], []);

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertCount(0, $response->organizations);
        $this->assertEquals([], $response->results_metadata);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'organizations' => [$this->getOrganizationArray()],
            'results_metadata' => ['total' => 1, 'next_cursor' => 'next_123'],
        ];
        $response = OrganizationsResponse::fromArray($data);

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertCount(1, $response->organizations);
        $this->assertInstanceOf(Organization::class, $response->organizations[0]);
        $this->assertEquals(['total' => 1, 'next_cursor' => 'next_123'], $response->results_metadata);
    }

    public function testFromArrayWithMissingOrganizations(): void
    {
        $data = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'results_metadata' => ['total' => 0],
        ];
        $response = OrganizationsResponse::fromArray($data);

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertCount(0, $response->organizations);
        $this->assertEquals(['total' => 0], $response->results_metadata);
    }

    public function testFromArrayWithMultipleOrganizations(): void
    {
        $org2 = $this->getOrganizationArray();
        $org2['organization_id'] = 'org_456';
        $org2['organization_name'] = 'Test Org 2';

        $data = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'organizations' => [$this->getOrganizationArray(), $org2],
            'results_metadata' => ['total' => 2],
        ];
        $response = OrganizationsResponse::fromArray($data);

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertCount(2, $response->organizations);
        $this->assertInstanceOf(Organization::class, $response->organizations[0]);
        $this->assertInstanceOf(Organization::class, $response->organizations[1]);
        $this->assertEquals('org_123', $response->organizations[0]->organization_id);
        $this->assertEquals('org_456', $response->organizations[1]->organization_id);
        $this->assertEquals(['total' => 2], $response->results_metadata);
    }

    public function testToArray(): void
    {
        $organization = Organization::fromArray($this->getOrganizationArray());
        $response = new OrganizationsResponse(
            'req_1',
            200,
            [$organization],
            ['total' => 1]
        );

        $array = $response->toArray();

        $this->assertEquals('req_1', $array['request_id']);
        $this->assertEquals(200, $array['status_code']);
        $this->assertCount(1, $array['organizations']);
        $this->assertEquals($organization->toArray(), $array['organizations'][0]);
        $this->assertEquals(['total' => 1], $array['results_metadata']);
    }

    public function testToArrayWithEmptyArrays(): void
    {
        $response = new OrganizationsResponse('req_1', 200, [], []);
        $array = $response->toArray();

        $this->assertEquals('req_1', $array['request_id']);
        $this->assertEquals(200, $array['status_code']);
        $this->assertCount(0, $array['organizations']);
        $this->assertEquals([], $array['results_metadata']);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'organizations' => [$this->getOrganizationArray()],
            'results_metadata' => ['total' => 1, 'next_cursor' => 'next_123'],
        ];

        $response = OrganizationsResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData['request_id'], $convertedData['request_id']);
        $this->assertEquals($originalData['status_code'], $convertedData['status_code']);
        $this->assertEquals($originalData['results_metadata'], $convertedData['results_metadata']);

        // Compare organizations
        $this->assertCount(1, $convertedData['organizations']);
        foreach ($originalData['organizations'][0] as $field => $value) {
            if (!array_key_exists($field, $convertedData['organizations'][0])) {
                continue;
            }
            if ($field === 'created_at') {
                $this->assertStringContainsString('2023-01-01', $convertedData['organizations'][0][$field]);
            } elseif ($field === 'updated_at') {
                $this->assertStringContainsString('2023-01-02', $convertedData['organizations'][0][$field]);
            } else {
                $this->assertEquals($value, $convertedData['organizations'][0][$field]);
            }
        }
    }

    public function testRoundTripConversionWithEmptyOrganizations(): void
    {
        $originalData = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'organizations' => [],
            'results_metadata' => ['total' => 0],
        ];

        $response = OrganizationsResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData, $convertedData);
    }

    public function testRoundTripConversionWithMissingOrganizations(): void
    {
        $originalData = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'results_metadata' => ['total' => 0],
        ];

        $response = OrganizationsResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        // The converted data will have an empty organizations array
        $expectedData = $originalData;
        $expectedData['organizations'] = [];

        $this->assertEquals($expectedData, $convertedData);
    }
}
