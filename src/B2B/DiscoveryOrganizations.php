<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class DiscoveryOrganizations
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create an organization via discovery.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function create(array $data): array
    {
        return $this->client->post('/v1/b2b/discovery/organizations/create', $data);
    }

    /**
     * List discovered organizations for a member.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function list(array $data): array
    {
        return $this->client->post('/v1/b2b/discovery/organizations/list', $data);
    }
}
