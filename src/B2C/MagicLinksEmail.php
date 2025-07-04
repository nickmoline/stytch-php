<?php

namespace Stytch\B2C;

use Stytch\Shared\Client;

class MagicLinksEmail
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
    public function loginOrCreate(array $data): array
    {
        return $this->client->post('/v1/magic_links/email/login_or_create', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function invite(array $data): array
    {
        return $this->client->post('/v1/magic_links/email/invite', $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function revokeInvite(array $data): array
    {
        return $this->client->post('/v1/magic_links/email/revoke_invite', $data);
    }
}
