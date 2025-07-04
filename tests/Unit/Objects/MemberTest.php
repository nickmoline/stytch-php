<?php

namespace Stytch\Tests\Unit\Objects;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Stytch\Objects\Member;
use Stytch\Objects\SSORegistration;
use Stytch\Objects\OAuthRegistration;
use Stytch\Objects\RetiredEmail;
use Stytch\Objects\MemberRole;
use Stytch\Objects\MemberRoleSource;
use Stytch\Objects\SCIMRegistration;

class MemberTest extends TestCase
{
    public function testMemberConstructor(): void
    {
        $createdAt = Carbon::parse('2023-01-01T12:00:00Z');
        $updatedAt = Carbon::parse('2023-01-01T13:00:00Z');
        $lockCreatedAt = Carbon::parse('2023-01-01T11:00:00Z');
        $lockExpiresAt = Carbon::parse('2023-01-01T14:00:00Z');

        $member = new Member(
            'org_123',
            'member_456',
            'test@example.com',
            'active',
            'John Doe',
            [new SSORegistration('sso_123', 'ext_123', 'reg_123', ['attr' => 'value'])],
            false,
            'pwd_123',
            [new OAuthRegistration('google', 'google_123', 'oauth_123', 'https://example.com/avatar.jpg', 'en')],
            true,
            true,
            false,
            'totp_123',
            [new RetiredEmail('email_123', 'old@example.com')],
            false,
            true,
            '+1234567890',
            'totp',
            [new MemberRole('role_123', [new MemberRoleSource('manual', ['admin' => 'true'])])],
            ['trusted' => 'data'],
            ['untrusted' => 'data'],
            $createdAt,
            $updatedAt,
            new SCIMRegistration('scim_123', 'scim_reg_123', 'scim_ext_123', ['scim_attr' => 'value']),
            'ext_123',
            $lockCreatedAt,
            $lockExpiresAt
        );

        $this->assertEquals('org_123', $member->organization_id);
        $this->assertEquals('member_456', $member->member_id);
        $this->assertEquals('test@example.com', $member->email_address);
        $this->assertEquals('active', $member->status);
        $this->assertEquals('John Doe', $member->name);
        $this->assertCount(1, $member->sso_registrations);
        $this->assertFalse($member->is_breakglass);
        $this->assertEquals('pwd_123', $member->member_password_id);
        $this->assertCount(1, $member->oauth_registrations);
        $this->assertTrue($member->email_address_verified);
        $this->assertTrue($member->mfa_phone_number_verified);
        $this->assertFalse($member->is_admin);
        $this->assertEquals('totp_123', $member->totp_registration_id);
        $this->assertCount(1, $member->retired_email_addresses);
        $this->assertFalse($member->is_locked);
        $this->assertTrue($member->mfa_enrolled);
        $this->assertEquals('+1234567890', $member->mfa_phone_number);
        $this->assertEquals('totp', $member->default_mfa_method);
        $this->assertCount(1, $member->roles);
        $this->assertEquals(['trusted' => 'data'], $member->trusted_metadata);
        $this->assertEquals(['untrusted' => 'data'], $member->untrusted_metadata);
        $this->assertSame($createdAt, $member->created_at);
        $this->assertSame($updatedAt, $member->updated_at);
        $this->assertInstanceOf(SCIMRegistration::class, $member->scim_registration);
        $this->assertEquals('ext_123', $member->external_id);
        $this->assertSame($lockCreatedAt, $member->lock_created_at);
        $this->assertSame($lockExpiresAt, $member->lock_expires_at);
    }

    public function testMemberFromArray(): void
    {
        $data = [
            'organization_id' => 'org_123',
            'member_id' => 'member_456',
            'email_address' => 'test@example.com',
            'status' => 'active',
            'name' => 'John Doe',
            'sso_registrations' => [
                [
                    'connection_id' => 'sso_123',
                    'external_id' => 'ext_123',
                    'registration_id' => 'reg_123',
                    'sso_attributes' => ['attr' => 'value']
                ]
            ],
            'is_breakglass' => false,
            'member_password_id' => 'pwd_123',
            'oauth_registrations' => [
                [
                    'provider_type' => 'google',
                    'provider_subject' => 'google_123',
                    'member_oauth_registration_id' => 'oauth_123',
                    'profile_picture_url' => 'https://example.com/avatar.jpg',
                    'locale' => 'en'
                ]
            ],
            'email_address_verified' => true,
            'mfa_phone_number_verified' => true,
            'is_admin' => false,
            'totp_registration_id' => 'totp_123',
            'retired_email_addresses' => [
                [
                    'email_id' => 'email_123',
                    'email_address' => 'old@example.com'
                ]
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
                            'details' => ['admin' => 'true']
                        ]
                    ]
                ]
            ],
            'trusted_metadata' => ['trusted' => 'data'],
            'untrusted_metadata' => ['untrusted' => 'data'],
            'created_at' => '2023-01-01T12:00:00Z',
            'updated_at' => '2023-01-01T13:00:00Z',
            'scim_registration' => [
                'connection_id' => 'scim_123',
                'registration_id' => 'scim_reg_123',
                'external_id' => 'scim_ext_123',
                'scim_attributes' => ['scim_attr' => 'value']
            ],
            'external_id' => 'ext_123',
            'lock_created_at' => '2023-01-01T11:00:00Z',
            'lock_expires_at' => '2023-01-01T14:00:00Z'
        ];

        $member = Member::fromArray($data);

        $this->assertEquals('org_123', $member->organization_id);
        $this->assertEquals('member_456', $member->member_id);
        $this->assertEquals('test@example.com', $member->email_address);
        $this->assertEquals('active', $member->status);
        $this->assertEquals('John Doe', $member->name);
        $this->assertCount(1, $member->sso_registrations);
        $this->assertFalse($member->is_breakglass);
        $this->assertEquals('pwd_123', $member->member_password_id);
        $this->assertCount(1, $member->oauth_registrations);
        $this->assertTrue($member->email_address_verified);
        $this->assertTrue($member->mfa_phone_number_verified);
        $this->assertFalse($member->is_admin);
        $this->assertEquals('totp_123', $member->totp_registration_id);
        $this->assertCount(1, $member->retired_email_addresses);
        $this->assertFalse($member->is_locked);
        $this->assertTrue($member->mfa_enrolled);
        $this->assertEquals('+1234567890', $member->mfa_phone_number);
        $this->assertEquals('totp', $member->default_mfa_method);
        $this->assertCount(1, $member->roles);
        $this->assertEquals(['trusted' => 'data'], $member->trusted_metadata);
        $this->assertEquals(['untrusted' => 'data'], $member->untrusted_metadata);
        $this->assertInstanceOf(Carbon::class, $member->created_at);
        $this->assertInstanceOf(Carbon::class, $member->updated_at);
        $this->assertInstanceOf(SCIMRegistration::class, $member->scim_registration);
        $this->assertEquals('ext_123', $member->external_id);
        $this->assertInstanceOf(Carbon::class, $member->lock_created_at);
        $this->assertInstanceOf(Carbon::class, $member->lock_expires_at);
    }

    public function testMemberToArray(): void
    {
        $createdAt = Carbon::parse('2023-01-01T12:00:00Z');
        $updatedAt = Carbon::parse('2023-01-01T13:00:00Z');
        $lockCreatedAt = Carbon::parse('2023-01-01T11:00:00Z');
        $lockExpiresAt = Carbon::parse('2023-01-01T14:00:00Z');

        $member = new Member(
            'org_123',
            'member_456',
            'test@example.com',
            'active',
            'John Doe',
            [new SSORegistration('sso_123', 'ext_123', 'reg_123', ['attr' => 'value'])],
            false,
            'pwd_123',
            [new OAuthRegistration('google', 'google_123', 'oauth_123', 'https://example.com/avatar.jpg', 'en')],
            true,
            true,
            false,
            'totp_123',
            [new RetiredEmail('email_123', 'old@example.com')],
            false,
            true,
            '+1234567890',
            'totp',
            [new MemberRole('role_123', [new MemberRoleSource('manual', ['admin' => 'true'])])],
            ['trusted' => 'data'],
            ['untrusted' => 'data'],
            $createdAt,
            $updatedAt,
            new SCIMRegistration('scim_123', 'scim_reg_123', 'scim_ext_123', ['scim_attr' => 'value']),
            'ext_123',
            $lockCreatedAt,
            $lockExpiresAt
        );

        $array = $member->toArray();

        $this->assertEquals('org_123', $array['organization_id']);
        $this->assertEquals('member_456', $array['member_id']);
        $this->assertEquals('test@example.com', $array['email_address']);
        $this->assertEquals('active', $array['status']);
        $this->assertEquals('John Doe', $array['name']);
        $this->assertCount(1, $array['sso_registrations']);
        $this->assertFalse($array['is_breakglass']);
        $this->assertEquals('pwd_123', $array['member_password_id']);
        $this->assertCount(1, $array['oauth_registrations']);
        $this->assertTrue($array['email_address_verified']);
        $this->assertTrue($array['mfa_phone_number_verified']);
        $this->assertFalse($array['is_admin']);
        $this->assertEquals('totp_123', $array['totp_registration_id']);
        $this->assertCount(1, $array['retired_email_addresses']);
        $this->assertFalse($array['is_locked']);
        $this->assertTrue($array['mfa_enrolled']);
        $this->assertEquals('+1234567890', $array['mfa_phone_number']);
        $this->assertEquals('totp', $array['default_mfa_method']);
        $this->assertCount(1, $array['roles']);
        $this->assertEquals(['trusted' => 'data'], $array['trusted_metadata']);
        $this->assertEquals(['untrusted' => 'data'], $array['untrusted_metadata']);
        $this->assertEquals('2023-01-01T12:00:00.000000Z', $array['created_at']);
        $this->assertEquals('2023-01-01T13:00:00.000000Z', $array['updated_at']);
        $this->assertIsArray($array['scim_registration']);
        $this->assertEquals('ext_123', $array['external_id']);
        $this->assertEquals('2023-01-01T11:00:00.000000Z', $array['lock_created_at']);
        $this->assertEquals('2023-01-01T14:00:00.000000Z', $array['lock_expires_at']);
    }

    public function testSSORegistrationConstructor(): void
    {
        $registration = new SSORegistration('sso_123', 'ext_123', 'reg_123', ['attr' => 'value']);

        $this->assertEquals('sso_123', $registration->connection_id);
        $this->assertEquals('ext_123', $registration->external_id);
        $this->assertEquals('reg_123', $registration->registration_id);
        $this->assertEquals(['attr' => 'value'], $registration->sso_attributes);
    }

    public function testSSORegistrationFromArray(): void
    {
        $data = [
            'connection_id' => 'sso_123',
            'external_id' => 'ext_123',
            'registration_id' => 'reg_123',
            'sso_attributes' => ['attr' => 'value']
        ];

        $registration = SSORegistration::fromArray($data);

        $this->assertEquals('sso_123', $registration->connection_id);
        $this->assertEquals('ext_123', $registration->external_id);
        $this->assertEquals('reg_123', $registration->registration_id);
        $this->assertEquals(['attr' => 'value'], $registration->sso_attributes);
    }

    public function testSSORegistrationToArray(): void
    {
        $registration = new SSORegistration('sso_123', 'ext_123', 'reg_123', ['attr' => 'value']);

        $array = $registration->toArray();

        $this->assertEquals('sso_123', $array['connection_id']);
        $this->assertEquals('ext_123', $array['external_id']);
        $this->assertEquals('reg_123', $array['registration_id']);
        $this->assertEquals(['attr' => 'value'], $array['sso_attributes']);
    }

    public function testOAuthRegistrationConstructor(): void
    {
        $registration = new OAuthRegistration('google', 'google_123', 'oauth_123', 'https://example.com/avatar.jpg', 'en');

        $this->assertEquals('google', $registration->provider_type);
        $this->assertEquals('google_123', $registration->provider_subject);
        $this->assertEquals('oauth_123', $registration->member_oauth_registration_id);
        $this->assertEquals('https://example.com/avatar.jpg', $registration->profile_picture_url);
        $this->assertEquals('en', $registration->locale);
    }

    public function testOAuthRegistrationFromArray(): void
    {
        $data = [
            'provider_type' => 'google',
            'provider_subject' => 'google_123',
            'member_oauth_registration_id' => 'oauth_123',
            'profile_picture_url' => 'https://example.com/avatar.jpg',
            'locale' => 'en'
        ];

        $registration = OAuthRegistration::fromArray($data);

        $this->assertEquals('google', $registration->provider_type);
        $this->assertEquals('google_123', $registration->provider_subject);
        $this->assertEquals('oauth_123', $registration->member_oauth_registration_id);
        $this->assertEquals('https://example.com/avatar.jpg', $registration->profile_picture_url);
        $this->assertEquals('en', $registration->locale);
    }

    public function testOAuthRegistrationToArray(): void
    {
        $registration = new OAuthRegistration('google', 'google_123', 'oauth_123', 'https://example.com/avatar.jpg', 'en');

        $array = $registration->toArray();

        $this->assertEquals('google', $array['provider_type']);
        $this->assertEquals('google_123', $array['provider_subject']);
        $this->assertEquals('oauth_123', $array['member_oauth_registration_id']);
        $this->assertEquals('https://example.com/avatar.jpg', $array['profile_picture_url']);
        $this->assertEquals('en', $array['locale']);
    }

    public function testRetiredEmailConstructor(): void
    {
        $email = new RetiredEmail('email_123', 'old@example.com');

        $this->assertEquals('email_123', $email->email_id);
        $this->assertEquals('old@example.com', $email->email_address);
    }

    public function testRetiredEmailFromArray(): void
    {
        $data = [
            'email_id' => 'email_123',
            'email_address' => 'old@example.com'
        ];

        $email = RetiredEmail::fromArray($data);

        $this->assertEquals('email_123', $email->email_id);
        $this->assertEquals('old@example.com', $email->email_address);
    }

    public function testRetiredEmailToArray(): void
    {
        $email = new RetiredEmail('email_123', 'old@example.com');

        $array = $email->toArray();

        $this->assertEquals('email_123', $array['email_id']);
        $this->assertEquals('old@example.com', $array['email_address']);
    }

    public function testMemberRoleConstructor(): void
    {
        $role = new MemberRole('role_123', [new MemberRoleSource('manual', ['admin' => 'true'])]);

        $this->assertEquals('role_123', $role->role_id);
        $this->assertCount(1, $role->sources);
    }

    public function testMemberRoleFromArray(): void
    {
        $data = [
            'role_id' => 'role_123',
            'sources' => [
                [
                    'type' => 'manual',
                    'details' => ['admin' => 'true']
                ]
            ]
        ];

        $role = MemberRole::fromArray($data);

        $this->assertEquals('role_123', $role->role_id);
        $this->assertCount(1, $role->sources);
    }

    public function testMemberRoleToArray(): void
    {
        $role = new MemberRole('role_123', [new MemberRoleSource('manual', ['admin' => 'true'])]);

        $array = $role->toArray();

        $this->assertEquals('role_123', $array['role_id']);
        $this->assertCount(1, $array['sources']);
    }

    public function testMemberRoleSourceConstructor(): void
    {
        $source = new MemberRoleSource('manual', ['admin' => 'true']);

        $this->assertEquals('manual', $source->type);
        $this->assertEquals(['admin' => 'true'], $source->details);
    }

    public function testMemberRoleSourceFromArray(): void
    {
        $data = [
            'type' => 'manual',
            'details' => ['admin' => 'true']
        ];

        $source = MemberRoleSource::fromArray($data);

        $this->assertEquals('manual', $source->type);
        $this->assertEquals(['admin' => 'true'], $source->details);
    }

    public function testMemberRoleSourceToArray(): void
    {
        $source = new MemberRoleSource('manual', ['admin' => 'true']);

        $array = $source->toArray();

        $this->assertEquals('manual', $array['type']);
        $this->assertEquals(['admin' => 'true'], $array['details']);
    }

    public function testSCIMRegistrationConstructor(): void
    {
        $registration = new SCIMRegistration('scim_123', 'scim_reg_123', 'scim_ext_123', ['scim_attr' => 'value']);

        $this->assertEquals('scim_123', $registration->connection_id);
        $this->assertEquals('scim_reg_123', $registration->registration_id);
        $this->assertEquals('scim_ext_123', $registration->external_id);
        $this->assertEquals(['scim_attr' => 'value'], $registration->scim_attributes);
    }

    public function testSCIMRegistrationFromArray(): void
    {
        $data = [
            'connection_id' => 'scim_123',
            'registration_id' => 'scim_reg_123',
            'external_id' => 'scim_ext_123',
            'scim_attributes' => ['scim_attr' => 'value']
        ];

        $registration = SCIMRegistration::fromArray($data);

        $this->assertEquals('scim_123', $registration->connection_id);
        $this->assertEquals('scim_reg_123', $registration->registration_id);
        $this->assertEquals('scim_ext_123', $registration->external_id);
        $this->assertEquals(['scim_attr' => 'value'], $registration->scim_attributes);
    }

    public function testSCIMRegistrationToArray(): void
    {
        $registration = new SCIMRegistration('scim_123', 'scim_reg_123', 'scim_ext_123', ['scim_attr' => 'value']);

        $array = $registration->toArray();

        $this->assertEquals('scim_123', $array['connection_id']);
        $this->assertEquals('scim_reg_123', $array['registration_id']);
        $this->assertEquals('scim_ext_123', $array['external_id']);
        $this->assertEquals(['scim_attr' => 'value'], $array['scim_attributes']);
    }
}
