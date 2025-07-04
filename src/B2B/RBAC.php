<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class RBAC
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the active RBAC Policy for your current Stytch Project.
     *
     * @return array<string, mixed>
     */
    public function policy(): array
    {
        return $this->client->get('/v1/b2b/rbac/policy');
    }


}
