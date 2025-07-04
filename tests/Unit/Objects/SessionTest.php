<?php

namespace Stytch\Tests\Unit\Objects;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Stytch\Objects\Session;
use Stytch\Objects\AuthenticationFactor;
use Stytch\Objects\AuthorizationCheck;
use Stytch\Objects\AuthorizationVerdict;
use Stytch\Objects\PrimaryRequired;

class SessionTest extends TestCase
{
    public function testSessionConstructor(): void
    {
        $startedAt = Carbon::parse('2023-01-01T12:00:00Z');
        $lastAccessedAt = Carbon::parse('2023-01-01T13:00:00Z');
        $expiresAt = Carbon::parse('2023-01-02T12:00:00Z');
        $authenticationFactors = [];
        $roles = ['admin', 'user'];

        $session = new Session(
            'session_123',
            'member_456',
            $startedAt,
            $lastAccessedAt,
            $expiresAt,
            $authenticationFactors,
            'org_789',
            $roles,
            ['custom' => 'data']
        );

        $this->assertEquals('session_123', $session->member_session_id);
        $this->assertEquals('member_456', $session->member_id);
        $this->assertSame($startedAt, $session->started_at);
        $this->assertSame($lastAccessedAt, $session->last_accessed_at);
        $this->assertSame($expiresAt, $session->expires_at);
        $this->assertEquals($authenticationFactors, $session->authentication_factors);
        $this->assertEquals('org_789', $session->organization_id);
        $this->assertEquals($roles, $session->roles);
        $this->assertEquals(['custom' => 'data'], $session->custom_claims);
    }

    public function testSessionFromArray(): void
    {
        $data = [
            'member_session_id' => 'session_123',
            'member_id' => 'member_456',
            'started_at' => '2023-01-01T12:00:00Z',
            'last_accessed_at' => '2023-01-01T13:00:00Z',
            'expires_at' => '2023-01-02T12:00:00Z',
            'authentication_factors' => [],
            'organization_id' => 'org_789',
            'roles' => ['admin'],
            'custom_claims' => ['custom' => 'data']
        ];

        $session = Session::fromArray($data);

        $this->assertEquals('session_123', $session->member_session_id);
        $this->assertEquals('member_456', $session->member_id);
        $this->assertEquals('org_789', $session->organization_id);
        $this->assertEquals(['admin'], $session->roles);
        $this->assertEquals(['custom' => 'data'], $session->custom_claims);
    }

    public function testSessionToArray(): void
    {
        $startedAt = Carbon::parse('2023-01-01T12:00:00Z');
        $lastAccessedAt = Carbon::parse('2023-01-01T13:00:00Z');
        $expiresAt = Carbon::parse('2023-01-02T12:00:00Z');

        $session = new Session(
            'session_123',
            'member_456',
            $startedAt,
            $lastAccessedAt,
            $expiresAt,
            [],
            'org_789',
            ['admin'],
            ['custom' => 'data']
        );

        $array = $session->toArray();

        $this->assertEquals('session_123', $array['member_session_id']);
        $this->assertEquals('member_456', $array['member_id']);
        $this->assertEquals('2023-01-01T12:00:00.000000Z', $array['started_at']);
        $this->assertEquals('2023-01-01T13:00:00.000000Z', $array['last_accessed_at']);
        $this->assertEquals('2023-01-02T12:00:00.000000Z', $array['expires_at']);
        $this->assertEquals('org_789', $array['organization_id']);
        $this->assertEquals(['admin'], $array['roles']);
        $this->assertEquals(['custom' => 'data'], $array['custom_claims']);
    }

    public function testAuthenticationFactorConstructor(): void
    {
        $lastAuthenticatedAt = Carbon::parse('2023-01-01T12:00:00Z');
        $createdAt = Carbon::parse('2023-01-01T10:00:00Z');
        $updatedAt = Carbon::parse('2023-01-01T12:00:00Z');

        $factor = new AuthenticationFactor(
            'totp',
            'sms',
            $lastAuthenticatedAt,
            $createdAt,
            $updatedAt,
            ['email' => 'test@example.com'],
            ['phone' => '+1234567890'],
            ['provider' => 'google'],
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $this->assertEquals('totp', $factor->type);
        $this->assertEquals('sms', $factor->delivery_method);
        $this->assertSame($lastAuthenticatedAt, $factor->last_authenticated_at);
        $this->assertSame($createdAt, $factor->created_at);
        $this->assertSame($updatedAt, $factor->updated_at);
        $this->assertEquals(['email' => 'test@example.com'], $factor->email_factor);
        $this->assertEquals(['phone' => '+1234567890'], $factor->phone_factor);
        $this->assertEquals(['provider' => 'google'], $factor->google_oauth_factor);
        $this->assertNull($factor->microsoft_oauth_factor);
        $this->assertNull($factor->apple_oauth_factor);
        $this->assertNull($factor->webauthn_factor);
        $this->assertNull($factor->totp_factor);
        $this->assertNull($factor->backup_code_factor);
        $this->assertNull($factor->crypto_wallet_factor);
        $this->assertNull($factor->password_factor);
        $this->assertNull($factor->sso_factor);
        $this->assertNull($factor->email_otp_factor);
        $this->assertNull($factor->sms_otp_factor);
        $this->assertNull($factor->whatsapp_otp_factor);
        $this->assertNull($factor->slack_oauth_factor);
        $this->assertNull($factor->github_oauth_factor);
        $this->assertNull($factor->hubspot_oauth_factor);
        $this->assertNull($factor->saml_sso_factor);
        $this->assertNull($factor->oidc_sso_factor);
        $this->assertNull($factor->organization_factor);
    }

    public function testAuthenticationFactorFromArray(): void
    {
        $data = [
            'type' => 'totp',
            'delivery_method' => 'sms',
            'last_authenticated_at' => '2023-01-01T12:00:00Z',
            'created_at' => '2023-01-01T10:00:00Z',
            'updated_at' => '2023-01-01T12:00:00Z',
            'email_factor' => ['email' => 'test@example.com'],
            'phone_factor' => ['phone' => '+1234567890'],
            'google_oauth_factor' => ['provider' => 'google'],
            'microsoft_oauth_factor' => null,
            'apple_oauth_factor' => null,
            'webauthn_factor' => null,
            'totp_factor' => null,
            'backup_code_factor' => null,
            'crypto_wallet_factor' => null,
            'password_factor' => null,
            'sso_factor' => null,
            'email_otp_factor' => null,
            'sms_otp_factor' => null,
            'whatsapp_otp_factor' => null,
            'slack_oauth_factor' => null,
            'github_oauth_factor' => null,
            'hubspot_oauth_factor' => null,
            'saml_sso_factor' => null,
            'oidc_sso_factor' => null,
            'organization_factor' => null
        ];

        $factor = AuthenticationFactor::fromArray($data);

        $this->assertEquals('totp', $factor->type);
        $this->assertEquals('sms', $factor->delivery_method);
        $this->assertInstanceOf(Carbon::class, $factor->last_authenticated_at);
        $this->assertInstanceOf(Carbon::class, $factor->created_at);
        $this->assertInstanceOf(Carbon::class, $factor->updated_at);
        $this->assertEquals(['email' => 'test@example.com'], $factor->email_factor);
        $this->assertEquals(['phone' => '+1234567890'], $factor->phone_factor);
        $this->assertEquals(['provider' => 'google'], $factor->google_oauth_factor);
        $this->assertNull($factor->microsoft_oauth_factor);
        $this->assertNull($factor->apple_oauth_factor);
        $this->assertNull($factor->webauthn_factor);
        $this->assertNull($factor->totp_factor);
        $this->assertNull($factor->backup_code_factor);
        $this->assertNull($factor->crypto_wallet_factor);
        $this->assertNull($factor->password_factor);
        $this->assertNull($factor->sso_factor);
        $this->assertNull($factor->email_otp_factor);
        $this->assertNull($factor->sms_otp_factor);
        $this->assertNull($factor->whatsapp_otp_factor);
        $this->assertNull($factor->slack_oauth_factor);
        $this->assertNull($factor->github_oauth_factor);
        $this->assertNull($factor->hubspot_oauth_factor);
        $this->assertNull($factor->saml_sso_factor);
        $this->assertNull($factor->oidc_sso_factor);
        $this->assertNull($factor->organization_factor);
    }

    public function testAuthenticationFactorFromArrayWithNullDates(): void
    {
        $data = [
            'type' => 'totp',
            'delivery_method' => 'sms',
            'last_authenticated_at' => null,
            'created_at' => null,
            'updated_at' => null,
            'email_factor' => null,
            'phone_factor' => null,
            'google_oauth_factor' => null,
            'microsoft_oauth_factor' => null,
            'apple_oauth_factor' => null,
            'webauthn_factor' => null,
            'totp_factor' => null,
            'backup_code_factor' => null,
            'crypto_wallet_factor' => null,
            'password_factor' => null,
            'sso_factor' => null,
            'email_otp_factor' => null,
            'sms_otp_factor' => null,
            'whatsapp_otp_factor' => null,
            'slack_oauth_factor' => null,
            'github_oauth_factor' => null,
            'hubspot_oauth_factor' => null,
            'saml_sso_factor' => null,
            'oidc_sso_factor' => null,
            'organization_factor' => null
        ];

        $factor = AuthenticationFactor::fromArray($data);

        $this->assertEquals('totp', $factor->type);
        $this->assertEquals('sms', $factor->delivery_method);
        $this->assertNull($factor->last_authenticated_at);
        $this->assertNull($factor->created_at);
        $this->assertNull($factor->updated_at);
        $this->assertNull($factor->email_factor);
        $this->assertNull($factor->phone_factor);
        $this->assertNull($factor->google_oauth_factor);
    }

    public function testAuthenticationFactorToArray(): void
    {
        $lastAuthenticatedAt = Carbon::parse('2023-01-01T12:00:00Z');
        $createdAt = Carbon::parse('2023-01-01T10:00:00Z');
        $updatedAt = Carbon::parse('2023-01-01T12:00:00Z');

        $factor = new AuthenticationFactor(
            'totp',
            'sms',
            $lastAuthenticatedAt,
            $createdAt,
            $updatedAt,
            ['email' => 'test@example.com'],
            ['phone' => '+1234567890'],
            ['provider' => 'google'],
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $array = $factor->toArray();

        $this->assertEquals('totp', $array['type']);
        $this->assertEquals('sms', $array['delivery_method']);
        $this->assertEquals('2023-01-01T12:00:00.000000Z', $array['last_authenticated_at']);
        $this->assertEquals('2023-01-01T10:00:00.000000Z', $array['created_at']);
        $this->assertEquals('2023-01-01T12:00:00.000000Z', $array['updated_at']);
        $this->assertEquals(['email' => 'test@example.com'], $array['email_factor']);
        $this->assertEquals(['phone' => '+1234567890'], $array['phone_factor']);
        $this->assertEquals(['provider' => 'google'], $array['google_oauth_factor']);
        $this->assertNull($array['microsoft_oauth_factor']);
        $this->assertNull($array['apple_oauth_factor']);
        $this->assertNull($array['webauthn_factor']);
        $this->assertNull($array['totp_factor']);
        $this->assertNull($array['backup_code_factor']);
        $this->assertNull($array['crypto_wallet_factor']);
        $this->assertNull($array['password_factor']);
        $this->assertNull($array['sso_factor']);
        $this->assertNull($array['email_otp_factor']);
        $this->assertNull($array['sms_otp_factor']);
        $this->assertNull($array['whatsapp_otp_factor']);
        $this->assertNull($array['slack_oauth_factor']);
        $this->assertNull($array['github_oauth_factor']);
        $this->assertNull($array['hubspot_oauth_factor']);
        $this->assertNull($array['saml_sso_factor']);
        $this->assertNull($array['oidc_sso_factor']);
        $this->assertNull($array['organization_factor']);
    }

    public function testAuthenticationFactorToArrayWithNullDates(): void
    {
        $factor = new AuthenticationFactor(
            'totp',
            'sms',
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $array = $factor->toArray();

        $this->assertEquals('totp', $array['type']);
        $this->assertEquals('sms', $array['delivery_method']);
        $this->assertNull($array['last_authenticated_at']);
        $this->assertNull($array['created_at']);
        $this->assertNull($array['updated_at']);
        $this->assertNull($array['email_factor']);
        $this->assertNull($array['phone_factor']);
        $this->assertNull($array['google_oauth_factor']);
    }

    public function testAuthorizationCheck(): void
    {
        $check = new AuthorizationCheck(
            'org_123',
            'resource_456',
            'read'
        );

        $this->assertEquals('org_123', $check->organization_id);
        $this->assertEquals('resource_456', $check->resource_id);
        $this->assertEquals('read', $check->action);
    }

    public function testAuthorizationVerdict(): void
    {
        $verdict = new AuthorizationVerdict(
            true,
            ['admin', 'user']
        );

        $this->assertTrue($verdict->authorized);
        $this->assertEquals(['admin', 'user'], $verdict->granting_roles);
    }

    public function testPrimaryRequired(): void
    {
        $primary = new PrimaryRequired(
            ['password', 'totp']
        );

        $this->assertEquals(['password', 'totp'], $primary->allowed_auth_methods);
    }
}
