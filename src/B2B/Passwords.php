<?php

namespace Stytch\B2B;

use Stytch\Objects\Response\PasswordResponse;
use Stytch\Objects\Response\PasswordStrengthResponse;
use Stytch\Shared\Client;

class Passwords
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Authenticate a member with their email address and password.
     *
     * This endpoint verifies that the member has a password currently set, and that the entered password is correct.
     *
     * @param array<string, mixed> $data
     * @return PasswordResponse
     */
    public function authenticate(array $data): PasswordResponse
    {
        $response = $this->client->post('/v1/b2b/passwords/authenticate', $data);
        return PasswordResponse::fromArray($response);
    }

    /**
     * Check whether the user's provided password is valid, and provide feedback on how to increase strength.
     *
     * @param array<string, mixed> $data
     * @return PasswordStrengthResponse
     */
    public function strengthCheck(array $data): PasswordStrengthResponse
    {
        $response = $this->client->post('/v1/b2b/passwords/strength_check', $data);
        return PasswordStrengthResponse::fromArray($response);
    }

    /**
     * Add an existing password to a Member's email that doesn't have a password yet.
     *
     * Supports migrating from bcrypt, scrypt, argon2, MD-5, SHA-1, and PBKDF2.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function migrate(array $data): array
    {
        return $this->client->post('/v1/b2b/passwords/migrate', $data);
    }
}
