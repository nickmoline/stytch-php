<?php

namespace Stytch\B2C;

use Stytch\Objects\Response\M2MClient;
use Stytch\Objects\Response\M2MClientResponse;
use Stytch\Objects\Response\M2MClientsResponse;
use Stytch\Shared\Client;

class M2MClients
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create an M2M client.
     *
     * @param array<string, mixed> $data
     * @return M2MClientResponse
     */
    public function create(array $data): M2MClientResponse
    {
        $response = $this->client->post('/v1/m2m/clients', $data);
        return M2MClientResponse::fromArray($response);
    }

    /**
     * Get an M2M client by ID.
     *
     * @param string $clientId
     * @return M2MClientResponse
     */
    public function get(string $clientId): M2MClientResponse
    {
        $response = $this->client->get("/v1/m2m/clients/{$clientId}");
        return M2MClientResponse::fromArray($response);
    }

    /**
     * Update an M2M client.
     *
     * @param string $clientId
     * @param array<string, mixed> $data
     * @return M2MClientResponse
     */
    public function update(string $clientId, array $data): M2MClientResponse
    {
        $response = $this->client->put("/v1/m2m/clients/{$clientId}", $data);
        return M2MClientResponse::fromArray($response);
    }

    /**
     * Delete an M2M client.
     *
     * @param string $clientId
     * @return array<string, mixed>
     */
    public function delete(string $clientId): array
    {
        return $this->client->delete("/v1/m2m/clients/{$clientId}");
    }

    /**
     * Search M2M clients.
     *
     * @param array<string, mixed> $data
     * @return M2MClientsResponse
     */
    public function search(array $data): M2MClientsResponse
    {
        $response = $this->client->post('/v1/m2m/clients/search', $data);
        return M2MClientsResponse::fromArray($response);
    }
}
