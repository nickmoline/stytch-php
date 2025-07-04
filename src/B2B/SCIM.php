<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class SCIM
{
    protected Client $client;
    public Connection $connection;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->connection = new Connection($client);
    }
}
