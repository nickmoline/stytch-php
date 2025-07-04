<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class Passwords
{
    protected Client $client;
    public PasswordsEmail $email;
    public PasswordsExistingPassword $existingPassword;
    public PasswordsSession $sessions;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->email = new PasswordsEmail($client);
        $this->existingPassword = new PasswordsExistingPassword($client);
        $this->sessions = new PasswordsSession($client);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function create(array $data): array
    {
        return $this->client->post('/v1/passwords', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/passwords/authenticate', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function strengthCheck(array $data): array
    {
        return $this->client->post('/v1/passwords/strength_check', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function migrate(array $data): array
    {
        return $this->client->post('/v1/passwords/migrate', $data);
    }
}
