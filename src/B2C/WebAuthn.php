<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class WebAuthn
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
    public function registerStart(array $data): array
    {
        return $this->client->post('/v1/webauthn/register/start', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function register(array $data): array
    {
        return $this->client->post('/v1/webauthn/register', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticateStart(array $data): array
    {
        return $this->client->post('/v1/webauthn/authenticate/start', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/webauthn/authenticate', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function updateStart(array $data): array
    {
        return $this->client->post('/v1/webauthn/update/start', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function update(array $data): array
    {
        return $this->client->post('/v1/webauthn/update', $data);
    }
}
