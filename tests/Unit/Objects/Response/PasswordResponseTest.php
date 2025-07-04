<?php

namespace Stytch\Tests\Unit\Objects\Response;

use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\PasswordResponse;
use Stytch\Objects\Member;
use Stytch\Objects\Organization;
use Stytch\Objects\Session;

class PasswordResponseTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private function getMemberArray(): array
    {
        return [
            'organization_id' => 'org_123',
            'member_id' => 'member_123',
            'email_address' => 'test@example.com',
            'status' => 'active',
            'name' => 'John Doe',
            'sso_registrations' => [
                [
                    'connection_id' => 'sso_conn_123',
                    'external_id' => 'ext_123',
                    'registration_id' => 'reg_123',
                ],
            ],
            'is_breakglass' => false,
            'member_password_id' => 'password_123',
            'oauth_registrations' => [
                [
                    'provider_type' => 'google',
                    'provider_subject' => 'sub_123',
                    'member_oauth_registration_id' => 'oauth_reg_123',
                ],
            ],
            'email_address_verified' => true,
            'mfa_phone_number_verified' => true,
            'is_admin' => false,
            'totp_registration_id' => 'totp_reg_123',
            'retired_email_addresses' => [
                [
                    'email_id' => 'retired_email_123',
                    'email_address' => 'old@example.com',
                ],
            ],
            'is_locked' => false,
            'mfa_enrolled' => true,
            'mfa_phone_number' => '+1234567890',
            'default_mfa_method' => 'totp',
            'roles' => [
                [
                    'role_id' => 'role_123',
                    'sources' => [
                        [
                            'type' => 'manual',
                            'details' => null,
                        ],
                    ],
                ],
            ],
            'trusted_metadata' => ['trusted' => 'data'],
            'untrusted_metadata' => ['untrusted' => 'data'],
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

    /**
     * @return array<string, mixed>
     */
    private function getSessionArray(): array
    {
        return [
            'member_session_id' => 'session_123',
            'member_id' => 'member_123',
            'organization_id' => 'org_123',
            'started_at' => '2023-01-01T00:00:00Z',
            'last_accessed_at' => '2023-01-02T00:00:00Z',
            'expires_at' => '2023-01-03T00:00:00Z',
            'authentication_factors' => [
                [
                    'delivery_method' => 'email',
                    'type' => 'password',
                    'last_authenticated_at' => '2023-01-01T00:00:00Z',
                ],
            ],
            'custom_claims' => [],
            'roles' => [],
        ];
    }

    public function testConstructor(): void
    {
        $member = Member::fromArray($this->getMemberArray());
        $organization = Organization::fromArray($this->getOrganizationArray());
        $response = new PasswordResponse(
            'req_1',
            200,
            'member_123',
            'org_123',
            $member,
            $organization,
            'session_token_456',
            'session_jwt_789',
            'intermediate_session_token_101',
            true
        );

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('member_123', $response->member_id);
        $this->assertEquals('org_123', $response->organization_id);
        $this->assertInstanceOf(Member::class, $response->member);
        $this->assertInstanceOf(Organization::class, $response->organization);
        $this->assertEquals('session_token_456', $response->session_token);
        $this->assertEquals('session_jwt_789', $response->session_jwt);
        $this->assertEquals('intermediate_session_token_101', $response->intermediate_session_token);
        $this->assertTrue($response->member_authenticated);
        $this->assertNull($response->member_session);
    }

    public function testConstructorWithSession(): void
    {
        $member = Member::fromArray($this->getMemberArray());
        $organization = Organization::fromArray($this->getOrganizationArray());
        $session = Session::fromArray($this->getSessionArray());
        $response = new PasswordResponse(
            'req_1',
            200,
            'member_123',
            'org_123',
            $member,
            $organization,
            'session_token_456',
            'session_jwt_789',
            'intermediate_session_token_101',
            true,
            $session
        );

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('member_123', $response->member_id);
        $this->assertEquals('org_123', $response->organization_id);
        $this->assertInstanceOf(Member::class, $response->member);
        $this->assertInstanceOf(Organization::class, $response->organization);
        $this->assertEquals('session_token_456', $response->session_token);
        $this->assertEquals('session_jwt_789', $response->session_jwt);
        $this->assertEquals('intermediate_session_token_101', $response->intermediate_session_token);
        $this->assertTrue($response->member_authenticated);
        $this->assertInstanceOf(Session::class, $response->member_session);
    }

    public function testFromArray(): void
    {
        $data = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'member_id' => 'member_123',
            'organization_id' => 'org_123',
            'member' => $this->getMemberArray(),
            'organization' => $this->getOrganizationArray(),
            'session_token' => 'session_token_456',
            'session_jwt' => 'session_jwt_789',
            'intermediate_session_token' => 'intermediate_session_token_101',
            'member_authenticated' => true,
        ];

        $response = PasswordResponse::fromArray($data);

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('member_123', $response->member_id);
        $this->assertEquals('org_123', $response->organization_id);
        $this->assertInstanceOf(Member::class, $response->member);
        $this->assertInstanceOf(Organization::class, $response->organization);
        $this->assertEquals('session_token_456', $response->session_token);
        $this->assertEquals('session_jwt_789', $response->session_jwt);
        $this->assertEquals('intermediate_session_token_101', $response->intermediate_session_token);
        $this->assertTrue($response->member_authenticated);
        $this->assertNull($response->member_session);
    }

    public function testFromArrayWithSession(): void
    {
        $data = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'member_id' => 'member_123',
            'organization_id' => 'org_123',
            'member' => $this->getMemberArray(),
            'organization' => $this->getOrganizationArray(),
            'session_token' => 'session_token_456',
            'session_jwt' => 'session_jwt_789',
            'intermediate_session_token' => 'intermediate_session_token_101',
            'member_authenticated' => true,
            'member_session' => $this->getSessionArray(),
        ];

        $response = PasswordResponse::fromArray($data);

        $this->assertEquals('req_1', $response->request_id);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('member_123', $response->member_id);
        $this->assertEquals('org_123', $response->organization_id);
        $this->assertInstanceOf(Member::class, $response->member);
        $this->assertInstanceOf(Organization::class, $response->organization);
        $this->assertEquals('session_token_456', $response->session_token);
        $this->assertEquals('session_jwt_789', $response->session_jwt);
        $this->assertEquals('intermediate_session_token_101', $response->intermediate_session_token);
        $this->assertTrue($response->member_authenticated);
        $this->assertInstanceOf(Session::class, $response->member_session);
    }

    public function testToArray(): void
    {
        $member = Member::fromArray($this->getMemberArray());
        $organization = Organization::fromArray($this->getOrganizationArray());
        $response = new PasswordResponse(
            'req_1',
            200,
            'member_123',
            'org_123',
            $member,
            $organization,
            'session_token_456',
            'session_jwt_789',
            'intermediate_session_token_101',
            true
        );

        $array = $response->toArray();

        $this->assertEquals('req_1', $array['request_id']);
        $this->assertEquals(200, $array['status_code']);
        $this->assertEquals('member_123', $array['member_id']);
        $this->assertEquals('org_123', $array['organization_id']);
        $this->assertEquals($member->toArray(), $array['member']);
        $this->assertEquals($organization->toArray(), $array['organization']);
        $this->assertEquals('session_token_456', $array['session_token']);
        $this->assertEquals('session_jwt_789', $array['session_jwt']);
        $this->assertEquals('intermediate_session_token_101', $array['intermediate_session_token']);
        $this->assertTrue($array['member_authenticated']);
        $this->assertNull($array['member_session']);
    }

    public function testToArrayWithSession(): void
    {
        $member = Member::fromArray($this->getMemberArray());
        $organization = Organization::fromArray($this->getOrganizationArray());
        $session = Session::fromArray($this->getSessionArray());
        $response = new PasswordResponse(
            'req_1',
            200,
            'member_123',
            'org_123',
            $member,
            $organization,
            'session_token_456',
            'session_jwt_789',
            'intermediate_session_token_101',
            true,
            $session
        );

        $array = $response->toArray();

        $this->assertEquals('req_1', $array['request_id']);
        $this->assertEquals(200, $array['status_code']);
        $this->assertEquals('member_123', $array['member_id']);
        $this->assertEquals('org_123', $array['organization_id']);
        $this->assertEquals($member->toArray(), $array['member']);
        $this->assertEquals($organization->toArray(), $array['organization']);
        $this->assertEquals('session_token_456', $array['session_token']);
        $this->assertEquals('session_jwt_789', $array['session_jwt']);
        $this->assertEquals('intermediate_session_token_101', $array['intermediate_session_token']);
        $this->assertTrue($array['member_authenticated']);
        $this->assertEquals($session->toArray(), $array['member_session']);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'member_id' => 'member_123',
            'organization_id' => 'org_123',
            'member' => $this->getMemberArray(),
            'organization' => $this->getOrganizationArray(),
            'session_token' => 'session_token_456',
            'session_jwt' => 'session_jwt_789',
            'intermediate_session_token' => 'intermediate_session_token_101',
            'member_authenticated' => true,
        ];

        $response = PasswordResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData['request_id'], $convertedData['request_id']);
        $this->assertEquals($originalData['status_code'], $convertedData['status_code']);
        $this->assertEquals($originalData['member_id'], $convertedData['member_id']);
        $this->assertEquals($originalData['organization_id'], $convertedData['organization_id']);
        $this->assertEquals($originalData['session_token'], $convertedData['session_token']);
        $this->assertEquals($originalData['session_jwt'], $convertedData['session_jwt']);
        $this->assertEquals($originalData['intermediate_session_token'], $convertedData['intermediate_session_token']);
        $this->assertEquals($originalData['member_authenticated'], $convertedData['member_authenticated']);

        // Compare member fields, allowing for extra null fields in output and microseconds in date strings
        foreach ($originalData['member'] as $field => $value) {
            if (!array_key_exists($field, $convertedData['member'])) {
                continue;
            }
            if (in_array($field, ['created_at', 'updated_at'])) {
                $prefix = substr($value, 0, 19);
                if ($prefix !== '') {
                    $this->assertStringStartsWith($prefix, $convertedData['member'][$field]);
                }
            } elseif (is_array($value)) {
                foreach ($value as $i => $subValue) {
                    if (is_array($subValue)) {
                        foreach ($subValue as $subField => $subFieldValue) {
                            if (!array_key_exists($subField, $convertedData['member'][$field][$i])) {
                                continue;
                            }
                            $this->assertEquals($subFieldValue, $convertedData['member'][$field][$i][$subField]);
                        }
                    } else {
                        $this->assertEquals($subValue, $convertedData['member'][$field][$i]);
                    }
                }
            } else {
                $this->assertEquals($value, $convertedData['member'][$field]);
            }
        }

        // Compare organization fields, allowing for microseconds in date strings
        foreach ($originalData['organization'] as $field => $value) {
            if (!array_key_exists($field, $convertedData['organization'])) {
                continue;
            }
            if (in_array($field, ['created_at', 'updated_at'])) {
                $prefix = substr($value, 0, 19);
                if ($prefix !== '') {
                    $this->assertStringStartsWith($prefix, $convertedData['organization'][$field]);
                }
            } else {
                $this->assertEquals($value, $convertedData['organization'][$field]);
            }
        }
    }

    public function testRoundTripConversionWithSession(): void
    {
        $originalData = [
            'request_id' => 'req_1',
            'status_code' => 200,
            'member_id' => 'member_123',
            'organization_id' => 'org_123',
            'member' => $this->getMemberArray(),
            'organization' => $this->getOrganizationArray(),
            'session_token' => 'session_token_456',
            'session_jwt' => 'session_jwt_789',
            'intermediate_session_token' => 'intermediate_session_token_101',
            'member_authenticated' => true,
            'member_session' => $this->getSessionArray(),
        ];

        $response = PasswordResponse::fromArray($originalData);
        $convertedData = $response->toArray();

        $this->assertEquals($originalData['request_id'], $convertedData['request_id']);
        $this->assertEquals($originalData['status_code'], $convertedData['status_code']);
        $this->assertEquals($originalData['member_id'], $convertedData['member_id']);
        $this->assertEquals($originalData['organization_id'], $convertedData['organization_id']);
        $this->assertEquals($originalData['session_token'], $convertedData['session_token']);
        $this->assertEquals($originalData['session_jwt'], $convertedData['session_jwt']);
        $this->assertEquals($originalData['intermediate_session_token'], $convertedData['intermediate_session_token']);
        $this->assertEquals($originalData['member_authenticated'], $convertedData['member_authenticated']);

        // Compare member_session fields, allowing for microseconds in date strings
        foreach ($originalData['member_session'] as $field => $value) {
            if (!array_key_exists($field, $convertedData['member_session'])) {
                continue;
            }
            if (in_array($field, ['started_at', 'last_accessed_at', 'expires_at'])) {
                $prefix = substr($value, 0, 19);
                if ($prefix !== '') {
                    $this->assertStringStartsWith($prefix, $convertedData['member_session'][$field]);
                }
            } elseif ($field === 'authentication_factors') {
                foreach ($value as $i => $factor) {
                    foreach ($factor as $factorField => $factorValue) {
                        $this->assertArrayHasKey($factorField, $convertedData['member_session'][$field][$i]);
                        if ($factorField === 'last_authenticated_at') {
                            $prefix = substr($factorValue, 0, 19);
                            if ($prefix !== '') {
                                $this->assertStringStartsWith($prefix, $convertedData['member_session'][$field][$i][$factorField]);
                            }
                        } else {
                            $this->assertEquals($factorValue, $convertedData['member_session'][$field][$i][$factorField]);
                        }
                    }
                }
            } else {
                $this->assertEquals($value, $convertedData['member_session'][$field]);
            }
        }
    }
}
