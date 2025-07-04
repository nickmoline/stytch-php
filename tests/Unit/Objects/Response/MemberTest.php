<?php

namespace Stytch\Tests\Unit\Objects\Response;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Stytch\Objects\Response\Member;

class MemberTest extends TestCase
{
    public function testConstructor(): void
    {
        $createdAt = Carbon::parse('2023-01-01T00:00:00Z');
        $updatedAt = Carbon::parse('2023-01-02T00:00:00Z');

        $member = new Member(
            'member_123',
            'test@example.com',
            'John Doe',
            ['trusted' => 'data'],
            ['untrusted' => 'data'],
            'active',
            '+1234567890',
            true,
            ['admin', 'user'],
            'ext_123',
            false,
            'totp',
            [
                [
                    'email_id' => 'email_123',
                    'email' => 'test@example.com',
                    'verified' => true,
                ],
            ],
            [
                [
                    'phone_id' => 'phone_123',
                    'phone_number' => '+1234567890',
                    'verified' => true,
                ],
            ],
            [
                [
                    'totp_id' => 'totp_123',
                    'verified' => true,
                ],
            ],
            [
                [
                    'password_id' => 'password_123',
                    'verified' => true,
                ],
            ],
            [
                [
                    'oauth_provider_id' => 'oauth_123',
                    'provider' => 'google',
                    'verified' => true,
                ],
            ],
            [
                [
                    'connected_app_id' => 'app_123',
                    'app_name' => 'Test App',
                ],
            ],
            $createdAt,
            $updatedAt
        );

        $this->assertEquals('member_123', $member->member_id);
        $this->assertEquals('test@example.com', $member->email_address);
        $this->assertEquals('John Doe', $member->name);
        $this->assertEquals(['trusted' => 'data'], $member->trusted_metadata);
        $this->assertEquals(['untrusted' => 'data'], $member->untrusted_metadata);
        $this->assertEquals('active', $member->status);
        $this->assertEquals('+1234567890', $member->mfa_phone_number);
        $this->assertTrue($member->mfa_enrolled);
        $this->assertEquals(['admin', 'user'], $member->roles);
        $this->assertEquals('ext_123', $member->external_id);
        $this->assertFalse($member->is_breakglass);
        $this->assertEquals('totp', $member->default_mfa_method);
        $this->assertCount(1, $member->emails);
        $this->assertCount(1, $member->phone_numbers);
        $this->assertCount(1, $member->totps);
        $this->assertCount(1, $member->passwords);
        $this->assertCount(1, $member->oauth_providers);
        $this->assertCount(1, $member->connected_apps);
        $this->assertEquals($createdAt, $member->created_at);
        $this->assertEquals($updatedAt, $member->updated_at);
    }

    public function testConstructorWithNullValues(): void
    {
        $createdAt = Carbon::parse('2023-01-01T00:00:00Z');
        $updatedAt = Carbon::parse('2023-01-02T00:00:00Z');

        $member = new Member(
            'member_123',
            'test@example.com',
            null,
            null,
            null,
            'active',
            null,
            false,
            [],
            null,
            false,
            null,
            [],
            [],
            [],
            [],
            [],
            [],
            $createdAt,
            $updatedAt
        );

        $this->assertEquals('member_123', $member->member_id);
        $this->assertEquals('test@example.com', $member->email_address);
        $this->assertNull($member->name);
        $this->assertNull($member->trusted_metadata);
        $this->assertNull($member->untrusted_metadata);
        $this->assertEquals('active', $member->status);
        $this->assertNull($member->mfa_phone_number);
        $this->assertFalse($member->mfa_enrolled);
        $this->assertEquals([], $member->roles);
        $this->assertNull($member->external_id);
        $this->assertFalse($member->is_breakglass);
        $this->assertNull($member->default_mfa_method);
        $this->assertEquals([], $member->emails);
        $this->assertEquals([], $member->phone_numbers);
        $this->assertEquals([], $member->totps);
        $this->assertEquals([], $member->passwords);
        $this->assertEquals([], $member->oauth_providers);
        $this->assertEquals([], $member->connected_apps);
        $this->assertEquals($createdAt, $member->created_at);
        $this->assertEquals($updatedAt, $member->updated_at);
    }

    public function testFromArray(): void
    {
        $data = [
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

        $member = Member::fromArray($data);

        $this->assertEquals('member_123', $member->member_id);
        $this->assertEquals('test@example.com', $member->email_address);
        $this->assertEquals('John Doe', $member->name);
        $this->assertEquals(['trusted' => 'data'], $member->trusted_metadata);
        $this->assertEquals(['untrusted' => 'data'], $member->untrusted_metadata);
        $this->assertEquals('active', $member->status);
        $this->assertEquals('+1234567890', $member->mfa_phone_number);
        $this->assertTrue($member->mfa_enrolled);
        $this->assertEquals(['admin', 'user'], $member->roles);
        $this->assertEquals('ext_123', $member->external_id);
        $this->assertFalse($member->is_breakglass);
        $this->assertEquals('totp', $member->default_mfa_method);
        $this->assertCount(1, $member->emails);
        $this->assertCount(1, $member->phone_numbers);
        $this->assertCount(1, $member->totps);
        $this->assertCount(1, $member->passwords);
        $this->assertCount(1, $member->oauth_providers);
        $this->assertCount(1, $member->connected_apps);
        $this->assertInstanceOf(Carbon::class, $member->created_at);
        $this->assertInstanceOf(Carbon::class, $member->updated_at);
        $this->assertEquals('2023-01-01T00:00:00.000000Z', $member->created_at->toISOString());
        $this->assertEquals('2023-01-02T00:00:00.000000Z', $member->updated_at->toISOString());
    }

    public function testFromArrayWithNullValues(): void
    {
        $data = [
            'member_id' => 'member_123',
            'email_address' => 'test@example.com',
            'status' => 'active',
            'mfa_enrolled' => false,
            'roles' => [],
            'is_breakglass' => false,
            'emails' => [],
            'phone_numbers' => [],
            'totps' => [],
            'passwords' => [],
            'oauth_providers' => [],
            'connected_apps' => [],
            'created_at' => '2023-01-01T00:00:00Z',
            'updated_at' => '2023-01-02T00:00:00Z',
        ];

        $member = Member::fromArray($data);

        $this->assertEquals('member_123', $member->member_id);
        $this->assertEquals('test@example.com', $member->email_address);
        $this->assertNull($member->name);
        $this->assertNull($member->trusted_metadata);
        $this->assertNull($member->untrusted_metadata);
        $this->assertEquals('active', $member->status);
        $this->assertNull($member->mfa_phone_number);
        $this->assertFalse($member->mfa_enrolled);
        $this->assertEquals([], $member->roles);
        $this->assertNull($member->external_id);
        $this->assertFalse($member->is_breakglass);
        $this->assertNull($member->default_mfa_method);
        $this->assertEquals([], $member->emails);
        $this->assertEquals([], $member->phone_numbers);
        $this->assertEquals([], $member->totps);
        $this->assertEquals([], $member->passwords);
        $this->assertEquals([], $member->oauth_providers);
        $this->assertEquals([], $member->connected_apps);
        $this->assertInstanceOf(Carbon::class, $member->created_at);
        $this->assertInstanceOf(Carbon::class, $member->updated_at);
    }

    public function testToArray(): void
    {
        $createdAt = Carbon::parse('2023-01-01T00:00:00Z');
        $updatedAt = Carbon::parse('2023-01-02T00:00:00Z');

        $member = new Member(
            'member_123',
            'test@example.com',
            'John Doe',
            ['trusted' => 'data'],
            ['untrusted' => 'data'],
            'active',
            '+1234567890',
            true,
            ['admin', 'user'],
            'ext_123',
            false,
            'totp',
            [
                [
                    'email_id' => 'email_123',
                    'email' => 'test@example.com',
                    'verified' => true,
                ],
            ],
            [
                [
                    'phone_id' => 'phone_123',
                    'phone_number' => '+1234567890',
                    'verified' => true,
                ],
            ],
            [
                [
                    'totp_id' => 'totp_123',
                    'verified' => true,
                ],
            ],
            [
                [
                    'password_id' => 'password_123',
                    'verified' => true,
                ],
            ],
            [
                [
                    'oauth_provider_id' => 'oauth_123',
                    'provider' => 'google',
                    'verified' => true,
                ],
            ],
            [
                [
                    'connected_app_id' => 'app_123',
                    'app_name' => 'Test App',
                ],
            ],
            $createdAt,
            $updatedAt
        );

        $array = $member->toArray();

        $this->assertEquals([
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
            'created_at' => '2023-01-01T00:00:00.000000Z',
            'updated_at' => '2023-01-02T00:00:00.000000Z',
        ], $array);
    }

    public function testToArrayWithNullValues(): void
    {
        $createdAt = Carbon::parse('2023-01-01T00:00:00Z');
        $updatedAt = Carbon::parse('2023-01-02T00:00:00Z');

        $member = new Member(
            'member_123',
            'test@example.com',
            null,
            null,
            null,
            'active',
            null,
            false,
            [],
            null,
            false,
            null,
            [],
            [],
            [],
            [],
            [],
            [],
            $createdAt,
            $updatedAt
        );

        $array = $member->toArray();

        $this->assertEquals([
            'member_id' => 'member_123',
            'email_address' => 'test@example.com',
            'status' => 'active',
            'mfa_enrolled' => false,
            'roles' => [],
            'is_breakglass' => false,
            'emails' => [],
            'phone_numbers' => [],
            'totps' => [],
            'passwords' => [],
            'oauth_providers' => [],
            'connected_apps' => [],
            'created_at' => '2023-01-01T00:00:00.000000Z',
            'updated_at' => '2023-01-02T00:00:00.000000Z',
        ], $array);
    }

    public function testRoundTripConversion(): void
    {
        $originalData = [
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

        $member = Member::fromArray($originalData);
        $convertedData = $member->toArray();

        // Compare only the fields present in the original data
        foreach ($originalData as $field => $value) {
            if ($field === 'created_at') {
                // Carbon adds microseconds and Z format, so we check the date part
                $this->assertStringContainsString('2023-01-01', $convertedData[$field]);
            } elseif ($field === 'updated_at') {
                // Carbon adds microseconds and Z format, so we check the date part
                $this->assertStringContainsString('2023-01-02', $convertedData[$field]);
            } else {
                $this->assertEquals($value, $convertedData[$field]);
            }
        }
    }
}
