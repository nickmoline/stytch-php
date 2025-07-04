<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class IDP
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Introspect a token to get its claims and validate it.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function introspectToken(array $data): array
    {
        return $this->client->post('/v1/b2b/idp/introspect_token', $data);
    }


}
