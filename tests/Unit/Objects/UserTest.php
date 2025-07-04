<?php

namespace Stytch\Tests\Unit\Objects;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Stytch\Objects\User;
use Stytch\Objects\UsersEmail;
use Stytch\Objects\UsersPhoneNumber;
use Stytch\Objects\WebAuthnRegistration;
use Stytch\Objects\OAuthProvider;
use Stytch\Objects\TOTP;
use Stytch\Objects\CryptoWallet;
use Stytch\Objects\BiometricRegistration;
use Stytch\Objects\UsersName;
use Stytch\Objects\UserPassword;

class UserTest extends TestCase
{
    public function testUserConstructor(): void
    {
        $createdAt = Carbon::now();
        $lockCreatedAt = Carbon::now()->subHours(1);
        $lockExpiresAt = Carbon::now()->addHours(1);
        $name = new UsersName('John', 'Doe');
        $password = new UserPassword('pwd_123', true);

        $user = new User(
            'user_123',
            [new UsersEmail('test@example.com', 'email_123', true)],
            'active',
            [new UsersPhoneNumber('+1234567890', 'phone_123', true)],
            [new WebAuthnRegistration('webauthn_123', 'example.com', 'Mozilla/5.0', true, 'platform', 'Test Device')],
            [new OAuthProvider('google', 'google_123', 'oauth_123', 'https://example.com/avatar.jpg', 'en')],
            [new TOTP('totp_123', true)],
            [new CryptoWallet('wallet_123', '0x123', 'ethereum', true)],
            [new BiometricRegistration('bio_123', true)],
            false,
            $name,
            $createdAt,
            $password,
            ['trusted' => 'data'],
            ['untrusted' => 'data'],
            'ext_123',
            $lockCreatedAt,
            $lockExpiresAt
        );

        $this->assertEquals('user_123', $user->user_id);
        $this->assertCount(1, $user->emails);
        $this->assertEquals('active', $user->status);
        $this->assertCount(1, $user->phone_numbers);
        $this->assertCount(1, $user->webauthn_registrations);
        $this->assertCount(1, $user->providers);
        $this->assertCount(1, $user->totps);
        $this->assertCount(1, $user->crypto_wallets);
        $this->assertCount(1, $user->biometric_registrations);
        $this->assertFalse($user->is_locked);
        $this->assertSame($name, $user->name);
        $this->assertSame($createdAt, $user->created_at);
        $this->assertSame($password, $user->password);
        $this->assertEquals(['trusted' => 'data'], $user->trusted_metadata);
        $this->assertEquals(['untrusted' => 'data'], $user->untrusted_metadata);
        $this->assertEquals('ext_123', $user->external_id);
        $this->assertSame($lockCreatedAt, $user->lock_created_at);
        $this->assertSame($lockExpiresAt, $user->lock_expires_at);
    }

    public function testUserFromArray(): void
    {
        $data = [
            'user_id' => 'user_123',
            'emails' => [
                [
                    'email_id' => 'email_123',
                    'email' => 'test@example.com',
                    'verified' => true
                ]
            ],
            'status' => 'active',
            'phone_numbers' => [
                [
                    'phone_id' => 'phone_123',
                    'phone_number' => '+1234567890',
                    'verified' => true
                ]
            ],
            'webauthn_registrations' => [
                [
                    'webauthn_registration_id' => 'webauthn_123',
                    'domain' => 'example.com',
                    'user_agent' => 'Mozilla/5.0',
                    'verified' => true,
                    'authenticator_type' => 'platform',
                    'name' => 'Test Device'
                ]
            ],
            'providers' => [
                [
                    'provider_type' => 'google',
                    'provider_subject' => 'google_123',
                    'oauth_user_registration_id' => 'oauth_123',
                    'profile_picture_url' => 'https://example.com/avatar.jpg',
                    'locale' => 'en'
                ]
            ],
            'totps' => [
                [
                    'totp_id' => 'totp_123',
                    'verified' => true
                ]
            ],
            'crypto_wallets' => [
                [
                    'crypto_wallet_id' => 'wallet_123',
                    'crypto_wallet_type' => 'ethereum',
                    'crypto_wallet_address' => '0x123',
                    'verified' => true
                ]
            ],
            'biometric_registrations' => [
                [
                    'biometric_registration_id' => 'bio_123',
                    'verified' => true
                ]
            ],
            'is_locked' => false,
            'name' => [
                'first_name' => 'John',
                'last_name' => 'Doe'
            ],
            'created_at' => '2023-01-01T12:00:00Z',
            'password' => [
                'password_id' => 'pwd_123',
                'requires_reset' => true
            ],
            'trusted_metadata' => ['trusted' => 'data'],
            'untrusted_metadata' => ['untrusted' => 'data'],
            'external_id' => 'ext_123',
            'lock_created_at' => '2023-01-01T11:00:00Z',
            'lock_expires_at' => '2023-01-01T13:00:00Z'
        ];

        $user = User::fromArray($data);

        $this->assertEquals('user_123', $user->user_id);
        $this->assertCount(1, $user->emails);
        $this->assertEquals('active', $user->status);
        $this->assertCount(1, $user->phone_numbers);
        $this->assertCount(1, $user->webauthn_registrations);
        $this->assertCount(1, $user->providers);
        $this->assertCount(1, $user->totps);
        $this->assertCount(1, $user->crypto_wallets);
        $this->assertCount(1, $user->biometric_registrations);
        $this->assertFalse($user->is_locked);
        $this->assertInstanceOf(UsersName::class, $user->name);
        $this->assertInstanceOf(Carbon::class, $user->created_at);
        $this->assertInstanceOf(UserPassword::class, $user->password);
        $this->assertEquals(['trusted' => 'data'], $user->trusted_metadata);
        $this->assertEquals(['untrusted' => 'data'], $user->untrusted_metadata);
        $this->assertEquals('ext_123', $user->external_id);
        $this->assertInstanceOf(Carbon::class, $user->lock_created_at);
        $this->assertInstanceOf(Carbon::class, $user->lock_expires_at);
    }

    public function testUserFromArrayWithNullValues(): void
    {
        $data = [
            'user_id' => 'user_123',
            'emails' => [],
            'status' => 'active',
            'phone_numbers' => [],
            'webauthn_registrations' => [],
            'providers' => [],
            'totps' => [],
            'crypto_wallets' => [],
            'biometric_registrations' => [],
            'is_locked' => false,
            'name' => null,
            'created_at' => null,
            'password' => null,
            'trusted_metadata' => null,
            'untrusted_metadata' => null,
            'external_id' => null,
            'lock_created_at' => null,
            'lock_expires_at' => null
        ];

        $user = User::fromArray($data);

        $this->assertEquals('user_123', $user->user_id);
        $this->assertEmpty($user->emails);
        $this->assertEquals('active', $user->status);
        $this->assertEmpty($user->phone_numbers);
        $this->assertEmpty($user->webauthn_registrations);
        $this->assertEmpty($user->providers);
        $this->assertEmpty($user->totps);
        $this->assertEmpty($user->crypto_wallets);
        $this->assertEmpty($user->biometric_registrations);
        $this->assertFalse($user->is_locked);
        $this->assertNull($user->name);
        $this->assertNull($user->created_at);
        $this->assertNull($user->password);
        $this->assertNull($user->trusted_metadata);
        $this->assertNull($user->untrusted_metadata);
        $this->assertNull($user->external_id);
        $this->assertNull($user->lock_created_at);
        $this->assertNull($user->lock_expires_at);
    }

    public function testUserToArray(): void
    {
        $createdAt = Carbon::parse('2023-01-01T12:00:00Z');
        $lockCreatedAt = Carbon::parse('2023-01-01T11:00:00Z');
        $lockExpiresAt = Carbon::parse('2023-01-01T13:00:00Z');
        $name = new UsersName('John', 'Doe');
        $password = new UserPassword('pwd_123', true);

        $user = new User(
            'user_123',
            [new UsersEmail('test@example.com', 'email_123', true)],
            'active',
            [new UsersPhoneNumber('+1234567890', 'phone_123', true)],
            [new WebAuthnRegistration('webauthn_123', 'example.com', 'Mozilla/5.0', true, 'platform', 'Test Device')],
            [new OAuthProvider('google', 'google_123', 'oauth_123', 'https://example.com/avatar.jpg', 'en')],
            [new TOTP('totp_123', true)],
            [new CryptoWallet('wallet_123', '0x123', 'ethereum', true)],
            [new BiometricRegistration('bio_123', true)],
            false,
            $name,
            $createdAt,
            $password,
            ['trusted' => 'data'],
            ['untrusted' => 'data'],
            'ext_123',
            $lockCreatedAt,
            $lockExpiresAt
        );

        $array = $user->toArray();

        $this->assertEquals('user_123', $array['user_id']);
        $this->assertCount(1, $array['emails']);
        $this->assertEquals('active', $array['status']);
        $this->assertCount(1, $array['phone_numbers']);
        $this->assertCount(1, $array['webauthn_registrations']);
        $this->assertCount(1, $array['providers']);
        $this->assertCount(1, $array['totps']);
        $this->assertCount(1, $array['crypto_wallets']);
        $this->assertCount(1, $array['biometric_registrations']);
        $this->assertFalse($array['is_locked']);
        $this->assertEquals($name->toArray(), $array['name']);
        $this->assertEquals('2023-01-01T12:00:00.000000Z', $array['created_at']);
        $this->assertEquals($password->toArray(), $array['password']);
        $this->assertEquals(['trusted' => 'data'], $array['trusted_metadata']);
        $this->assertEquals(['untrusted' => 'data'], $array['untrusted_metadata']);
        $this->assertEquals('ext_123', $array['external_id']);
        $this->assertEquals('2023-01-01T11:00:00.000000Z', $array['lock_created_at']);
        $this->assertEquals('2023-01-01T13:00:00.000000Z', $array['lock_expires_at']);
    }

    public function testUserToArrayWithNullValues(): void
    {
        $user = new User(
            'user_123',
            [],
            'active',
            [],
            [],
            [],
            [],
            [],
            [],
            false,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $array = $user->toArray();

        $this->assertEquals('user_123', $array['user_id']);
        $this->assertEmpty($array['emails']);
        $this->assertEquals('active', $array['status']);
        $this->assertEmpty($array['phone_numbers']);
        $this->assertEmpty($array['webauthn_registrations']);
        $this->assertEmpty($array['providers']);
        $this->assertEmpty($array['totps']);
        $this->assertEmpty($array['crypto_wallets']);
        $this->assertEmpty($array['biometric_registrations']);
        $this->assertFalse($array['is_locked']);
        // Null values are not included in toArray() output
        $this->assertArrayNotHasKey('name', $array);
        $this->assertArrayNotHasKey('created_at', $array);
        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('trusted_metadata', $array);
        $this->assertArrayNotHasKey('untrusted_metadata', $array);
        $this->assertArrayNotHasKey('external_id', $array);
        $this->assertArrayNotHasKey('lock_created_at', $array);
        $this->assertArrayNotHasKey('lock_expires_at', $array);
    }
}
