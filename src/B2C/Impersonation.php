<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class Impersonation
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
    public function start(array $data): array
    {
        return $this->client->post('/v1/users/impersonate/start', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/users/impersonate/authenticate', $data);
    }
}
