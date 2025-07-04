<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class IDP
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
    public function introspectToken(array $data): array
    {
        return $this->client->post('/v1/idp/token/introspect', $data);
    }
}
