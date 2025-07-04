<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\MembersResponse;
use Stytch\Objects\Response\Member;
use Stytch\Objects\Organization;

class MembersResponseTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private function getMemberArray(): array
    {
        return [
            'member_id' => 'member_123',
            'email_address' => 'test@example.com',
            'name' => 'John Doe',
            'trusted_metadata' => ['trusted' => 'data'],
            'untrusted_metadata' => ['untrusted' => 'data'],
            'status' => 'active',
            'mfa_phone_number' => '+1234567890',
            'mfa_enrolled' => true,
            'roles' => ['admin', 'user'],
            'external_id' => 'ext_123',
            'is_breakglass' => false,
            'default_mfa_method' => 'totp',
            'emails' => [
                [
                    'email_id' => 'email_123',
                    'email' => 'test@example.com',
                    'verified' => true,
                ],
            ],
            'phone_numbers' => [
                [
                    'phone_id' => 'phone_123',
                    'phone_number' => '+1234567890',
                    'verified' => true,
                ],
            ],
            'totps' => [
                [
                    'totp_id' => 'totp_123',
                    'verified' => true,
                ],
            ],
            'passwords' => [
                [
                    'password_id' => 'password_123',
                    'verified' => true,
                ],
            ],
            'oauth_providers' => [
                [
                    'oauth_provider_id' => 'oauth_123',
                    'provider' => 'google',
                    'verified' => true,
                ],
            ],
            'connected_apps' => [
                [
                    'connected_app_id' => 'app_123',
                    'app_name' => 'Test App',
                ],
            ],
            'created_at' => '2023-01-01T00:00:00Z',
            'updated_at' => '2023-01-02T00:00:00Z',
        ];
    }

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
        $member = Member::fromArray($this->getMemberArray());
        $organization = Organization::fromArray($this->getOrganizationArray());
        $response = new MembersResponse(
            'req_1',
            200,
            [$member],
            ['total' => 1],
            ['org_123' => $organization]
        );

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertCount(1, $response->members);
        $this->assertInstanceOf(Member::class, $response->members[0]);
        $this->assertEquals(['total' => 1], $response->results_metadata);
        $this->assertCount(1, $response->organizations);
        $this->assertInstanceOf(Organization::class, $response->organizations['org_123']);
    }

    public function testConstructorWithEmptyArrays(): void
    {
        $response = new MembersResponse('req_1', 200, [], [], []);

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertCount(0, $response->members);
        $this->assertEquals([], $response->results_metadata);
        $this->assertCount(0, $response->organizations);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'members' => [$this->getMemberArray()],
            'results_metadata' => ['total' => 1, 'next_cursor' => 'next_123'],
            'organizations' => [
                'org_123' => $this->getOrganizationArray(),
            ],
        ];
        $response = MembersResponse::fromArray($data);

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertCount(1, $response->members);
        $this->assertInstanceOf(Member::class, $response->members[0]);
        $this->assertEquals(['total' => 1, 'next_cursor' => 'next_123'], $response->results_metadata);
        $this->assertCount(1, $response->organizations);
        $this->assertInstanceOf(Organization::class, $response->organizations['org_123']);
    }

    public function testFromArrayWithMultipleMembersAndOrganizations(): void
    {
        $member2 = $this->getMemberArray();
        $member2['member_id'] = 'member_456';
        $member2['email_address'] = 'test2@example.com';
        $member2['name'] = 'Jane Doe';

        $org2 = $this->getOrganizationArray();
        $org2['organization_id'] = 'org_456';
        $org2['organization_name'] = 'Test Org 2';

        $data = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'members' => [$this->getMemberArray(), $member2],
            'results_metadata' => ['total' => 2],
            'organizations' => [
                'org_123' => $this->getOrganizationArray(),
                'org_456' => $org2,
            ],
        ];
        $response = MembersResponse::fromArray($data);

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertCount(2, $response->members);
        $this->assertInstanceOf(Member::class, $response->members[0]);
        $this->assertInstanceOf(Member::class, $response->members[1]);
        $this->assertEquals('member_123', $response->members[0]->member_id);
        $this->assertEquals('member_456', $response->members[1]->member_id);
        $this->assertEquals(['total' => 2], $response->results_metadata);
        $this->assertCount(2, $response->organizations);
        $this->assertInstanceOf(Organization::class, $response->organizations['org_123']);
        $this->assertInstanceOf(Organization::class, $response->organizations['org_456']);
    }

    public function testToArray(): void
    {
        $member = Member::fromArray($this->getMemberArray());
        $organization = Organization::fromArray($this->getOrganizationArray());
        $response = new MembersResponse(
            'req_1',
            200,
            [$member],
            ['total' => 1],
            ['org_123' => $organization]
        );

        $array = $response->toArray();

        $this->assertEquals('req_1', $array['request_id']);
        $this->assertEquals(200, $array['status_code']);
        $this->assertCount(1, $array['members']);
        $this->assertEquals($member->toArray(), $array['members'][0]);
        $this->assertEquals(['total' => 1], $array['results_metadata']);
        $this->assertCount(1, $array['organizations']);
        $this->assertEquals($organization->toArray(), $array['organizations']['org_123']);
    }

    public function testToArrayWithEmptyArrays(): void
    {
        $response = new MembersResponse('req_1', 200, [], [], []);
        $array = $response->toArray();

        $this->assertEquals('req_1', $array['request_id']);
        $this->assertEquals(200, $array['status_code']);
        $this->assertCount(0, $array['members']);
        $this->assertEquals([], $array['results_metadata']);
        $this->assertCount(0, $array['organizations']);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'members' => [$this->getMemberArray()],
            'results_metadata' => ['total' => 1, 'next_cursor' => 'next_123'],
            'organizations' => [
                'org_123' => $this->getOrganizationArray(),
            ],
        ];

        $response = MembersResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData['request_id'], $convertedData['request_id']);
        $this->assertEquals($originalData['status_code'], $convertedData['status_code']);
        $this->assertEquals($originalData['results_metadata'], $convertedData['results_metadata']);

        // Compare members
        $this->assertCount(1, $convertedData['members']);
        foreach ($originalData['members'][0] as $field => $value) {
            if (!array_key_exists($field, $convertedData['members'][0])) {
                continue;
            }
            if ($field === 'created_at') {
                $this->assertStringContainsString('2023-01-01', $convertedData['members'][0][$field]);
            } elseif ($field === 'updated_at') {
                $this->assertStringContainsString('2023-01-02', $convertedData['members'][0][$field]);
            } else {
                $this->assertEquals($value, $convertedData['members'][0][$field]);
            }
        }

        // Compare organizations
        $this->assertCount(1, $convertedData['organizations']);
        foreach ($originalData['organizations']['org_123'] as $field => $value) {
            if (!array_key_exists($field, $convertedData['organizations']['org_123'])) {
                continue;
            }
            if ($field === 'created_at') {
                $this->assertStringContainsString('2023-01-01', $convertedData['organizations']['org_123'][$field]);
            } elseif ($field === 'updated_at') {
                $this->assertStringContainsString('2023-01-02', $convertedData['organizations']['org_123'][$field]);
            } else {
                $this->assertEquals($value, $convertedData['organizations']['org_123'][$field]);
            }
        }
    }
}
