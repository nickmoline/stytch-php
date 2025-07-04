<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class TOTPs
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new TOTP registration for a member.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function create(array $data): array
    {
        return $this->client->post('/v1/b2b/totps/create', $data);
    }

    /**
     * Authenticate a TOTP code.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/b2b/totps/authenticate', $data);
    }

    /**
     * Migrate an existing TOTP secret and recovery codes.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function migrate(array $data): array
    {
        return $this->client->post('/v1/b2b/totps/migrate', $data);
    }
}
