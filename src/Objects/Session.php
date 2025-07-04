<?php

namespace Stytch\Objects;

use Carbon\Carbon;
use Stytch\Objects\Traits\HasCarbonDates;

class Session
{
    use HasCarbonDates;

    /**
     * @param array<AuthenticationFactor> $authentication_factors
     * @param array<string> $roles
     * @param array<string, mixed>|null $custom_claims
     */
    public function __construct(
        public string $member_session_id,
        public string $member_id,
        public Carbon $started_at,
        public Carbon $last_accessed_at,
        public Carbon $expires_at,
        public array $authentication_factors,
        public string $organization_id,
        public array $roles,
        public ?array $custom_claims = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            member_session_id: $data['member_session_id'],
            member_id: $data['member_id'],
            started_at: Carbon::parse($data['started_at']),
            last_accessed_at: Carbon::parse($data['last_accessed_at']),
            expires_at: Carbon::parse($data['expires_at']),
            authentication_factors: array_map(fn($factor) => AuthenticationFactor::fromArray($factor), $data['authentication_factors']),
            organization_id: $data['organization_id'],
            roles: $data['roles'],
            custom_claims: $data['custom_claims'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'member_session_id' => $this->member_session_id,
            'member_id' => $this->member_id,
            'started_at' => $this->started_at->toISOString(),
            'last_accessed_at' => $this->last_accessed_at->toISOString(),
            'expires_at' => $this->expires_at->toISOString(),
            'authentication_factors' => array_map(fn($factor) => $factor->toArray(), $this->authentication_factors),
            'organization_id' => $this->organization_id,
            'roles' => $this->roles,
            'custom_claims' => $this->custom_claims,
        ];
    }
}

class AuthenticationFactor
{
    use HasCarbonDates;

    /**
     * @param array<string, mixed>|null $email_factor
     * @param array<string, mixed>|null $phone_factor
     * @param array<string, mixed>|null $google_oauth_factor
     * @param array<string, mixed>|null $microsoft_oauth_factor
     * @param array<string, mixed>|null $apple_oauth_factor
     * @param array<string, mixed>|null $webauthn_factor
     * @param array<string, mixed>|null $totp_factor
     * @param array<string, mixed>|null $backup_code_factor
     * @param array<string, mixed>|null $crypto_wallet_factor
     * @param array<string, mixed>|null $password_factor
     * @param array<string, mixed>|null $sso_factor
     * @param array<string, mixed>|null $email_otp_factor
     * @param array<string, mixed>|null $sms_otp_factor
     * @param array<string, mixed>|null $whatsapp_otp_factor
     * @param array<string, mixed>|null $slack_oauth_factor
     * @param array<string, mixed>|null $github_oauth_factor
     * @param array<string, mixed>|null $hubspot_oauth_factor
     * @param array<string, mixed>|null $saml_sso_factor
     * @param array<string, mixed>|null $oidc_sso_factor
     * @param array<string, mixed>|null $organization_factor
     */
    public function __construct(
        public string $type,
        public ?string $delivery_method = null,
        public ?Carbon $last_authenticated_at = null,
        public ?Carbon $created_at = null,
        public ?Carbon $updated_at = null,
        public ?array $email_factor = null,
        public ?array $phone_factor = null,
        public ?array $google_oauth_factor = null,
        public ?array $microsoft_oauth_factor = null,
        public ?array $apple_oauth_factor = null,
        public ?array $webauthn_factor = null,
        public ?array $totp_factor = null,
        public ?array $backup_code_factor = null,
        public ?array $crypto_wallet_factor = null,
        public ?array $password_factor = null,
        public ?array $sso_factor = null,
        public ?array $email_otp_factor = null,
        public ?array $sms_otp_factor = null,
        public ?array $whatsapp_otp_factor = null,
        public ?array $slack_oauth_factor = null,
        public ?array $github_oauth_factor = null,
        public ?array $hubspot_oauth_factor = null,
        public ?array $saml_sso_factor = null,
        public ?array $oidc_sso_factor = null,
        public ?array $organization_factor = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            delivery_method: $data['delivery_method'] ?? null,
            last_authenticated_at: self::parseDate($data['last_authenticated_at'] ?? null),
            created_at: self::parseDate($data['created_at'] ?? null),
            updated_at: self::parseDate($data['updated_at'] ?? null),
            email_factor: $data['email_factor'] ?? null,
            phone_factor: $data['phone_factor'] ?? null,
            google_oauth_factor: $data['google_oauth_factor'] ?? null,
            microsoft_oauth_factor: $data['microsoft_oauth_factor'] ?? null,
            apple_oauth_factor: $data['apple_oauth_factor'] ?? null,
            webauthn_factor: $data['webauthn_factor'] ?? null,
            totp_factor: $data['totp_factor'] ?? null,
            backup_code_factor: $data['backup_code_factor'] ?? null,
            crypto_wallet_factor: $data['crypto_wallet_factor'] ?? null,
            password_factor: $data['password_factor'] ?? null,
            sso_factor: $data['sso_factor'] ?? null,
            email_otp_factor: $data['email_otp_factor'] ?? null,
            sms_otp_factor: $data['sms_otp_factor'] ?? null,
            whatsapp_otp_factor: $data['whatsapp_otp_factor'] ?? null,
            slack_oauth_factor: $data['slack_oauth_factor'] ?? null,
            github_oauth_factor: $data['github_oauth_factor'] ?? null,
            hubspot_oauth_factor: $data['hubspot_oauth_factor'] ?? null,
            saml_sso_factor: $data['saml_sso_factor'] ?? null,
            oidc_sso_factor: $data['oidc_sso_factor'] ?? null,
            organization_factor: $data['organization_factor'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'delivery_method' => $this->delivery_method,
            'last_authenticated_at' => self::toDateString($this->last_authenticated_at),
            'created_at' => self::toDateString($this->created_at),
            'updated_at' => self::toDateString($this->updated_at),
            'email_factor' => $this->email_factor,
            'phone_factor' => $this->phone_factor,
            'google_oauth_factor' => $this->google_oauth_factor,
            'microsoft_oauth_factor' => $this->microsoft_oauth_factor,
            'apple_oauth_factor' => $this->apple_oauth_factor,
            'webauthn_factor' => $this->webauthn_factor,
            'totp_factor' => $this->totp_factor,
            'backup_code_factor' => $this->backup_code_factor,
            'crypto_wallet_factor' => $this->crypto_wallet_factor,
            'password_factor' => $this->password_factor,
            'sso_factor' => $this->sso_factor,
            'email_otp_factor' => $this->email_otp_factor,
            'sms_otp_factor' => $this->sms_otp_factor,
            'whatsapp_otp_factor' => $this->whatsapp_otp_factor,
            'slack_oauth_factor' => $this->slack_oauth_factor,
            'github_oauth_factor' => $this->github_oauth_factor,
            'hubspot_oauth_factor' => $this->hubspot_oauth_factor,
            'saml_sso_factor' => $this->saml_sso_factor,
            'oidc_sso_factor' => $this->oidc_sso_factor,
            'organization_factor' => $this->organization_factor,
        ];
    }
}

class AuthorizationCheck
{
    public function __construct(
        public string $organization_id,
        public string $resource_id,
        public string $action,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            organization_id: $data['organization_id'],
            resource_id: $data['resource_id'],
            action: $data['action'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'organization_id' => $this->organization_id,
            'resource_id' => $this->resource_id,
            'action' => $this->action,
        ];
    }
}

class AuthorizationVerdict
{
    /**
     * @param array<string> $granting_roles
     */
    public function __construct(
        public bool $authorized,
        public array $granting_roles,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            authorized: $data['authorized'],
            granting_roles: $data['granting_roles'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'authorized' => $this->authorized,
            'granting_roles' => $this->granting_roles,
        ];
    }
}

class PrimaryRequired
{
    /**
     * @param array<string> $allowed_auth_methods
     */
    public function __construct(
        public array $allowed_auth_methods,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            allowed_auth_methods: $data['allowed_auth_methods'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'allowed_auth_methods' => $this->allowed_auth_methods,
        ];
    }
}
