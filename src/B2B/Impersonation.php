<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class Impersonation
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Authenticate an impersonation token to impersonate a member.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/b2b/impersonation/authenticate', $data);
    }


}
