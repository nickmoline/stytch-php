<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class Discovery
{
    protected Client $client;
    public DiscoveryOrganizations $organizations;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->organizations = new DiscoveryOrganizations($client);
    }
}
