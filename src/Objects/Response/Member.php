<?php

namespace Stytch\Objects\Response;

class Member
{
    public string $member_id;
    public string $email_address;
    public ?string $name;
    /** @var array<string, mixed>|null */
    public ?array $trusted_metadata;
    /** @var array<string, mixed>|null */
    public ?array $untrusted_metadata;
    public string $status;
    public ?string $mfa_phone_number;
    public bool $mfa_enrolled;
    /** @var array<string> */
    public array $roles;
    public ?string $external_id;
    public bool $is_breakglass;
    public ?string $default_mfa_method;
    /** @var array<string, mixed> */
    public array $emails;
    /** @var array<string, mixed> */
    public array $phone_numbers;
    /** @var array<string, mixed> */
    public array $totps;
    /** @var array<string, mixed> */
    public array $passwords;
    /** @var array<string, mixed> */
    public array $oauth_providers;
    /** @var array<string, mixed> */
    public array $connected_apps;
    public string $created_at;
    public string $updated_at;

    /**
     * @param array<string> $roles
     * @param array<string, mixed> $emails
     * @param array<string, mixed> $phone_numbers
     * @param array<string, mixed> $totps
     * @param array<string, mixed> $passwords
     * @param array<string, mixed> $oauth_providers
     * @param array<string, mixed> $connected_apps
     * @param array<string, mixed>|null $trusted_metadata
     * @param array<string, mixed>|null $untrusted_metadata
     */
    public function __construct(
        string $member_id,
        string $email_address,
        ?string $name,
        ?array $trusted_metadata,
        ?array $untrusted_metadata,
        string $status,
        ?string $mfa_phone_number,
        bool $mfa_enrolled,
        array $roles,
        ?string $external_id,
        bool $is_breakglass,
        ?string $default_mfa_method,
        array $emails,
        array $phone_numbers,
        array $totps,
        array $passwords,
        array $oauth_providers,
        array $connected_apps,
        string $created_at,
        string $updated_at,
    ) {
        $this->member_id = $member_id;
        $this->email_address = $email_address;
        $this->name = $name;
        $this->trusted_metadata = $trusted_metadata;
        $this->untrusted_metadata = $untrusted_metadata;
        $this->status = $status;
        $this->mfa_phone_number = $mfa_phone_number;
        $this->mfa_enrolled = $mfa_enrolled;
        $this->roles = $roles;
        $this->external_id = $external_id;
        $this->is_breakglass = $is_breakglass;
        $this->default_mfa_method = $default_mfa_method;
        $this->emails = $emails;
        $this->phone_numbers = $phone_numbers;
        $this->totps = $totps;
        $this->passwords = $passwords;
        $this->oauth_providers = $oauth_providers;
        $this->connected_apps = $connected_apps;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['member_id'],
            $data['email_address'],
            $data['name'] ?? null,
            $data['trusted_metadata'] ?? null,
            $data['untrusted_metadata'] ?? null,
            $data['status'],
            $data['mfa_phone_number'] ?? null,
            $data['mfa_enrolled'],
            $data['roles'],
            $data['external_id'] ?? null,
            $data['is_breakglass'],
            $data['default_mfa_method'] ?? null,
            $data['emails'],
            $data['phone_numbers'],
            $data['totps'],
            $data['passwords'],
            $data['oauth_providers'],
            $data['connected_apps'],
            $data['created_at'],
            $data['updated_at'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = [
            'member_id' => $this->member_id,
            'email_address' => $this->email_address,
            'status' => $this->status,
            'mfa_enrolled' => $this->mfa_enrolled,
            'roles' => $this->roles,
            'is_breakglass' => $this->is_breakglass,
            'emails' => $this->emails,
            'phone_numbers' => $this->phone_numbers,
            'totps' => $this->totps,
            'passwords' => $this->passwords,
            'oauth_providers' => $this->oauth_providers,
            'connected_apps' => $this->connected_apps,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($this->name !== null) {
            $array['name'] = $this->name;
        }
        if ($this->trusted_metadata !== null) {
            $array['trusted_metadata'] = $this->trusted_metadata;
        }
        if ($this->untrusted_metadata !== null) {
            $array['untrusted_metadata'] = $this->untrusted_metadata;
        }
        if ($this->mfa_phone_number !== null) {
            $array['mfa_phone_number'] = $this->mfa_phone_number;
        }
        if ($this->external_id !== null) {
            $array['external_id'] = $this->external_id;
        }
        if ($this->default_mfa_method !== null) {
            $array['default_mfa_method'] = $this->default_mfa_method;
        }

        return $array;
    }
}
