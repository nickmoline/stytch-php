<?php

namespace Stytch\Objects;

class Organization
{
    /**
     * @param array<string> $sso_jit_provisioning_allowed_connections
     * @param array<ActiveSSOConnection> $sso_active_connections
     * @param array<string> $email_allowed_domains
     * @param array<string> $allowed_auth_methods
     * @param array<EmailImplicitRoleAssignment> $rbac_email_implicit_role_assignments
     * @param array<string> $allowed_mfa_methods
     * @param array<string> $claimed_email_domains
     * @param array<string> $allowed_first_party_connected_apps
     * @param array<string> $allowed_third_party_connected_apps
     * @param array<string, mixed>|null $trusted_metadata
     * @param array<string>|null $allowed_oauth_tenants
     */
    public function __construct(
        public string $organization_id,
        public string $organization_name,
        public string $organization_logo_url,
        public string $organization_slug,
        public string $sso_jit_provisioning,
        public array $sso_jit_provisioning_allowed_connections,
        public array $sso_active_connections,
        public array $email_allowed_domains,
        public string $email_jit_provisioning,
        public string $email_invites,
        public string $auth_methods,
        public array $allowed_auth_methods,
        public string $mfa_policy,
        public array $rbac_email_implicit_role_assignments,
        public string $mfa_methods,
        public array $allowed_mfa_methods,
        public string $oauth_tenant_jit_provisioning,
        public array $claimed_email_domains,
        public string $first_party_connected_apps_allowed_type,
        public array $allowed_first_party_connected_apps,
        public string $third_party_connected_apps_allowed_type,
        public array $allowed_third_party_connected_apps,
        public ?array $trusted_metadata = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
        public ?string $sso_default_connection_id = null,
        public ?ActiveSCIMConnection $scim_active_connection = null,
        public ?array $allowed_oauth_tenants = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            organization_id: $data['organization_id'],
            organization_name: $data['organization_name'],
            organization_logo_url: $data['organization_logo_url'],
            organization_slug: $data['organization_slug'],
            sso_jit_provisioning: $data['sso_jit_provisioning'],
            sso_jit_provisioning_allowed_connections: $data['sso_jit_provisioning_allowed_connections'],
            sso_active_connections: array_map(fn($conn) => ActiveSSOConnection::fromArray($conn), $data['sso_active_connections']),
            email_allowed_domains: $data['email_allowed_domains'],
            email_jit_provisioning: $data['email_jit_provisioning'],
            email_invites: $data['email_invites'],
            auth_methods: $data['auth_methods'],
            allowed_auth_methods: $data['allowed_auth_methods'],
            mfa_policy: $data['mfa_policy'],
            rbac_email_implicit_role_assignments: array_map(fn($role) => EmailImplicitRoleAssignment::fromArray($role), $data['rbac_email_implicit_role_assignments']),
            mfa_methods: $data['mfa_methods'],
            allowed_mfa_methods: $data['allowed_mfa_methods'],
            oauth_tenant_jit_provisioning: $data['oauth_tenant_jit_provisioning'],
            claimed_email_domains: $data['claimed_email_domains'],
            first_party_connected_apps_allowed_type: $data['first_party_connected_apps_allowed_type'],
            allowed_first_party_connected_apps: $data['allowed_first_party_connected_apps'],
            third_party_connected_apps_allowed_type: $data['third_party_connected_apps_allowed_type'],
            allowed_third_party_connected_apps: $data['allowed_third_party_connected_apps'],
            trusted_metadata: $data['trusted_metadata'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
            sso_default_connection_id: $data['sso_default_connection_id'] ?? null,
            scim_active_connection: isset($data['scim_active_connection']) ? ActiveSCIMConnection::fromArray($data['scim_active_connection']) : null,
            allowed_oauth_tenants: $data['allowed_oauth_tenants'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'organization_id' => $this->organization_id,
            'organization_name' => $this->organization_name,
            'organization_logo_url' => $this->organization_logo_url,
            'organization_slug' => $this->organization_slug,
            'sso_jit_provisioning' => $this->sso_jit_provisioning,
            'sso_jit_provisioning_allowed_connections' => $this->sso_jit_provisioning_allowed_connections,
            'sso_active_connections' => array_map(fn($conn) => $conn->toArray(), $this->sso_active_connections),
            'email_allowed_domains' => $this->email_allowed_domains,
            'email_jit_provisioning' => $this->email_jit_provisioning,
            'email_invites' => $this->email_invites,
            'auth_methods' => $this->auth_methods,
            'allowed_auth_methods' => $this->allowed_auth_methods,
            'mfa_policy' => $this->mfa_policy,
            'rbac_email_implicit_role_assignments' => array_map(fn($role) => $role->toArray(), $this->rbac_email_implicit_role_assignments),
            'mfa_methods' => $this->mfa_methods,
            'allowed_mfa_methods' => $this->allowed_mfa_methods,
            'oauth_tenant_jit_provisioning' => $this->oauth_tenant_jit_provisioning,
            'claimed_email_domains' => $this->claimed_email_domains,
            'first_party_connected_apps_allowed_type' => $this->first_party_connected_apps_allowed_type,
            'allowed_first_party_connected_apps' => $this->allowed_first_party_connected_apps,
            'third_party_connected_apps_allowed_type' => $this->third_party_connected_apps_allowed_type,
            'allowed_third_party_connected_apps' => $this->allowed_third_party_connected_apps,
            'trusted_metadata' => $this->trusted_metadata,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sso_default_connection_id' => $this->sso_default_connection_id,
            'scim_active_connection' => $this->scim_active_connection?->toArray(),
            'allowed_oauth_tenants' => $this->allowed_oauth_tenants,
        ];
    }
}

class ActiveSSOConnection
{
    public function __construct(
        public string $connection_id,
        public string $display_name,
        public string $identity_provider,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            connection_id: $data['connection_id'],
            display_name: $data['display_name'],
            identity_provider: $data['identity_provider'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'connection_id' => $this->connection_id,
            'display_name' => $this->display_name,
            'identity_provider' => $this->identity_provider,
        ];
    }
}

class ActiveSCIMConnection
{
    public function __construct(
        public string $connection_id,
        public string $display_name,
        public string $bearer_token_last_four,
        public ?string $bearer_token_expires_at = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            connection_id: $data['connection_id'],
            display_name: $data['display_name'],
            bearer_token_last_four: $data['bearer_token_last_four'],
            bearer_token_expires_at: $data['bearer_token_expires_at'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'connection_id' => $this->connection_id,
            'display_name' => $this->display_name,
            'bearer_token_last_four' => $this->bearer_token_last_four,
            'bearer_token_expires_at' => $this->bearer_token_expires_at,
        ];
    }
}

class EmailImplicitRoleAssignment
{
    public function __construct(
        public string $domain,
        public string $role_id,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            domain: $data['domain'],
            role_id: $data['role_id'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'domain' => $this->domain,
            'role_id' => $this->role_id,
        ];
    }
}
