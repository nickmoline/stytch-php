<?php

namespace Stytch\B2B;

use Stytch\Shared\Client;

class Connection
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new SCIM connection.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function create(array $data): array
    {
        return $this->client->post('/v1/b2b/scim/connections', $data);
    }

    /**
     * Get a SCIM connection.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function get(array $data): array
    {
        return $this->client->get('/v1/b2b/scim/connections', $data);
    }

    /**
     * Update a SCIM connection.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function update(array $data): array
    {
        return $this->client->put('/v1/b2b/scim/connections', $data);
    }

    /**
     * Delete a SCIM connection.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function delete(array $data): array
    {
        return $this->client->delete('/v1/b2b/scim/connections', $data);
    }
}
