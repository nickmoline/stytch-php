<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class SSO
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Authenticate an SSO token.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function authenticate(array $data): array
    {
        return $this->client->post('/v1/b2b/sso/authenticate', $data);
    }

    /**
     * Get all SSO connections for an organization.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function getConnections(array $data): array
    {
        return $this->client->get('/v1/b2b/sso/connections', $data);
    }

    /**
     * Delete an SSO connection.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function deleteConnection(array $data): array
    {
        return $this->client->delete('/v1/b2b/sso/connections', $data);
    }
}
