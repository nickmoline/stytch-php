<?php

namespace Stytch\Tests\Unit\Objects;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Stytch\Objects\BiometricRegistration;
use Stytch\Objects\CryptoWallet;
use Stytch\Objects\OAuthProvider;
use Stytch\Objects\TOTP;
use Stytch\Objects\UserPassword;
use Stytch\Objects\UsersEmail;
use Stytch\Objects\UsersName;
use Stytch\Objects\UsersPhoneNumber;
use Stytch\Objects\WebAuthnRegistration;

class SimpleObjectsTest extends TestCase
{
    public function testBiometricRegistrationConstructor(): void
    {
        $registration = new BiometricRegistration('bio_123', true);

        $this->assertEquals('bio_123', $registration->biometric_registration_id);
        $this->assertTrue($registration->verified);
    }

    public function testBiometricRegistrationFromArray(): void
    {
        $data = [
            'biometric_registration_id' => 'bio_123',
            'verified' => true
        ];

        $registration = BiometricRegistration::fromArray($data);

        $this->assertEquals('bio_123', $registration->biometric_registration_id);
        $this->assertTrue($registration->verified);
    }

    public function testBiometricRegistrationToArray(): void
    {
        $registration = new BiometricRegistration('bio_123', true);

        $array = $registration->toArray();

        $this->assertEquals('bio_123', $array['biometric_registration_id']);
        $this->assertTrue($array['verified']);
    }

    public function testCryptoWalletConstructor(): void
    {
        $wallet = new CryptoWallet('wallet_123', '0x123', 'ethereum', true);

        $this->assertEquals('wallet_123', $wallet->crypto_wallet_id);
        $this->assertEquals('0x123', $wallet->crypto_wallet_address);
        $this->assertEquals('ethereum', $wallet->crypto_wallet_type);
        $this->assertTrue($wallet->verified);
    }

    public function testCryptoWalletFromArray(): void
    {
        $data = [
            'crypto_wallet_id' => 'wallet_123',
            'crypto_wallet_address' => '0x123',
            'crypto_wallet_type' => 'ethereum',
            'verified' => true
        ];

        $wallet = CryptoWallet::fromArray($data);

        $this->assertEquals('wallet_123', $wallet->crypto_wallet_id);
        $this->assertEquals('0x123', $wallet->crypto_wallet_address);
        $this->assertEquals('ethereum', $wallet->crypto_wallet_type);
        $this->assertTrue($wallet->verified);
    }

    public function testCryptoWalletToArray(): void
    {
        $wallet = new CryptoWallet('wallet_123', '0x123', 'ethereum', true);

        $array = $wallet->toArray();

        $this->assertEquals('wallet_123', $array['crypto_wallet_id']);
        $this->assertEquals('0x123', $array['crypto_wallet_address']);
        $this->assertEquals('ethereum', $array['crypto_wallet_type']);
        $this->assertTrue($array['verified']);
    }

    public function testOAuthProviderConstructor(): void
    {
        $provider = new OAuthProvider('google', 'google_123', 'oauth_123', 'https://example.com/avatar.jpg', 'en');

        $this->assertEquals('google', $provider->provider_type);
        $this->assertEquals('google_123', $provider->provider_subject);
        $this->assertEquals('oauth_123', $provider->oauth_user_registration_id);
        $this->assertEquals('https://example.com/avatar.jpg', $provider->profile_picture_url);
        $this->assertEquals('en', $provider->locale);
    }

    public function testOAuthProviderFromArray(): void
    {
        $data = [
            'provider_type' => 'google',
            'provider_subject' => 'google_123',
            'oauth_user_registration_id' => 'oauth_123',
            'profile_picture_url' => 'https://example.com/avatar.jpg',
            'locale' => 'en'
        ];

        $provider = OAuthProvider::fromArray($data);

        $this->assertEquals('google', $provider->provider_type);
        $this->assertEquals('google_123', $provider->provider_subject);
        $this->assertEquals('oauth_123', $provider->oauth_user_registration_id);
        $this->assertEquals('https://example.com/avatar.jpg', $provider->profile_picture_url);
        $this->assertEquals('en', $provider->locale);
    }

    public function testOAuthProviderToArray(): void
    {
        $provider = new OAuthProvider('google', 'google_123', 'oauth_123', 'https://example.com/avatar.jpg', 'en');

        $array = $provider->toArray();

        $this->assertEquals('google', $array['provider_type']);
        $this->assertEquals('google_123', $array['provider_subject']);
        $this->assertEquals('oauth_123', $array['oauth_user_registration_id']);
        $this->assertEquals('https://example.com/avatar.jpg', $array['profile_picture_url']);
        $this->assertEquals('en', $array['locale']);
    }

    public function testTOTPConstructor(): void
    {
        $totp = new TOTP('totp_123', true);

        $this->assertEquals('totp_123', $totp->totp_id);
        $this->assertTrue($totp->verified);
    }

    public function testTOTPFromArray(): void
    {
        $data = [
            'totp_id' => 'totp_123',
            'verified' => true
        ];

        $totp = TOTP::fromArray($data);

        $this->assertEquals('totp_123', $totp->totp_id);
        $this->assertTrue($totp->verified);
    }

    public function testTOTPToArray(): void
    {
        $totp = new TOTP('totp_123', true);

        $array = $totp->toArray();

        $this->assertEquals('totp_123', $array['totp_id']);
        $this->assertTrue($array['verified']);
    }

    public function testUserPasswordConstructor(): void
    {
        $password = new UserPassword('pwd_123', true);

        $this->assertEquals('pwd_123', $password->password_id);
        $this->assertTrue($password->requires_reset);
    }

    public function testUserPasswordFromArray(): void
    {
        $data = [
            'password_id' => 'pwd_123',
            'requires_reset' => true
        ];

        $password = UserPassword::fromArray($data);

        $this->assertEquals('pwd_123', $password->password_id);
        $this->assertTrue($password->requires_reset);
    }

    public function testUserPasswordToArray(): void
    {
        $password = new UserPassword('pwd_123', true);

        $array = $password->toArray();

        $this->assertEquals('pwd_123', $array['password_id']);
        $this->assertTrue($array['requires_reset']);
    }

    public function testUsersEmailConstructor(): void
    {
        $email = new UsersEmail('email_123', 'test@example.com', true);

        $this->assertEquals('email_123', $email->email_id);
        $this->assertEquals('test@example.com', $email->email);
        $this->assertTrue($email->verified);
    }

    public function testUsersEmailFromArray(): void
    {
        $data = [
            'email_id' => 'email_123',
            'email' => 'test@example.com',
            'verified' => true
        ];

        $email = UsersEmail::fromArray($data);

        $this->assertEquals('email_123', $email->email_id);
        $this->assertEquals('test@example.com', $email->email);
        $this->assertTrue($email->verified);
    }

    public function testUsersEmailToArray(): void
    {
        $email = new UsersEmail('email_123', 'test@example.com', true);

        $array = $email->toArray();

        $this->assertEquals('email_123', $array['email_id']);
        $this->assertEquals('test@example.com', $array['email']);
        $this->assertTrue($array['verified']);
    }

    public function testUsersNameConstructor(): void
    {
        $name = new UsersName('John', null, 'Doe');

        $this->assertEquals('John', $name->first_name);
        $this->assertNull($name->middle_name);
        $this->assertEquals('Doe', $name->last_name);
    }

    public function testUsersNameFromArray(): void
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe'
        ];

        $name = UsersName::fromArray($data);

        $this->assertEquals('John', $name->first_name);
        $this->assertNull($name->middle_name);
        $this->assertEquals('Doe', $name->last_name);
    }

    public function testUsersNameToArray(): void
    {
        $name = new UsersName('John', null, 'Doe');

        $array = $name->toArray();

        $this->assertEquals('John', $array['first_name']);
        $this->assertEquals('Doe', $array['last_name']);
        $this->assertArrayNotHasKey('middle_name', $array);
    }

    public function testUsersNameWithMiddleName(): void
    {
        $name = new UsersName('John', 'Michael', 'Doe');

        $this->assertEquals('John', $name->first_name);
        $this->assertEquals('Michael', $name->middle_name);
        $this->assertEquals('Doe', $name->last_name);

        $array = $name->toArray();

        $this->assertEquals('John', $array['first_name']);
        $this->assertEquals('Michael', $array['middle_name']);
        $this->assertEquals('Doe', $array['last_name']);
    }

    public function testUsersPhoneNumberConstructor(): void
    {
        $phone = new UsersPhoneNumber('phone_123', '+1234567890', true);

        $this->assertEquals('phone_123', $phone->phone_id);
        $this->assertEquals('+1234567890', $phone->phone_number);
        $this->assertTrue($phone->verified);
    }

    public function testUsersPhoneNumberFromArray(): void
    {
        $data = [
            'phone_id' => 'phone_123',
            'phone_number' => '+1234567890',
            'verified' => true
        ];

        $phone = UsersPhoneNumber::fromArray($data);

        $this->assertEquals('phone_123', $phone->phone_id);
        $this->assertEquals('+1234567890', $phone->phone_number);
        $this->assertTrue($phone->verified);
    }

    public function testUsersPhoneNumberToArray(): void
    {
        $phone = new UsersPhoneNumber('phone_123', '+1234567890', true);

        $array = $phone->toArray();

        $this->assertEquals('phone_123', $array['phone_id']);
        $this->assertEquals('+1234567890', $array['phone_number']);
        $this->assertTrue($array['verified']);
    }

    public function testWebAuthnRegistrationConstructor(): void
    {
        $registration = new WebAuthnRegistration('webauthn_123', 'example.com', 'Mozilla/5.0', true, 'platform', 'Test Device');

        $this->assertEquals('webauthn_123', $registration->webauthn_registration_id);
        $this->assertEquals('example.com', $registration->domain);
        $this->assertEquals('Mozilla/5.0', $registration->user_agent);
        $this->assertTrue($registration->verified);
        $this->assertEquals('platform', $registration->authenticator_type);
        $this->assertEquals('Test Device', $registration->name);
    }

    public function testWebAuthnRegistrationFromArray(): void
    {
        $data = [
            'webauthn_registration_id' => 'webauthn_123',
            'domain' => 'example.com',
            'user_agent' => 'Mozilla/5.0',
            'verified' => true,
            'authenticator_type' => 'platform',
            'name' => 'Test Device'
        ];

        $registration = WebAuthnRegistration::fromArray($data);

        $this->assertEquals('webauthn_123', $registration->webauthn_registration_id);
        $this->assertEquals('example.com', $registration->domain);
        $this->assertEquals('Mozilla/5.0', $registration->user_agent);
        $this->assertTrue($registration->verified);
        $this->assertEquals('platform', $registration->authenticator_type);
        $this->assertEquals('Test Device', $registration->name);
    }

    public function testWebAuthnRegistrationToArray(): void
    {
        $registration = new WebAuthnRegistration('webauthn_123', 'example.com', 'Mozilla/5.0', true, 'platform', 'Test Device');

        $array = $registration->toArray();

        $this->assertEquals('webauthn_123', $array['webauthn_registration_id']);
        $this->assertEquals('example.com', $array['domain']);
        $this->assertEquals('Mozilla/5.0', $array['user_agent']);
        $this->assertTrue($array['verified']);
        $this->assertEquals('platform', $array['authenticator_type']);
        $this->assertEquals('Test Device', $array['name']);
    }
}
