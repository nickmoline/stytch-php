<?php

namespace Stytch\Objects;

class Member
{
    /**
     * @param array<SSORegistration> $sso_registrations
     * @param array<OAuthRegistration> $oauth_registrations
     * @param array<RetiredEmail> $retired_email_addresses
     * @param array<MemberRole> $roles
     * @param array<string, mixed>|null $trusted_metadata
     * @param array<string, mixed>|null $untrusted_metadata
     */
    public function __construct(
        public string $organization_id,
        public string $member_id,
        public string $email_address,
        public string $status,
        public string $name,
        public array $sso_registrations,
        public bool $is_breakglass,
        public string $member_password_id,
        public array $oauth_registrations,
        public bool $email_address_verified,
        public bool $mfa_phone_number_verified,
        public bool $is_admin,
        public string $totp_registration_id,
        public array $retired_email_addresses,
        public bool $is_locked,
        public bool $mfa_enrolled,
        public string $mfa_phone_number,
        public string $default_mfa_method,
        public array $roles,
        public ?array $trusted_metadata = null,
        public ?array $untrusted_metadata = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
        public ?SCIMRegistration $scim_registration = null,
        public ?string $external_id = null,
        public ?string $lock_created_at = null,
        public ?string $lock_expires_at = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            organization_id: $data['organization_id'],
            member_id: $data['member_id'],
            email_address: $data['email_address'],
            status: $data['status'],
            name: $data['name'],
            sso_registrations: array_map(fn($reg) => SSORegistration::fromArray($reg), $data['sso_registrations']),
            is_breakglass: $data['is_breakglass'],
            member_password_id: $data['member_password_id'],
            oauth_registrations: array_map(fn($reg) => OAuthRegistration::fromArray($reg), $data['oauth_registrations']),
            email_address_verified: $data['email_address_verified'],
            mfa_phone_number_verified: $data['mfa_phone_number_verified'],
            is_admin: $data['is_admin'],
            totp_registration_id: $data['totp_registration_id'],
            retired_email_addresses: array_map(fn($email) => RetiredEmail::fromArray($email), $data['retired_email_addresses']),
            is_locked: $data['is_locked'],
            mfa_enrolled: $data['mfa_enrolled'],
            mfa_phone_number: $data['mfa_phone_number'],
            default_mfa_method: $data['default_mfa_method'],
            roles: array_map(fn($role) => MemberRole::fromArray($role), $data['roles']),
            trusted_metadata: $data['trusted_metadata'] ?? null,
            untrusted_metadata: $data['untrusted_metadata'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
            scim_registration: isset($data['scim_registration']) ? SCIMRegistration::fromArray($data['scim_registration']) : null,
            external_id: $data['external_id'] ?? null,
            lock_created_at: $data['lock_created_at'] ?? null,
            lock_expires_at: $data['lock_expires_at'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'organization_id' => $this->organization_id,
            'member_id' => $this->member_id,
            'email_address' => $this->email_address,
            'status' => $this->status,
            'name' => $this->name,
            'sso_registrations' => array_map(fn($reg) => $reg->toArray(), $this->sso_registrations),
            'is_breakglass' => $this->is_breakglass,
            'member_password_id' => $this->member_password_id,
            'oauth_registrations' => array_map(fn($reg) => $reg->toArray(), $this->oauth_registrations),
            'email_address_verified' => $this->email_address_verified,
            'mfa_phone_number_verified' => $this->mfa_phone_number_verified,
            'is_admin' => $this->is_admin,
            'totp_registration_id' => $this->totp_registration_id,
            'retired_email_addresses' => array_map(fn($email) => $email->toArray(), $this->retired_email_addresses),
            'is_locked' => $this->is_locked,
            'mfa_enrolled' => $this->mfa_enrolled,
            'mfa_phone_number' => $this->mfa_phone_number,
            'default_mfa_method' => $this->default_mfa_method,
            'roles' => array_map(fn($role) => $role->toArray(), $this->roles),
            'trusted_metadata' => $this->trusted_metadata,
            'untrusted_metadata' => $this->untrusted_metadata,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'scim_registration' => $this->scim_registration?->toArray(),
            'external_id' => $this->external_id,
            'lock_created_at' => $this->lock_created_at,
            'lock_expires_at' => $this->lock_expires_at,
        ];
    }
}

class SSORegistration
{
    /**
     * @param array<string, mixed>|null $sso_attributes
     */
    public function __construct(
        public string $connection_id,
        public string $external_id,
        public string $registration_id,
        public ?array $sso_attributes = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            connection_id: $data['connection_id'],
            external_id: $data['external_id'],
            registration_id: $data['registration_id'],
            sso_attributes: $data['sso_attributes'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'connection_id' => $this->connection_id,
            'external_id' => $this->external_id,
            'registration_id' => $this->registration_id,
            'sso_attributes' => $this->sso_attributes,
        ];
    }
}

class OAuthRegistration
{
    public function __construct(
        public string $provider_type,
        public string $provider_subject,
        public string $member_oauth_registration_id,
        public ?string $profile_picture_url = null,
        public ?string $locale = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            provider_type: $data['provider_type'],
            provider_subject: $data['provider_subject'],
            member_oauth_registration_id: $data['member_oauth_registration_id'],
            profile_picture_url: $data['profile_picture_url'] ?? null,
            locale: $data['locale'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'provider_type' => $this->provider_type,
            'provider_subject' => $this->provider_subject,
            'member_oauth_registration_id' => $this->member_oauth_registration_id,
            'profile_picture_url' => $this->profile_picture_url,
            'locale' => $this->locale,
        ];
    }
}

class RetiredEmail
{
    public function __construct(
        public string $email_id,
        public string $email_address,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email_id: $data['email_id'],
            email_address: $data['email_address'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'email_id' => $this->email_id,
            'email_address' => $this->email_address,
        ];
    }
}

class MemberRole
{
    /**
     * @param array<MemberRoleSource> $sources
     */
    public function __construct(
        public string $role_id,
        public array $sources,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            role_id: $data['role_id'],
            sources: array_map(fn($source) => MemberRoleSource::fromArray($source), $data['sources']),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'role_id' => $this->role_id,
            'sources' => array_map(fn($source) => $source->toArray(), $this->sources),
        ];
    }
}

class MemberRoleSource
{
    /**
     * @param array<string, mixed>|null $details
     */
    public function __construct(
        public string $type,
        public ?array $details = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            details: $data['details'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'details' => $this->details,
        ];
    }
}

class SCIMRegistration
{
    /**
     * @param array<string, mixed>|null $scim_attributes
     */
    public function __construct(
        public string $connection_id,
        public string $registration_id,
        public ?string $external_id = null,
        public ?array $scim_attributes = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            connection_id: $data['connection_id'],
            registration_id: $data['registration_id'],
            external_id: $data['external_id'] ?? null,
            scim_attributes: $data['scim_attributes'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'connection_id' => $this->connection_id,
            'registration_id' => $this->registration_id,
            'external_id' => $this->external_id,
            'scim_attributes' => $this->scim_attributes,
        ];
    }
}
