<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class Users
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function create(array $data): array
    {
        return $this->client->post('/v1/users', $data);
    }

    /**
     * @param string $user_id
     * @return array<string, mixed>
     */
    public function get(string $user_id): array
    {
        return $this->client->get("/v1/users/{$user_id}");
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function search(array $data): array
    {
        return $this->client->post('/v1/users/search', $data);
    }

    /**
     * @param string $user_id
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function update(string $user_id, array $data): array
    {
        return $this->client->put("/v1/users/{$user_id}", $data);
    }

    /**
     * @param string $user_id
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function exchangePrimaryFactor(string $user_id, array $data): array
    {
        return $this->client->put("/v1/users/{$user_id}/exchange_primary_factor", $data);
    }

    /**
     * @param string $user_id
     * @return array<string, mixed>
     */
    public function delete(string $user_id): array
    {
        return $this->client->delete("/v1/users/{$user_id}");
    }

    /**
     * @param string $email_id
     * @return array<string, mixed>
     */
    public function deleteEmail(string $email_id): array
    {
        return $this->client->delete("/v1/users/emails/{$email_id}");
    }

    /**
     * @param string $phone_id
     * @return array<string, mixed>
     */
    public function deletePhoneNumber(string $phone_id): array
    {
        return $this->client->delete("/v1/users/phone_numbers/{$phone_id}");
    }

    /**
     * @param string $webauthn_registration_id
     * @return array<string, mixed>
     */
    public function deleteWebAuthnRegistration(string $webauthn_registration_id): array
    {
        return $this->client->delete("/v1/users/webauthn_registrations/{$webauthn_registration_id}");
    }

    /**
     * @param string $biometric_registration_id
     * @return array<string, mixed>
     */
    public function deleteBiometricRegistration(string $biometric_registration_id): array
    {
        return $this->client->delete("/v1/users/biometric_registrations/{$biometric_registration_id}");
    }

    /**
     * @param string $totp_id
     * @return array<string, mixed>
     */
    public function deleteTOTP(string $totp_id): array
    {
        return $this->client->delete("/v1/users/totps/{$totp_id}");
    }

    /**
     * @param string $crypto_wallet_id
     * @return array<string, mixed>
     */
    public function deleteCryptoWallet(string $crypto_wallet_id): array
    {
        return $this->client->delete("/v1/users/crypto_wallets/{$crypto_wallet_id}");
    }

    /**
     * @param string $password_id
     * @return array<string, mixed>
     */
    public function deletePassword(string $password_id): array
    {
        return $this->client->delete("/v1/users/passwords/{$password_id}");
    }

    /**
     * @param string $oauth_user_registration_id
     * @return array<string, mixed>
     */
    public function deleteOAuthRegistration(string $oauth_user_registration_id): array
    {
        return $this->client->delete("/v1/users/oauth_registrations/{$oauth_user_registration_id}");
    }

    /**
     * @param string $user_id
     * @return array<string, mixed>
     */
    public function connectedApps(string $user_id): array
    {
        return $this->client->get("/v1/users/{$user_id}/connected_apps");
    }

    /**
     * @param string $user_id
     * @param string $connected_app_id
     * @return array<string, mixed>
     */
    public function revoke(string $user_id, string $connected_app_id): array
    {
        return $this->client->post("/v1/users/{$user_id}/connected_apps/{$connected_app_id}/revoke");
    }
}
