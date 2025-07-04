<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class MagicLinks
{
    protected Client $client;
    public MagicLinksEmail $email;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->email = new MagicLinksEmail($client);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/magic_links/authenticate', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function create(array $data): array
    {
        return $this->client->post('/v1/magic_links', $data);
    }
}
