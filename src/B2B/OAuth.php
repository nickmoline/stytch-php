<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class OAuth
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Authenticate a given OAuth token.
     *
     * This endpoint verifies that the member completed the flow by verifying that the token is valid and hasn't expired.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/b2b/oauth/authenticate', $data);
    }
}
