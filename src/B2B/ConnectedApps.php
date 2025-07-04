<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class ConnectedApps
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Revoke a connected app's access to a member.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function revoke(array $data): array
    {
        return $this->client->post('/v1/b2b/organizations/members/connected_apps/revoke', $data);
    }
}
