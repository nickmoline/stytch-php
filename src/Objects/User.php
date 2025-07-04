<?php

namespace Stytch\Objects;

use Carbon\Carbon;

class User
{
    /**
     * @param array<UsersEmail> $emails
     * @param array<UsersPhoneNumber> $phone_numbers
     * @param array<WebAuthnRegistration> $webauthn_registrations
     * @param array<OAuthProvider> $providers
     * @param array<TOTP> $totps
     * @param array<CryptoWallet> $crypto_wallets
     * @param array<BiometricRegistration> $biometric_registrations
     * @param array<string, mixed>|null $trusted_metadata
     * @param array<string, mixed>|null $untrusted_metadata
     */
    public function __construct(
        public string $user_id,
        public array $emails,
        public string $status,
        public array $phone_numbers,
        public array $webauthn_registrations,
        public array $providers,
        public array $totps,
        public array $crypto_wallets,
        public array $biometric_registrations,
        public bool $is_locked,
        public ?UsersName $name = null,
        public ?Carbon $created_at = null,
        public ?UserPassword $password = null,
        public ?array $trusted_metadata = null,
        public ?array $untrusted_metadata = null,
        public ?string $external_id = null,
        public ?Carbon $lock_created_at = null,
        public ?Carbon $lock_expires_at = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            emails: array_map(fn($email) => UsersEmail::fromArray($email), $data['emails'] ?? []),
            status: $data['status'],
            phone_numbers: array_map(fn($phone) => UsersPhoneNumber::fromArray($phone), $data['phone_numbers'] ?? []),
            webauthn_registrations: array_map(fn($reg) => WebAuthnRegistration::fromArray($reg), $data['webauthn_registrations'] ?? []),
            providers: array_map(fn($provider) => OAuthProvider::fromArray($provider), $data['providers'] ?? []),
            totps: array_map(fn($totp) => TOTP::fromArray($totp), $data['totps'] ?? []),
            crypto_wallets: array_map(fn($wallet) => CryptoWallet::fromArray($wallet), $data['crypto_wallets'] ?? []),
            biometric_registrations: array_map(fn($reg) => BiometricRegistration::fromArray($reg), $data['biometric_registrations'] ?? []),
            is_locked: $data['is_locked'] ?? false,
            name: isset($data['name']) ? UsersName::fromArray($data['name']) : null,
            created_at: isset($data['created_at']) ? Carbon::parse($data['created_at']) : null,
            password: isset($data['password']) ? UserPassword::fromArray($data['password']) : null,
            trusted_metadata: $data['trusted_metadata'] ?? null,
            untrusted_metadata: $data['untrusted_metadata'] ?? null,
            external_id: $data['external_id'] ?? null,
            lock_created_at: isset($data['lock_created_at']) ? Carbon::parse($data['lock_created_at']) : null,
            lock_expires_at: isset($data['lock_expires_at']) ? Carbon::parse($data['lock_expires_at']) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'user_id' => $this->user_id,
            'emails' => array_map(fn($email) => $email->toArray(), $this->emails),
            'status' => $this->status,
            'phone_numbers' => array_map(fn($phone) => $phone->toArray(), $this->phone_numbers),
            'webauthn_registrations' => array_map(fn($reg) => $reg->toArray(), $this->webauthn_registrations),
            'providers' => array_map(fn($provider) => $provider->toArray(), $this->providers),
            'totps' => array_map(fn($totp) => $totp->toArray(), $this->totps),
            'crypto_wallets' => array_map(fn($wallet) => $wallet->toArray(), $this->crypto_wallets),
            'biometric_registrations' => array_map(fn($reg) => $reg->toArray(), $this->biometric_registrations),
            'is_locked' => $this->is_locked,
        ];

        if ($this->name) {
            $data['name'] = $this->name->toArray();
        }
        if ($this->created_at) {
            $data['created_at'] = $this->created_at->toISOString();
        }
        if ($this->password) {
            $data['password'] = $this->password->toArray();
        }
        if ($this->trusted_metadata) {
            $data['trusted_metadata'] = $this->trusted_metadata;
        }
        if ($this->untrusted_metadata) {
            $data['untrusted_metadata'] = $this->untrusted_metadata;
        }
        if ($this->external_id) {
            $data['external_id'] = $this->external_id;
        }
        if ($this->lock_created_at) {
            $data['lock_created_at'] = $this->lock_created_at->toISOString();
        }
        if ($this->lock_expires_at) {
            $data['lock_expires_at'] = $this->lock_expires_at->toISOString();
        }

        return $data;
    }
}
