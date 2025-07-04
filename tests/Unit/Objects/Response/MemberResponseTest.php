<?php

namespace Stytch\Tests\Unit\Objects\Response;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\MemberResponse;
use Stytch\Objects\Response\Member;
use Stytch\Objects\Organization;

class MemberResponseTest extends TestCase
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
        $response = new MemberResponse('req_1', 200, 'member_123', $member, $organization);

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('member_123', $response->member_id);
        $this->assertInstanceOf(Member::class, $response->member);
        $this->assertInstanceOf(Organization::class, $response->organization);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'member_id' => 'member_123',
            'member' => $this->getMemberArray(),
            'organization' => $this->getOrganizationArray(),
        ];
        $response = MemberResponse::fromArray($data);
        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('member_123', $response->member_id);
        $this->assertInstanceOf(Member::class, $response->member);
        $this->assertInstanceOf(Organization::class, $response->organization);
        $this->assertEquals('John Doe', $response->member->name);
        $this->assertEquals('Test Org', $response->organization->organization_name);
    }

    public function testToArray(): void
    {
        $member = Member::fromArray($this->getMemberArray());
        $organization = Organization::fromArray($this->getOrganizationArray());
        $response = new MemberResponse('req_1', 200, 'member_123', $member, $organization);
        $array = $response->toArray();
        $this->assertEquals('req_1', $array['request_id']);
        $this->assertEquals(200, $array['status_code']);
        $this->assertEquals('member_123', $array['member_id']);
        $this->assertEquals($member->toArray(), $array['member']);
        $this->assertEquals($organization->toArray(), $array['organization']);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'member_id' => 'member_123',
            'member' => $this->getMemberArray(),
            'organization' => $this->getOrganizationArray(),
        ];
        $response = MemberResponse::fromArray($originalData);
        $convertedData = $response->toArray();
        // Compare only the fields present in the original data
        $this->assertEquals($originalData['request_id'], $convertedData['request_id']);
        $this->assertEquals($originalData['status_code'], $convertedData['status_code']);
        $this->assertEquals($originalData['member_id'], $convertedData['member_id']);
        // Compare nested objects
        foreach (
            $originalData['member'] as $field => $value
        ) {
            if (!array_key_exists($field, $convertedData['member'])) {
                // Skip fields not present in the converted data
                continue;
            }
            if ($field === 'created_at') {
                $this->assertStringContainsString('2023-01-01', $convertedData['member'][$field]);
            } elseif ($field === 'updated_at') {
                $this->assertStringContainsString('2023-01-02', $convertedData['member'][$field]);
            } else {
                $this->assertEquals($value, $convertedData['member'][$field]);
            }
        }
        foreach (
            $originalData['organization'] as $field => $value
        ) {
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
