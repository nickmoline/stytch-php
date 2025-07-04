<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class Sessions
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
    public function get(array $data): array
    {
        return $this->client->get('/v1/sessions', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/sessions/authenticate', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function revoke(array $data): array
    {
        return $this->client->post('/v1/sessions/revoke', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function migrate(array $data): array
    {
        return $this->client->post('/v1/sessions/migrate', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function exchangeAccessToken(array $data): array
    {
        return $this->client->post('/v1/sessions/exchange_access_token', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function getJWKS(array $data): array
    {
        return $this->client->get('/v1/sessions/jwks', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticateJwt(array $data): array
    {
        return $this->client->post('/v1/sessions/authenticate_jwt', $data);
    }
}
